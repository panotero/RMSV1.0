<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantActivity;
use App\Models\ApplicantChecklistItem;
use App\Models\ApplicantFile;
use App\Models\ApplicantNote;
use App\Models\ApplicantOrientation;
use App\Models\ApplicantOrientationHistory;
use App\Models\ChecklistGroup;
use App\Models\ChecklistItem;
use App\Models\LookupListItem;
use App\Models\RecruitmentForm;
use App\Models\RecruitmentFormField;
use App\Models\User;
use App\Services\TeamNotifier;
use App\Services\TeamService;
use App\Support\Exporter;
use App\Support\RoleHelper;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApplicantController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $perPage = $request->integer('per_page', 10);

        $query = $this->scopedQuery(Applicant::query(), $user, $request)
            ->with([
                'location:id,name',
                'assignee:id,name',
                'team:id,name',
            ])
            ->select([
                'id',
                'full_name',
                'status',
                'location_id',
                'assigned_to',
                'team_id',
                'created_at',
                'last_activity_at',
            ]);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('full_name', 'like', "%{$search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $applicants = $query
            ->orderByDesc('last_activity_at')
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json(['success' => true, 'data' => $applicants]);
    }

    public function formConfig()
    {
        $form = RecruitmentForm::where('is_active', true)->firstOrFail();

        $territories = LookupListItem::whereHas('list', function (Builder $q) {
                $q->where('key', 'territory');
            })
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->with(['children' => function ($q) {
                $q->where('is_active', true);
            }])
            ->orderBy('order')
            ->get()
            ->map(fn (LookupListItem $territory) => [
                'id' => $territory->id,
                'name' => $territory->name,
                'locations' => $territory->children->map(fn (LookupListItem $location) => [
                    'id' => $location->id,
                    'name' => $location->name,
                ])->values(),
            ])
            ->values();

        $fields = RecruitmentFormField::where('form_id', $form->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        // Resolve each lookup-list-sourced field's options in one query per
        // distinct list, rather than one per field.
        $listIds = $fields->pluck('options_source_list_id')->filter()->unique()->values();

        $optionsByListId = LookupListItem::whereIn('lookup_list_id', $listIds)
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->groupBy('lookup_list_id')
            ->map(fn ($items) => $items->pluck('name')->values());

        $fields = $fields
            ->map(function (RecruitmentFormField $field) use ($optionsByListId) {
                $options = $field->options_source_list_id
                    ? ($optionsByListId->get($field->options_source_list_id) ?? collect())->values()
                    : $field->options;

                return [
                    'id' => $field->id,
                    'field_key' => $field->field_key,
                    'label' => $field->label,
                    'type' => $field->type,
                    'options' => $options,
                    'is_required' => $field->is_required,
                    'order' => $field->order,
                    'file_rules' => $field->file_rules,
                    'help_text' => $field->help_text,
                    'condition_field_key' => $field->condition_field_key,
                    'condition_value' => $field->condition_value,
                ];
            })
            ->values();

        $roles = LookupListItem::whereHas('list', function (Builder $q) {
                $q->where('key', 'role');
            })
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(fn (LookupListItem $role) => [
                'id' => $role->id,
                'name' => $role->name,
            ])
            ->values();

        $sources = LookupListItem::whereHas('list', function (Builder $q) {
                $q->where('key', 'source');
            })
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(fn (LookupListItem $source) => [
                'id' => $source->id,
                'name' => $source->name,
            ])
            ->values();

        return response()->json([
            'success' => true,
            'data' => [
                'form' => [
                    'id' => $form->id,
                    'version' => $form->version,
                ],
                'territories' => $territories,
                'roles' => $roles,
                'sources' => $sources,
                'fields' => $fields,
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string'],
            'role_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
            'source_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
            'source_detail' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string'],
            'date_of_birth' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $user = Auth::user();

        $form = RecruitmentForm::where('is_active', true)->firstOrFail();

        $applicant = DB::transaction(function () use ($request, $form, $user) {
            $applicant = Applicant::create([
                'full_name' => $request->input('full_name'),
                'role_id' => $request->input('role_id'),
                'source_id' => $request->input('source_id'),
                'source_detail' => $request->input('source_detail'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'date_of_birth' => $request->input('date_of_birth'),
                'status' => 'New',
                'assigned_to' => $user->id,
                'team_id' => $user->team_id,
                'form_id' => $form->id,
                'form_version' => $form->version,
                'form_data' => [],
                'last_activity_at' => now(),
            ]);

            $notes = $request->input('notes');

            if (is_string($notes) && trim($notes) !== '') {
                ApplicantNote::create([
                    'applicant_id' => $applicant->id,
                    'note' => $notes,
                    'created_by' => $user->id,
                ]);
            }

            return $applicant;
        });

        $this->logActivity($applicant, 'created', "{$user->name} added this applicant");

        TeamNotifier::notify(TeamNotifier::directLeaderIds($user), [
            'title' => 'New applicant added',
            'message' => $user->name.' added applicant '.$applicant->full_name.'.',
            'from_user_id' => $user->id,
            'link' => [
                'title' => 'View applicant',
                'url' => '/page_applicants',
            ],
        ]);

        return response()->json(['success' => true, 'data' => ['id' => $applicant->id]]);
    }

    public function interview($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $incomplete = $request->boolean('incomplete');

        $validator = Validator::make($request->all(), [
            'outcome' => [$incomplete ? 'nullable' : 'required', 'string', 'in:pass,fail'],
            'incomplete' => ['nullable', 'boolean'],
            'territory_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
            'location_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $territoryId = $request->input('territory_id');
        $locationId = $request->input('location_id');

        // Incomplete interview: reject the applicant without saving any of
        // the form answers/files collected so far, and without touching the
        // checklist.
        if ($incomplete) {
            DB::transaction(function () use ($applicant, $territoryId, $locationId) {
                $applicant->status = 'Rejected';
                $applicant->territory_id = $territoryId;
                $applicant->location_id = $locationId;
                $applicant->interview_date = now();
                $applicant->last_activity_at = now();
                $applicant->save();
            });

            $this->logActivity($applicant, 'interview_incomplete_rejected', "{$user->name} submitted an incomplete interview; applicant rejected");

            return response()->json([
                'success' => true,
                'data' => [
                    'status' => $applicant->status,
                    'checklist' => $this->checklistPayload($applicant->fresh()),
                ],
            ]);
        }

        $formData = $request->input('form_data', []);

        if (is_string($formData)) {
            $formData = json_decode($formData, true) ?? [];
        }

        $form = RecruitmentForm::where('is_active', true)->firstOrFail();

        $activeFields = RecruitmentFormField::where('form_id', $form->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        $missing = [];

        foreach ($activeFields as $field) {
            if (!$field->is_required) {
                continue;
            }

            if ($field->condition_field_key !== null) {
                $controllingValue = $formData[$field->condition_field_key] ?? null;

                if ((string) $controllingValue !== (string) $field->condition_value) {
                    continue;
                }
            }

            if ($field->type === 'file') {
                if (!$request->hasFile("files.{$field->field_key}")) {
                    $missing[$field->field_key] = "The {$field->label} field is required.";
                }

                continue;
            }

            $value = $formData[$field->field_key] ?? null;

            if ($value === null || $value === '' || (is_array($value) && count($value) === 0)) {
                $missing[$field->field_key] = "The {$field->label} field is required.";
            }
        }

        if (!empty($missing)) {
            return response()->json([
                'success' => false,
                'message' => 'Please complete all required fields.',
                'invalid_fields' => $missing,
            ], 422);
        }

        $outcome = $request->input('outcome');

        DB::transaction(function () use ($request, $applicant, $formData, $form, $activeFields, $outcome, $territoryId, $locationId) {
            $applicant->form_data = $formData;
            $applicant->form_id = $form->id;
            $applicant->form_version = $form->version;
            $applicant->status = $outcome === 'pass' ? 'Passed' : 'Rejected';
            $applicant->territory_id = $territoryId;
            $applicant->location_id = $locationId;
            $applicant->interview_date = now();
            $applicant->last_activity_at = now();
            $applicant->save();

            foreach ($activeFields as $field) {
                if ($field->type !== 'file') {
                    continue;
                }

                $file = $request->file("files.{$field->field_key}");

                if (!$file) {
                    continue;
                }

                $path = $file->store('applicant_files', 'public');

                ApplicantFile::create([
                    'applicant_id' => $applicant->id,
                    'field_key' => $field->field_key,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }

            if ($outcome === 'pass') {
                $this->attachMissingChecklistItems($applicant);
            }
        });

        if ($outcome === 'pass') {
            $this->logActivity($applicant, 'interview_passed', "{$user->name} passed the interview");
        } else {
            $this->logActivity($applicant, 'interview_failed', "{$user->name} failed the interview");
        }

        return response()->json([
            'success' => true,
            'data' => [
                'status' => $applicant->status,
                'checklist' => $this->checklistPayload($applicant->fresh()),
            ],
        ]);
    }

    public function interviewSummary($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'interview_summary' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $applicant->interview_summary = $request->input('interview_summary');
        $applicant->save();

        return response()->json(['success' => true, 'data' => ['interview_summary' => $applicant->interview_summary]]);
    }

    public function notes($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $notes = $applicant->notes()
            ->with('creator:id,name')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn (ApplicantNote $note) => [
                'id' => $note->id,
                'note' => $note->note,
                'created_by_name' => $note->creator?->name,
                'created_at' => $note->created_at,
            ]);

        return response()->json(['success' => true, 'data' => $notes]);
    }

    public function storeNote($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'note' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $note = ApplicantNote::create([
            'applicant_id' => $applicant->id,
            'note' => $request->input('note'),
            'created_by' => Auth::id(),
        ]);

        $note->load('creator:id,name');

        $this->logActivity($applicant, 'note_added', "{$user->name} added a note");

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $note->id,
                'note' => $note->note,
                'created_by_name' => $note->creator?->name,
                'created_at' => $note->created_at,
            ],
        ]);
    }

    /**
     * Full activity/history feed for a single applicant, newest first.
     */
    public function activity($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $activities = $applicant->activities()
            ->with('actor:id,name')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get()
            ->map(fn (ApplicantActivity $activity) => [
                'id' => $activity->id,
                'type' => $activity->type,
                'description' => $activity->description,
                'actor_name' => $activity->actor?->name,
                'created_at' => $activity->created_at,
            ]);

        return response()->json(['success' => true, 'data' => $activities]);
    }

    /**
     * Corrective edit of an applicant's core info fields (name, role,
     * source, territory/location, contact details) - not a status change,
     * not tied to the interview flow.
     */
    public function updateInfo($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => ['required', 'string'],
            'role_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
            'source_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
            'source_detail' => ['nullable', 'string'],
            'location_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
            'territory_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
            'phone' => ['nullable', 'string'],
            'email' => ['nullable', 'email'],
            'date_of_birth' => ['nullable', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $applicant->fill($validator->validated());
        $applicant->last_activity_at = now();
        $applicant->save();

        $this->logActivity($applicant, 'info_updated', "{$user->name} updated applicant info");

        return response()->json(['success' => true, 'data' => ['id' => $applicant->id]]);
    }

    /**
     * Corrective edit of an applicant's submitted interview answers/files -
     * a partial save is fine (no required-field enforcement), never touches
     * status, and merges newly uploaded files rather than replacing the
     * whole set.
     */
    public function updateAnswers($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $formData = $request->input('form_data', []);

        if (is_string($formData)) {
            $formData = json_decode($formData, true) ?? [];
        }

        $form = RecruitmentForm::where('is_active', true)->firstOrFail();

        $activeFields = RecruitmentFormField::where('form_id', $form->id)
            ->where('is_active', true)
            ->orderBy('order')
            ->get();

        DB::transaction(function () use ($request, $applicant, $formData, $form, $activeFields) {
            $applicant->form_data = $formData;
            $applicant->form_id = $form->id;
            $applicant->form_version = $form->version;
            $applicant->last_activity_at = now();
            $applicant->save();

            foreach ($activeFields as $field) {
                if ($field->type !== 'file') {
                    continue;
                }

                $file = $request->file("files.{$field->field_key}");

                if (!$file) {
                    continue;
                }

                $path = $file->store('applicant_files', 'public');

                ApplicantFile::create([
                    'applicant_id' => $applicant->id,
                    'field_key' => $field->field_key,
                    'original_name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'mime' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        });

        $this->logActivity($applicant, 'answers_updated', "{$user->name} updated the application answers");

        return response()->json(['success' => true, 'data' => ['id' => $applicant->id]]);
    }

    public function saveOrientation($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'scheduled_date' => ['required', 'date'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $newDate = $request->input('scheduled_date');
        $existing = ApplicantOrientation::where('applicant_id', $applicant->id)->first();
        $dateActuallyChanged = !$existing || !$existing->scheduled_date->isSameDay($newDate);

        $orientation = ApplicantOrientation::updateOrCreate(
            ['applicant_id' => $applicant->id],
            array_filter([
                'scheduled_date' => $newDate,
                'scheduled_by' => Auth::id(),
                'status' => !$existing ? 'Scheduled' : ($dateActuallyChanged ? 'Rescheduled' : null),
            ], fn ($v) => $v !== null)
        );

        if ($dateActuallyChanged) {
            ApplicantOrientationHistory::create([
                'applicant_orientation_id' => $orientation->id,
                'event_type' => $existing ? 'rescheduled' : 'scheduled',
                'scheduled_date' => $newDate,
                'changed_by' => Auth::id(),
            ]);

            $this->logActivity(
                $applicant,
                $existing ? 'orientation_rescheduled' : 'orientation_scheduled',
                $existing
                    ? "{$user->name} rescheduled orientation to {$orientation->scheduled_date}"
                    : "{$user->name} scheduled orientation for {$orientation->scheduled_date}"
            );
        }

        $orientation->load('scheduler:id,name');

        return response()->json([
            'success' => true,
            'data' => [
                'scheduled_date' => $orientation->scheduled_date,
                'status' => $orientation->status,
                'scheduled_by_name' => $orientation->scheduler?->name,
            ],
        ]);
    }

    public function orientationDetail($orientationId, Request $request)
    {
        $user = Auth::user();

        $orientation = ApplicantOrientation::whereHas('applicant', fn (Builder $q) => $this->scopedQuery($q, $user, $request))
            ->with([
                'applicant:id,full_name,location_id,role_id',
                'applicant.location:id,name',
                'applicant.role:id,name',
                'scheduler:id,name',
                'history.changedBy:id,name',
            ])
            ->findOrFail($orientationId);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $orientation->id,
                'applicant_id' => $orientation->applicant_id,
                'applicant_name' => $orientation->applicant?->full_name,
                'location_name' => $orientation->applicant?->location?->name,
                'role_name' => $orientation->applicant?->role?->name,
                'scheduled_date' => $orientation->scheduled_date,
                'scheduled_date_raw' => $orientation->getRawOriginal('scheduled_date'),
                'status' => $orientation->status,
                'scheduled_by_name' => $orientation->scheduler?->name,
                'history' => $orientation->history->map(fn (ApplicantOrientationHistory $h) => [
                    'id' => $h->id,
                    'event_type' => $h->event_type,
                    'scheduled_date' => $h->scheduled_date,
                    'changed_by_name' => $h->changedBy?->name,
                    'created_at' => $h->created_at,
                ]),
            ],
        ]);
    }

    public function orientationsIndex(Request $request)
    {
        $user = Auth::user();

        $query = ApplicantOrientation::query()
            ->whereHas('applicant', fn (Builder $q) => $this->scopedQuery($q, $user, $request))
            ->with(['applicant:id,full_name,location_id', 'applicant.location:id,name', 'scheduler:id,name']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('applicant', fn (Builder $q) => $q->where('full_name', 'like', "%{$search}%"));
        }

        $transform = fn (ApplicantOrientation $orientation) => [
            'id' => $orientation->id,
            'scheduled_date' => $orientation->scheduled_date,
            'scheduled_date_raw' => $orientation->getRawOriginal('scheduled_date'),
            'status' => $orientation->status,
            'applicant_id' => $orientation->applicant_id,
            'applicant_name' => $orientation->applicant?->full_name,
            'location_name' => $orientation->applicant?->location?->name,
            'scheduled_by_name' => $orientation->scheduler?->name,
        ];

        // Calendar mode: a date range instead of pagination - the whole
        // range's rows at once so the month grid can place every event.
        if ($request->filled('from') && $request->filled('to')) {
            $rows = $query
                ->whereBetween('scheduled_date', [$request->input('from'), $request->input('to')])
                ->orderBy('scheduled_date')
                ->get()
                ->map($transform)
                ->values();

            return response()->json(['success' => true, 'mode' => 'calendar', 'data' => $rows]);
        }

        $perPage = $request->integer('per_page', 10);

        $paginator = $query
            ->orderByDesc('scheduled_date')
            ->orderByDesc('id')
            ->paginate($perPage);

        $paginator->getCollection()->transform($transform);

        return response()->json(['success' => true, 'data' => $paginator]);
    }

    public function show($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)
            ->with(['location:id,name', 'territory:id,name', 'role:id,name', 'source:id,name', 'assignee:id,name', 'team:id,name', 'orientation.scheduler:id,name'])
            ->findOrFail($id);

        $fields = RecruitmentFormField::where('form_id', $applicant->form_id)
            ->get()
            ->keyBy('field_key');

        $answers = collect($applicant->form_data ?? [])
            ->map(function ($value, $key) use ($fields) {
                $field = $fields->get($key);

                return [
                    'field_key' => $key,
                    'label' => $field->label ?? $key,
                    'type' => $field->type ?? 'text',
                    'value' => $value,
                    'options' => $field->options ?? null,
                    '_order' => $field->order ?? PHP_INT_MAX,
                ];
            })
            ->sortBy('_order')
            ->values()
            ->map(function ($answer) {
                unset($answer['_order']);

                return $answer;
            });

        $files = $applicant->files->map(fn (ApplicantFile $file) => [
            'id' => $file->id,
            'field_key' => $file->field_key,
            'original_name' => $file->original_name,
            'url' => Storage::url($file->path),
        ]);

        $checklist = $this->checklistPayload($applicant);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $applicant->id,
                'full_name' => $applicant->full_name,
                'status' => $applicant->status,
                'created_at' => $applicant->created_at,
                'last_activity_at' => $applicant->last_activity_at,
                'form_version' => $applicant->form_version,
                'location_id' => $applicant->location_id,
                'location_name' => $applicant->location?->name,
                'territory_id' => $applicant->territory_id,
                'territory_name' => $applicant->territory?->name,
                'role_id' => $applicant->role_id,
                'role_name' => $applicant->role?->name,
                'source_id' => $applicant->source_id,
                'source_name' => $applicant->source?->name,
                'source_detail' => $applicant->source_detail,
                'phone' => $applicant->phone,
                'email' => $applicant->email,
                'date_of_birth' => $applicant->date_of_birth,
                'interview_summary' => $applicant->interview_summary,
                'interview_date' => $applicant->interview_date,
                'has_answers' => !empty($applicant->form_data),
                'assignee_name' => $applicant->assignee?->name,
                'team_name' => $applicant->team?->name,
                'orientation' => $applicant->orientation ? [
                    'scheduled_date' => $applicant->orientation->scheduled_date,
                    'scheduled_by_name' => $applicant->orientation->scheduler?->name,
                ] : null,
                'answers' => $answers,
                'files' => $files,
                'checklist' => $checklist,
            ],
        ]);
    }

    public function statuses()
    {
        return response()->json(['success' => true, 'data' => Applicant::validStatuses()]);
    }

    public function updateStatus($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string', 'in:'.implode(',', Applicant::validStatuses())],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $new = $request->input('status');
        $old = $applicant->status;

        $applicant->status = $new;
        $applicant->last_activity_at = now();
        $applicant->save();

        $this->logActivity($applicant, 'status_changed', "{$user->name} changed status from {$old} to {$new}");

        if (in_array($new, ['Interview', 'Passed', 'Orientation'], true)) {
            $this->attachMissingChecklistItems($applicant);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'status' => $applicant->status,
                'checklist' => $this->checklistPayload($applicant->fresh()),
            ],
        ]);
    }

    public function toggleChecklistItem($id, $itemId, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'is_done' => ['required', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $item = ApplicantChecklistItem::where('applicant_id', $applicant->id)->findOrFail($itemId);

        if ($request->boolean('is_done')) {
            $item->is_done = true;
            $item->done_at = now();
            $item->done_by = Auth::id();
        } else {
            $item->is_done = false;
            $item->done_at = null;
            $item->done_by = null;
        }

        $item->save();

        $applicant->last_activity_at = now();
        $applicant->save();

        $item->load('checklistItem', 'doneBy:id,name');

        $this->logActivity(
            $applicant,
            $item->is_done ? 'checklist_item_checked' : 'checklist_item_unchecked',
            "{$user->name} ".($item->is_done ? 'checked' : 'unchecked')." '{$item->checklistItem?->label}'"
        );

        $advance = $item->is_done ? $this->maybeAdvanceStatusForGroup($applicant, $item) : null;

        if ($advance !== null) {
            $this->logActivity(
                $applicant,
                'status_changed',
                "Status auto-advanced to {$applicant->status} after completing the {$advance} checklist",
                null
            );
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $item->id,
                'checklist_item_id' => $item->checklist_item_id,
                'is_done' => $item->is_done,
                'done_at' => $item->done_at,
                'done_by' => $item->done_by,
                'done_by_name' => $item->doneBy?->name,
            ],
            'status' => $applicant->status,
            'status_advanced' => $advance !== null,
            'advanced_by_group' => $advance,
        ]);
    }

    /**
     * If $item just completed its checklist group for this applicant (every
     * active item in that group is now done), auto-advance the applicant's
     * status to the group's target_status. Never fires in the other
     * direction - unchecking an item never reverts a status that was
     * already reached. Returns the group's label if it advanced anything,
     * null otherwise (nothing to report to the caller).
     */
    private function maybeAdvanceStatusForGroup(Applicant $applicant, ApplicantChecklistItem $item): ?string
    {
        $checklistItem = $item->checklistItem;
        $groupId = $checklistItem?->checklist_group_id;

        if (!$groupId) {
            return null;
        }

        $group = ChecklistGroup::find($groupId);

        if (!$group || !$group->is_active) {
            return null;
        }

        $groupItemIds = ChecklistItem::where('checklist_group_id', $groupId)
            ->where('is_active', true)
            ->pluck('id');

        if ($groupItemIds->isEmpty()) {
            return null;
        }

        $doneCount = ApplicantChecklistItem::where('applicant_id', $applicant->id)
            ->whereIn('checklist_item_id', $groupItemIds)
            ->where('is_done', true)
            ->count();

        if ($doneCount !== $groupItemIds->count()) {
            return null;
        }

        if ($applicant->status === $group->target_status) {
            return null;
        }

        $applicant->status = $group->target_status;
        $applicant->last_activity_at = now();
        $applicant->save();

        return $group->label;
    }

    /**
     * Idempotent: attach every active ChecklistItem not already attached to
     * this applicant. Safe to call repeatedly over an applicant's life
     * (status can revisit Interview/Orientation, or new checklist items can
     * be added later) - never duplicates an existing row.
     */
    private function attachMissingChecklistItems(Applicant $applicant): void
    {
        $activeItemIds = ChecklistItem::where('is_active', true)->pluck('id');

        if ($activeItemIds->isEmpty()) {
            return;
        }

        $existingItemIds = ApplicantChecklistItem::where('applicant_id', $applicant->id)
            ->whereIn('checklist_item_id', $activeItemIds)
            ->pluck('checklist_item_id');

        $missingItemIds = $activeItemIds->diff($existingItemIds);

        if ($missingItemIds->isEmpty()) {
            return;
        }

        $now = now();

        $rows = $missingItemIds
            ->map(fn ($itemId) => [
                'applicant_id' => $applicant->id,
                'checklist_item_id' => $itemId,
                'is_done' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ])
            ->values()
            ->all();

        ApplicantChecklistItem::insert($rows);
    }

    /**
     * Aggregate counts/trends for the dashboard, scoped the same way as the
     * applicants list (superadmin all, leader team-wide/mine, member team,
     * teamless own).
     */
    public function dashboardSummary(Request $request)
    {
        $user = Auth::user();
        $scope = fn () => $this->scopedQuery(Applicant::query(), $user, $request);

        $statuses = Applicant::validStatuses();

        $statusCounts = $scope()
            ->select('status', DB::raw('count(*) as cnt'))
            ->groupBy('status')
            ->pluck('cnt', 'status');

        $byStatus = collect($statuses)
            ->map(fn ($status) => ['status' => $status, 'count' => (int) ($statusCounts[$status] ?? 0)])
            ->values();

        $total = (int) $statusCounts->sum();
        $hired = (int) ($statusCounts['Hired'] ?? 0);
        $rejected = (int) ($statusCounts['Rejected'] ?? 0);

        $newThisWeek = $scope()->where('created_at', '>=', now()->subDays(7))->count();

        $pendingChecklist = $scope()
            ->whereHas('checklistItems', fn ($q) => $q->where('is_done', false))
            ->count();

        $upcomingOrientationsCount = $scope()
            ->whereHas('orientation', fn ($q) => $q->whereBetween('scheduled_date', [now(), now()->addDays(7)]))
            ->count();

        $trendRaw = $scope()
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->select(DB::raw('DATE(created_at) as d'), DB::raw('count(*) as cnt'))
            ->groupBy('d')
            ->pluck('cnt', 'd');

        $trend = collect(range(0, 29))
            ->map(function ($i) use ($trendRaw) {
                $date = now()->subDays(29 - $i)->format('Y-m-d');

                return ['date' => $date, 'count' => (int) ($trendRaw[$date] ?? 0)];
            })
            ->values();

        $byTerritory = $scope()
            ->whereNotNull('location_id')
            ->with('location.parent:id,name')
            ->get(['id', 'location_id'])
            ->groupBy(fn (Applicant $a) => $a->location?->parent?->name ?? $a->location?->name ?? 'Unspecified')
            ->map->count()
            ->sortDesc()
            ->take(8)
            ->map(fn ($count, $name) => ['name' => $name, 'count' => $count])
            ->values();

        $upcomingOrientations = $scope()
            ->whereHas('orientation', fn ($q) => $q->where('scheduled_date', '>=', now()))
            ->with(['orientation', 'location:id,name'])
            ->get()
            ->sortBy(fn (Applicant $a) => $a->orientation->getRawOriginal('scheduled_date'))
            ->take(5)
            ->map(fn (Applicant $a) => [
                'applicant_id' => $a->id,
                'full_name' => $a->full_name,
                'location_name' => $a->location->name ?? null,
                'scheduled_date' => (string) $a->orientation->scheduled_date,
                'status' => $a->orientation->status,
            ])
            ->values();

        $recentApplicants = $scope()
            ->with('location:id,name')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->take(5)
            ->get(['id', 'full_name', 'status', 'location_id', 'created_at'])
            ->map(fn (Applicant $a) => [
                'id' => $a->id,
                'full_name' => $a->full_name,
                'status' => $a->status,
                'location_name' => $a->location->name ?? null,
                'created_at' => (string) $a->created_at,
            ])
            ->values();

        $teamCounts = [
            'total_users' => (int) User::count(),
            'total_teams' => (int) \App\Models\Team::count(),
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'counts' => [
                    'total_applicants' => $total,
                    'new_this_week' => $newThisWeek,
                    'in_pipeline' => max($total - $hired - $rejected, 0),
                    'hired' => $hired,
                    'rejected' => $rejected,
                    'pending_checklist' => $pendingChecklist,
                    'upcoming_orientations_7d' => $upcomingOrientationsCount,
                ],
                'by_status' => $byStatus,
                'by_territory' => $byTerritory,
                'trend_30d' => $trend,
                'upcoming_orientations' => $upcomingOrientations,
                'recent_applicants' => $recentApplicants,
                'team' => $teamCounts,
            ],
        ]);
    }

    /**
     * Export the (visibility-scoped) applicant list created within a date
     * range as csv/xlsx/pdf.
     */
    public function export(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'format' => ['nullable', 'string'],
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d'],
            'status' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $fromRaw = $request->input('from');
        $toRaw = $request->input('to');
        $from = Carbon::parse($fromRaw)->startOfDay();
        $to = Carbon::parse($toRaw)->endOfDay();

        $statuses = $request->filled('status')
            ? array_values(array_filter(array_map('trim', explode(',', $request->input('status')))))
            : [];

        $applicants = $this->scopedQuery(Applicant::query(), $user, $request)
            ->whereBetween('created_at', [$from, $to])
            ->when(!empty($statuses), fn (Builder $q) => $q->whereIn('status', $statuses))
            ->with(['role:id,name', 'source:id,name', 'territory:id,name', 'location:id,name'])
            ->orderByDesc('created_at')
            ->get();

        $headers = [
            'Interview Date',
            'Applicant Name',
            'Status',
            'Role',
            'Source',
            'Territory',
            'Location',
            'Phone Number',
            'Email',
            'Date of Birth',
            'Interview Summary',
        ];

        $rows = $applicants->map(function (Applicant $applicant) {
            $source = $applicant->source?->name;

            if ($source && $applicant->source_detail) {
                $source .= ' — '.$applicant->source_detail;
            }

            return [
                $applicant->interview_date ? (string) $applicant->interview_date : '',
                $applicant->full_name,
                $applicant->status,
                $applicant->role?->name,
                $source,
                $applicant->territory?->name,
                $applicant->location?->name,
                $applicant->phone,
                $applicant->email,
                $applicant->date_of_birth ? (string) $applicant->date_of_birth : '',
                $applicant->interview_summary,
            ];
        })->all();

        $filename = "applicants_{$fromRaw}_to_{$toRaw}";

        return Exporter::respond($request->input('format', 'csv'), $filename, $headers, $rows);
    }

    /**
     * Export scheduled orientations within a date range as csv/xlsx/pdf,
     * mirroring orientationsIndex()'s scoping exactly.
     */
    public function orientationExport(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'format' => ['nullable', 'string'],
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $fromRaw = $request->input('from');
        $toRaw = $request->input('to');
        $from = Carbon::parse($fromRaw)->startOfDay();
        $to = Carbon::parse($toRaw)->endOfDay();

        $orientations = ApplicantOrientation::query()
            ->whereHas('applicant', fn (Builder $q) => $this->scopedQuery($q, $user, $request))
            ->with([
                'applicant:id,full_name,phone,email,location_id,territory_id',
                'applicant.location:id,name',
                'applicant.territory:id,name',
                'scheduler:id,name',
            ])
            ->whereBetween('scheduled_date', [$from, $to])
            ->orderBy('scheduled_date')
            ->get();

        $headers = [
            'Applicant Name',
            'Phone',
            'Email',
            'Schedule Date',
            'Territory',
            'Location',
            'Status',
            'Scheduled By',
        ];

        $rows = $orientations->map(fn (ApplicantOrientation $orientation) => [
            $orientation->applicant?->full_name,
            $orientation->applicant?->phone,
            $orientation->applicant?->email,
            $orientation->scheduled_date ? (string) $orientation->scheduled_date : '',
            $orientation->applicant?->territory?->name,
            $orientation->applicant?->location?->name,
            $orientation->status,
            $orientation->scheduler?->name,
        ])->all();

        $filename = "orientations_{$fromRaw}_to_{$toRaw}";

        return Exporter::respond($request->input('format', 'csv'), $filename, $headers, $rows);
    }

    /**
     * Append a row to this applicant's activity/history feed.
     */
    private function logActivity(Applicant $applicant, string $type, string $description, ?int $actorId = null): void
    {
        ApplicantActivity::create([
            'applicant_id' => $applicant->id,
            'type' => $type,
            'description' => $description,
            'actor_id' => $actorId ?? Auth::id(),
        ]);
    }

    /**
     * Apply visibility scoping to an Applicant query based on the current
     * user's role/team standing.
     */
    private function scopedQuery(Builder $query, User $user, Request $request): Builder
    {
        if (RoleHelper::roleName($user) === 'superadmin') {
            return $query;
        }

        if (!$user->team_id) {
            return $query->where('assigned_to', $user->id);
        }

        if ($user->is_team_leader) {
            if ($request->query('scope') === 'mine') {
                return $query->where('assigned_to', $user->id);
            }

            return $query->whereIn('team_id', TeamService::accessibleTeamIds($user)->all());
        }

        return $query->where('team_id', $user->team_id);
    }

    /**
     * Shared checklist response shape used by show() and updateStatus().
     */
    private function checklistPayload(Applicant $applicant): array
    {
        return $applicant->checklistItems()
            ->with(['checklistItem.group', 'doneBy:id,name'])
            ->get()
            ->sortBy(fn (ApplicantChecklistItem $item) => $item->checklistItem->order ?? PHP_INT_MAX)
            ->values()
            ->map(fn (ApplicantChecklistItem $item) => [
                'id' => $item->id,
                'checklist_item_id' => $item->checklist_item_id,
                'label' => $item->checklistItem->label ?? null,
                'order' => $item->checklistItem->order ?? null,
                'checklist_group_id' => $item->checklistItem->checklist_group_id ?? null,
                'group_label' => $item->checklistItem->group->label ?? null,
                'group_target_status' => $item->checklistItem->group->target_status ?? null,
                'is_done' => $item->is_done,
                'done_at' => $item->done_at,
                'done_by' => $item->done_by,
                'done_by_name' => $item->doneBy?->name,
            ])
            ->all();
    }
}

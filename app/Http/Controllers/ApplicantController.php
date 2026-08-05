<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantChecklistItem;
use App\Models\ApplicantFile;
use App\Models\ApplicantNote;
use App\Models\ApplicantOrientation;
use App\Models\ChecklistGroup;
use App\Models\ChecklistItem;
use App\Models\LookupListItem;
use App\Models\RecruitmentForm;
use App\Models\RecruitmentFormField;
use App\Models\User;
use App\Services\TeamNotifier;
use App\Support\RoleHelper;
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
            'location_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
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
                'location_id' => $request->input('location_id'),
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

        $validator = Validator::make($request->all(), [
            'outcome' => ['required', 'string', 'in:pass,fail'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
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

        DB::transaction(function () use ($request, $applicant, $formData, $form, $activeFields, $outcome) {
            $applicant->form_data = $formData;
            $applicant->form_id = $form->id;
            $applicant->form_version = $form->version;
            $applicant->status = $outcome === 'pass' ? 'Passed' : 'Rejected';
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

        $orientation = ApplicantOrientation::updateOrCreate(
            ['applicant_id' => $applicant->id],
            [
                'scheduled_date' => $request->input('scheduled_date'),
                'scheduled_by' => Auth::id(),
            ]
        );

        $orientation->load('scheduler:id,name');

        return response()->json([
            'success' => true,
            'data' => [
                'scheduled_date' => $orientation->scheduled_date,
                'scheduled_by_name' => $orientation->scheduler?->name,
            ],
        ]);
    }

    public function orientationsIndex(Request $request)
    {
        $user = Auth::user();

        $perPage = $request->integer('per_page', 10);

        $query = ApplicantOrientation::query()
            ->whereHas('applicant', fn (Builder $q) => $this->scopedQuery($q, $user, $request))
            ->with(['applicant:id,full_name,location_id', 'applicant.location:id,name', 'scheduler:id,name']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('applicant', fn (Builder $q) => $q->where('full_name', 'like', "%{$search}%"));
        }

        $paginator = $query
            ->orderByDesc('scheduled_date')
            ->orderByDesc('id')
            ->paginate($perPage);

        $paginator->getCollection()->transform(fn (ApplicantOrientation $orientation) => [
            'id' => $orientation->id,
            'scheduled_date' => $orientation->scheduled_date,
            'applicant_id' => $orientation->applicant_id,
            'applicant_name' => $orientation->applicant?->full_name,
            'location_name' => $orientation->applicant?->location?->name,
            'scheduled_by_name' => $orientation->scheduler?->name,
        ]);

        return response()->json(['success' => true, 'data' => $paginator]);
    }

    public function show($id, Request $request)
    {
        $user = Auth::user();

        $applicant = $this->scopedQuery(Applicant::query(), $user, $request)
            ->with(['location:id,name', 'role:id,name', 'source:id,name', 'assignee:id,name', 'team:id,name', 'orientation.scheduler:id,name'])
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
                'location_name' => $applicant->location?->name,
                'role_name' => $applicant->role?->name,
                'source_name' => $applicant->source?->name,
                'phone' => $applicant->phone,
                'email' => $applicant->email,
                'date_of_birth' => $applicant->date_of_birth,
                'interview_summary' => $applicant->interview_summary,
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

        $applicant->status = $new;
        $applicant->last_activity_at = now();
        $applicant->save();

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

        $item->load('doneBy:id,name');

        $advance = $item->is_done ? $this->maybeAdvanceStatusForGroup($applicant, $item) : null;

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

            return $query->where('team_id', $user->team_id);
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

<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantChecklistItem;
use App\Models\ChecklistGroup;
use App\Models\ChecklistItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ChecklistItemController extends Controller
{
    public function index()
    {
        $items = ChecklistItem::orderBy('order', 'asc')->get();

        return response()->json(['success' => true, 'data' => $items]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => ['required', 'string'],
            'checklist_group_id' => ['nullable', 'integer', 'exists:checklist_groups,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $maxOrder = ChecklistItem::where('checklist_group_id', $data['checklist_group_id'] ?? null)->max('order');

        $item = ChecklistItem::create([
            'label' => $data['label'],
            'checklist_group_id' => $data['checklist_group_id'] ?? null,
            'order' => ($maxOrder ?? 0) + 1,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return response()->json(['success' => true, 'data' => $item]);
    }

    public function update(Request $request, $id)
    {
        $item = ChecklistItem::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'label' => ['nullable', 'string'],
            'checklist_group_id' => ['nullable', 'integer', 'exists:checklist_groups,id'],
            'order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $update = [];

        if (array_key_exists('label', $data) && $data['label'] !== null) {
            $update['label'] = $data['label'];
        }

        if ($request->has('checklist_group_id')) {
            $update['checklist_group_id'] = $data['checklist_group_id'];
        }

        if (array_key_exists('order', $data) && $data['order'] !== null) {
            $update['order'] = $data['order'];
        }

        if ($request->has('is_active')) {
            $update['is_active'] = $data['is_active'];
        }

        $item->update($update);

        return response()->json(['success' => true, 'data' => $item]);
    }

    public function destroy($id)
    {
        $item = ChecklistItem::findOrFail($id);

        $inUse = ApplicantChecklistItem::where('checklist_item_id', $id)->exists();

        if ($inUse) {
            return response()->json([
                'success' => false,
                'message' => 'This checklist item is already in use by applicants and cannot be deleted. Deactivate it instead.',
            ], 422);
        }

        $item->delete();

        return response()->json(['success' => true]);
    }

    public function indexGroups()
    {
        $groups = ChecklistGroup::orderBy('order', 'asc')->get();

        return response()->json(['success' => true, 'data' => $groups]);
    }

    public function storeGroup(Request $request)
    {
        $allowedStatuses = Applicant::validStatuses();

        $validator = Validator::make($request->all(), [
            'label' => ['required', 'string'],
            'target_status' => ['required', 'string', Rule::in($allowedStatuses)],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $maxOrder = ChecklistGroup::max('order');

        $group = ChecklistGroup::create([
            'label' => $data['label'],
            'target_status' => $data['target_status'],
            'order' => ($maxOrder ?? 0) + 1,
            'is_active' => $request->has('is_active') ? $request->boolean('is_active') : true,
        ]);

        return response()->json(['success' => true, 'data' => $group]);
    }

    public function updateGroup(Request $request, $id)
    {
        $group = ChecklistGroup::findOrFail($id);

        $allowedStatuses = Applicant::validStatuses();

        $validator = Validator::make($request->all(), [
            'label' => ['nullable', 'string'],
            'target_status' => ['nullable', 'string', Rule::in($allowedStatuses)],
            'order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $update = [];

        foreach (['label', 'target_status', 'order'] as $key) {
            if (array_key_exists($key, $data) && $data[$key] !== null) {
                $update[$key] = $data[$key];
            }
        }

        if ($request->has('is_active')) {
            $update['is_active'] = $data['is_active'];
        }

        $group->update($update);

        return response()->json(['success' => true, 'data' => $group]);
    }

    public function destroyGroup($id)
    {
        $group = ChecklistGroup::findOrFail($id);

        if (ChecklistItem::where('checklist_group_id', $id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Move or delete this group\'s checklist items before deleting the group.',
            ], 422);
        }

        $group->delete();

        return response()->json(['success' => true]);
    }
}

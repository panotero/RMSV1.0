<?php

namespace App\Http\Controllers;

use App\Models\LookupList;
use App\Models\LookupListItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LookupListController extends Controller
{
    public function index()
    {
        $lists = LookupList::with(['items' => function ($query) {
            $query->orderBy('order', 'asc');
        }])->get(['id', 'key', 'label', 'child_label']);

        return response()->json(['success' => true, 'data' => $lists]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'label' => ['required', 'string'],
            'child_label' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();
        $label = $data['label'];

        $baseKey = Str::slug($label, '_');
        $key = $baseKey;
        $suffix = 2;

        while (LookupList::where('key', $key)->exists()) {
            $key = $baseKey.'_'.$suffix;
            $suffix++;
        }

        $list = LookupList::create([
            'key' => $key,
            'label' => $label,
            'child_label' => $data['child_label'] ?? null,
        ]);

        return response()->json(['success' => true, 'data' => $list->setRelation('items', collect())]);
    }

    public function storeItem(Request $request, $listId)
    {
        LookupList::findOrFail($listId);

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string'],
            'parent_id' => ['nullable', 'integer', 'exists:lookup_list_items,id'],
            'children' => ['nullable', 'array'],
            'children.*' => ['string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $parentId = $request->input('parent_id');

        if ($parentId) {
            $parent = LookupListItem::where('id', $parentId)
                ->where('lookup_list_id', $listId)
                ->first();

            if (!$parent) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid input detected.',
                    'invalid_fields' => ['parent_id' => ['Parent must belong to the same list.']],
                ], 422);
            }

            if ($parent->parent_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid input detected.',
                    'invalid_fields' => ['parent_id' => ['A sub-item cannot itself have children.']],
                ], 422);
            }
        }

        $maxOrder = LookupListItem::where('lookup_list_id', $listId)
            ->where('parent_id', $parentId)
            ->max('order');

        $item = LookupListItem::create([
            'lookup_list_id' => $listId,
            'parent_id' => $parentId,
            'name' => $request->input('name'),
            'order' => ($maxOrder ?? 0) + 1,
            'is_active' => true,
        ]);

        // Children only make sense on a top-level item - a sub-item can't
        // itself have children in this 2-level design (already enforced
        // above for the item being created).
        if (!$parentId) {
            $this->appendChildren($item, $request->input('children', []));
        }

        return response()->json(['success' => true, 'data' => $item->fresh('children')]);
    }

    public function updateItem(Request $request, $itemId)
    {
        $item = LookupListItem::findOrFail($itemId);

        $validator = Validator::make($request->all(), [
            'name' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'children' => ['nullable', 'array'],
            'children.*' => ['string'],
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

        if (array_key_exists('name', $data) && $data['name'] !== null) {
            $update['name'] = $data['name'];
        }

        if (array_key_exists('is_active', $data) && $request->has('is_active')) {
            $update['is_active'] = $data['is_active'];
        }

        $item->update($update);

        // "children" here means new rows to append, not a full replace of
        // this item's existing children - those are managed individually
        // via their own rows in the list. Only meaningful on a top-level
        // item, same restriction as storeItem.
        if (!$item->parent_id) {
            $this->appendChildren($item, $request->input('children', []));
        }

        return response()->json(['success' => true, 'data' => $item->fresh('children')]);
    }

    /**
     * Bulk-append new child items (e.g. Locations under a Territory),
     * skipping blank rows and continuing the parent's existing order
     * sequence.
     */
    private function appendChildren(LookupListItem $parent, array $names): void
    {
        $names = array_values(array_filter(array_map('trim', $names), fn ($name) => $name !== ''));

        if (!$names) {
            return;
        }

        $order = LookupListItem::where('parent_id', $parent->id)->max('order') ?? 0;
        $now = now();

        $rows = array_map(function ($name) use ($parent, &$order, $now) {
            $order++;

            return [
                'lookup_list_id' => $parent->lookup_list_id,
                'parent_id' => $parent->id,
                'name' => $name,
                'order' => $order,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $names);

        LookupListItem::insert($rows);
    }

    public function reorderItems(Request $request, $listId)
    {
        LookupList::findOrFail($listId);

        $validator = Validator::make($request->all(), [
            'ordered_ids' => ['required', 'array'],
            'ordered_ids.*' => ['integer'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        foreach ($request->input('ordered_ids') as $index => $id) {
            LookupListItem::where('id', $id)
                ->where('lookup_list_id', $listId)
                ->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\RecruitmentForm;
use App\Models\RecruitmentFormField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RecruitmentFormController extends Controller
{
    private function activeForm()
    {
        return RecruitmentForm::where('is_active', true)->firstOrFail();
    }

    public function active()
    {
        $form = $this->activeForm();

        $form->setRelation('fields', $form->fields()
            ->where('is_active', true)
            ->with('optionsSourceList:id,key,label')
            ->orderBy('order', 'asc')
            ->get());

        return response()->json(['success' => true, 'data' => $form]);
    }

    public function storeField(Request $request)
    {
        $form = $this->activeForm();

        $validator = Validator::make($request->all(), [
            'label' => ['required', 'string'],
            'type' => ['required', 'string', 'in:text,textarea,number,date,select,radio,checkbox,file'],
            'options' => ['nullable', 'array'],
            'options.*' => ['string'],
            'options_source_list_id' => ['nullable', 'integer', 'exists:lookup_lists,id'],
            'is_required' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
            'file_rules' => ['nullable', 'array'],
            'help_text' => ['nullable', 'string'],
            'condition_field_key' => ['nullable', 'string'],
            'condition_value' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $baseKey = Str::slug($data['label'], '_');
        $fieldKey = $baseKey;
        $suffix = 2;

        while (RecruitmentFormField::where('form_id', $form->id)->where('field_key', $fieldKey)->exists()) {
            $fieldKey = $baseKey.'_'.$suffix;
            $suffix++;
        }

        $order = $data['order'] ?? ((RecruitmentFormField::where('form_id', $form->id)->max('order') ?? 0) + 1);

        $optionsSourceListId = $data['options_source_list_id'] ?? null;

        $field = RecruitmentFormField::create([
            'form_id' => $form->id,
            'field_key' => $fieldKey,
            'label' => $data['label'],
            'type' => $data['type'],
            // A lookup list source takes over from static options entirely -
            // storing both would let them silently drift out of sync.
            'options' => $optionsSourceListId ? null : ($data['options'] ?? null),
            'options_source_list_id' => $optionsSourceListId,
            'is_required' => $data['is_required'] ?? false,
            'order' => $order,
            'is_active' => true,
            'file_rules' => $data['file_rules'] ?? null,
            'help_text' => $data['help_text'] ?? null,
            'condition_field_key' => $data['condition_field_key'] ?? null,
            'condition_value' => $data['condition_value'] ?? null,
        ]);

        return response()->json(['success' => true, 'data' => $field]);
    }

    public function updateField(Request $request, $id)
    {
        $field = RecruitmentFormField::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'label' => ['nullable', 'string'],
            'type' => ['nullable', 'string', 'in:text,textarea,number,date,select,radio,checkbox,file'],
            'options' => ['nullable', 'array'],
            'options.*' => ['string'],
            'options_source_list_id' => ['nullable', 'integer', 'exists:lookup_lists,id'],
            'is_required' => ['nullable', 'boolean'],
            'order' => ['nullable', 'integer'],
            'file_rules' => ['nullable', 'array'],
            'help_text' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
            'condition_field_key' => ['nullable', 'string'],
            'condition_value' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input detected.',
                'invalid_fields' => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        $typeChanged = array_key_exists('type', $data) && $data['type'] !== null && $data['type'] !== $field->type;
        $optionsChanged = array_key_exists('options', $data) && $data['options'] !== null
            && json_encode($data['options']) !== json_encode($field->options);
        $optionsSourceChanged = array_key_exists('options_source_list_id', $data)
            && $data['options_source_list_id'] != $field->options_source_list_id;

        $versionBumped = false;

        if (($typeChanged || $optionsChanged || $optionsSourceChanged) && Applicant::where('form_id', $field->form_id)->exists()) {
            $form = RecruitmentForm::find($field->form_id);
            $form->increment('version');
            $versionBumped = true;
        }

        // A lookup list source takes over from static options entirely - if
        // this request sets one, clear any static options at the same time
        // so they can't silently drift out of sync with each other.
        if ($request->has('options_source_list_id') && $data['options_source_list_id'] !== null) {
            $data['options'] = null;
        }

        $update = [];

        foreach (['label', 'type', 'options', 'options_source_list_id', 'is_required', 'order', 'file_rules', 'help_text', 'is_active', 'condition_field_key', 'condition_value'] as $key) {
            if ($request->has($key)) {
                $update[$key] = $data[$key] ?? null;
            }
        }

        // field_key is immutable - never write it even if present in the request.
        unset($update['field_key']);

        $field->update($update);

        return response()->json(['success' => true, 'data' => $field, 'version_bumped' => $versionBumped]);
    }

    public function destroyField($id)
    {
        $field = RecruitmentFormField::findOrFail($id);
        $field->update(['is_active' => false]);

        return response()->json(['success' => true]);
    }
}

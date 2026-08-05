<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentFormField extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'field_key',
        'label',
        'type',
        'options',
        'options_source_list_id',
        'is_required',
        'order',
        'is_active',
        'file_rules',
        'help_text',
        'condition_field_key',
        'condition_value',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y, h:i A',
        'updated_at' => 'datetime:M d, Y, h:i A',
        'options' => 'array',
        'file_rules' => 'array',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'form_id' => 'integer',
        'options_source_list_id' => 'integer',
    ];

    public function form()
    {
        return $this->belongsTo(RecruitmentForm::class, 'form_id');
    }

    public function optionsSourceList()
    {
        return $this->belongsTo(LookupList::class, 'options_source_list_id');
    }
}

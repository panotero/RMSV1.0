<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentFormField extends Model
{
    use HasFactory, HasFriendlyDates;

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
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
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

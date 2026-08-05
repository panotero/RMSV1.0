<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'checklist_item_id',
        'is_done',
        'done_at',
        'done_by',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y, h:i A',
        'updated_at' => 'datetime:M d, Y, h:i A',
        'is_done' => 'boolean',
        'done_at' => 'datetime',
        'applicant_id' => 'integer',
        'checklist_item_id' => 'integer',
        'done_by' => 'integer',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function checklistItem()
    {
        return $this->belongsTo(ChecklistItem::class, 'checklist_item_id');
    }

    public function doneBy()
    {
        return $this->belongsTo(User::class, 'done_by');
    }
}

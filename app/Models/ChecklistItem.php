<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'checklist_group_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y, h:i A',
        'updated_at' => 'datetime:M d, Y, h:i A',
        'is_active' => 'boolean',
        'order' => 'integer',
        'checklist_group_id' => 'integer',
    ];

    public function group()
    {
        return $this->belongsTo(ChecklistGroup::class, 'checklist_group_id');
    }
}

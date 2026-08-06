<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistItem extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $fillable = [
        'label',
        'checklist_group_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
        'is_active' => 'boolean',
        'order' => 'integer',
        'checklist_group_id' => 'integer',
    ];

    public function group()
    {
        return $this->belongsTo(ChecklistGroup::class, 'checklist_group_id');
    }
}

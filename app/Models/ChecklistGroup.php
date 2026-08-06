<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistGroup extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $fillable = [
        'label',
        'target_status',
        'order',
        'is_active',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(ChecklistItem::class, 'checklist_group_id')->orderBy('order');
    }
}

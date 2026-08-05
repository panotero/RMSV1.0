<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChecklistGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'target_status',
        'order',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y, h:i A',
        'updated_at' => 'datetime:M d, Y, h:i A',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(ChecklistItem::class, 'checklist_group_id')->orderBy('order');
    }
}

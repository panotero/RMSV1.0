<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupListItem extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $fillable = [
        'lookup_list_id',
        'parent_id',
        'name',
        'order',
        'is_active',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
        'is_active' => 'boolean',
        'order' => 'integer',
        'lookup_list_id' => 'integer',
        'parent_id' => 'integer',
    ];

    public function list()
    {
        return $this->belongsTo(LookupList::class, 'lookup_list_id');
    }

    public function parent()
    {
        return $this->belongsTo(LookupListItem::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(LookupListItem::class, 'parent_id')->orderBy('order');
    }
}

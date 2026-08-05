<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupListItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'lookup_list_id',
        'parent_id',
        'name',
        'order',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y, h:i A',
        'updated_at' => 'datetime:M d, Y, h:i A',
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

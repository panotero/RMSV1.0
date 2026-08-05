<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupList extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'label',
        'child_label',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y, h:i A',
        'updated_at' => 'datetime:M d, Y, h:i A',
    ];

    public function items()
    {
        return $this->hasMany(LookupListItem::class, 'lookup_list_id');
    }
}

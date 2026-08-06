<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LookupList extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $fillable = [
        'key',
        'label',
        'child_label',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
    ];

    public function items()
    {
        return $this->hasMany(LookupListItem::class, 'lookup_list_id');
    }
}

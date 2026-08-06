<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Model;

class NavIcon extends Model
{
    use HasFriendlyDates;

    protected $fillable = [
        'key',
        'label',
        'svg',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
    ];
}

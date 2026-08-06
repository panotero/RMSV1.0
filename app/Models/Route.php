<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory, HasFriendlyDates;
    protected $table = 'ports';

    protected $fillable = [
        'name',
        'code',
        'port',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
    ];
}

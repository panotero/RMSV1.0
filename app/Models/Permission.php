<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFriendlyDates;

    protected $fillable = [
        'key',
        'label',
        'module',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
    ];

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(SettingRole::class, 'role_permission', 'permission_id', 'role_id');
    }
}

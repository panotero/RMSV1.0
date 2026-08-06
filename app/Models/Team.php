<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $fillable = [
        'name',
        'description',
        'parent_id',
        'is_active',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
        'is_active' => 'boolean',
        'parent_id' => 'integer',
    ];

    public function parent()
    {
        return $this->belongsTo(Team::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Team::class, 'parent_id');
    }

    public function members()
    {
        return $this->hasMany(User::class, 'team_id');
    }

    public function leaders()
    {
        return $this->hasMany(User::class, 'team_id')->where('is_team_leader', true);
    }
}

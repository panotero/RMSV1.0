<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantActivity extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $fillable = [
        'applicant_id',
        'type',
        'description',
        'actor_id',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
        'applicant_id' => 'integer',
        'actor_id' => 'integer',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}

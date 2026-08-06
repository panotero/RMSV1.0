<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantOrientation extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $fillable = [
        'applicant_id',
        'scheduled_date',
        'status',
        'scheduled_by',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
        'applicant_id' => 'integer',
        'scheduled_by' => 'integer',
        'scheduled_date' => FriendlyDateTime::class,
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function scheduler()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    public function history()
    {
        return $this->hasMany(ApplicantOrientationHistory::class, 'applicant_orientation_id')
            ->orderByDesc('created_at')
            ->orderByDesc('id');
    }
}

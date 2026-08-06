<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantOrientationHistory extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $table = 'applicant_orientation_history';

    protected $fillable = [
        'applicant_orientation_id',
        'event_type',
        'scheduled_date',
        'changed_by',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
        'scheduled_date' => FriendlyDateTime::class,
        'applicant_orientation_id' => 'integer',
        'changed_by' => 'integer',
    ];

    public function orientation()
    {
        return $this->belongsTo(ApplicantOrientation::class, 'applicant_orientation_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}

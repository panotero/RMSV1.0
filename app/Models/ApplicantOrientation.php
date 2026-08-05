<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantOrientation extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'scheduled_date',
        'scheduled_by',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y, h:i A',
        'updated_at' => 'datetime:M d, Y, h:i A',
        'applicant_id' => 'integer',
        'scheduled_by' => 'integer',
        'scheduled_date' => 'date',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

    public function scheduler()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }
}

<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantFile extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $fillable = [
        'applicant_id',
        'field_key',
        'original_name',
        'path',
        'mime',
        'size',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
        'size' => 'integer',
        'applicant_id' => 'integer',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }
}

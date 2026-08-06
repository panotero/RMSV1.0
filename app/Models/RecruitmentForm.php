<?php

namespace App\Models;

use App\Casts\FriendlyDateTime;
use App\Concerns\HasFriendlyDates;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentForm extends Model
{
    use HasFactory, HasFriendlyDates;

    protected $fillable = [
        'name',
        'version',
        'is_active',
    ];

    protected $casts = [
        'created_at' => FriendlyDateTime::class,
        'updated_at' => FriendlyDateTime::class,
        'is_active' => 'boolean',
        'version' => 'integer',
    ];

    public function fields()
    {
        return $this->hasMany(RecruitmentFormField::class, 'form_id');
    }

    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'form_id');
    }
}

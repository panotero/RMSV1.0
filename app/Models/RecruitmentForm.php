<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'version',
        'is_active',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y, h:i A',
        'updated_at' => 'datetime:M d, Y, h:i A',
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

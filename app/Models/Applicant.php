<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'location_id',
        'role_id',
        'source_id',
        'source_detail',
        'phone',
        'email',
        'date_of_birth',
        'interview_summary',
        'status',
        'assigned_to',
        'team_id',
        'form_id',
        'form_version',
        'form_data',
        'last_activity_at',
    ];

    protected $casts = [
        'created_at' => 'datetime:M d, Y, h:i A',
        'updated_at' => 'datetime:M d, Y, h:i A',
        'form_data' => 'array',
        'form_version' => 'integer',
        'location_id' => 'integer',
        'role_id' => 'integer',
        'source_id' => 'integer',
        'assigned_to' => 'integer',
        'team_id' => 'integer',
        'form_id' => 'integer',
        'date_of_birth' => 'date',
        'last_activity_at' => 'datetime',
    ];

    public function location()
    {
        return $this->belongsTo(LookupListItem::class, 'location_id');
    }

    public function role()
    {
        return $this->belongsTo(LookupListItem::class, 'role_id');
    }

    public function source()
    {
        return $this->belongsTo(LookupListItem::class, 'source_id');
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function form()
    {
        return $this->belongsTo(RecruitmentForm::class, 'form_id');
    }

    public function files()
    {
        return $this->hasMany(ApplicantFile::class, 'applicant_id');
    }

    public function checklistItems()
    {
        return $this->hasMany(ApplicantChecklistItem::class, 'applicant_id');
    }

    public function notes()
    {
        return $this->hasMany(ApplicantNote::class, 'applicant_id');
    }

    public function orientation()
    {
        return $this->hasOne(ApplicantOrientation::class, 'applicant_id');
    }

    /**
     * The active top-level items of the 'status' lookup list, in their
     * configured order - the full set of statuses a user can pick from or
     * that auto-advance can set.
     */
    public static function validStatuses(): array
    {
        return LookupListItem::whereHas('list', fn ($q) => $q->where('key', 'status'))
            ->whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('order')
            ->pluck('name')
            ->all();
    }
}

<?php

namespace App\Concerns;

use App\Support\FriendlyDate;

/**
 * Formats created_at/updated_at (and any other column Eloquent treats as a
 * date without an explicit cast) as "January 1, 2001", or
 * "January 1, 2001, 1:00 AM" when the time isn't exactly midnight.
 *
 * created_at/updated_at don't go through a model's custom attribute casts
 * for array/JSON serialization - Eloquent always routes them through
 * serializeDate() instead, so this trait's override is what's needed for
 * those two columns specifically. Other date columns should use the
 * App\Casts\FriendlyDateTime cast in $casts instead (see e.g. Applicant's
 * date_of_birth) - an explicit 'datetime:FORMAT' cast on created_at/
 * updated_at would take precedence over this override, so don't combine
 * the two on those columns.
 */
trait HasFriendlyDates
{
    protected function serializeDate(\DateTimeInterface $date)
    {
        return FriendlyDate::instance($date)->toFriendlyString();
    }
}

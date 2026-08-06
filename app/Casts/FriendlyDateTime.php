<?php

namespace App\Casts;

use App\Support\FriendlyDate;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * Casts a date/datetime column to a FriendlyDate (a Carbon subclass) - full
 * Carbon behavior in PHP (diffs, comparisons, ->addDays(), etc.), but
 * displays/serializes as "January 1, 2001", or "January 1, 2001, 1:00 AM"
 * when the time isn't exactly midnight.
 */
class FriendlyDateTime implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        if ($value === null) {
            return null;
        }

        return FriendlyDate::parse($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        if ($value instanceof \DateTimeInterface) {
            return FriendlyDate::instance($value)->format('Y-m-d H:i:s');
        }

        return $value;
    }
}

<?php

namespace App\Support;

use Illuminate\Support\Carbon;

/**
 * A Carbon subclass that formats itself as "January 1, 2001" - or
 * "January 1, 2001, 1:00 AM" when the time isn't exactly midnight. Behaves
 * as a normal Carbon instance everywhere else (comparisons, diffs, etc.) -
 * only string/JSON output changes.
 */
class FriendlyDate extends Carbon
{
    public function toFriendlyString(): string
    {
        return $this->format('H:i:s') === '00:00:00'
            ? $this->format('F j, Y')
            : $this->format('F j, Y, g:i A');
    }

    public function __toString(): string
    {
        return $this->toFriendlyString();
    }

    public function jsonSerialize(): mixed
    {
        return $this->toFriendlyString();
    }
}

<?php

namespace App\Services;

use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Collection;

class TeamService
{
    /**
     * Every team ID a user's visibility should extend to. Team leaders see
     * their own team plus every team nested below it (arbitrary depth);
     * everyone else just sees their own team (or nothing, if teamless).
     */
    public static function accessibleTeamIds(User $user): Collection
    {
        if ($user->is_team_leader && $user->team_id) {
            $ids = collect();
            $visited = [];
            $queue = [$user->team_id];

            while (!empty($queue)) {
                $teamId = array_shift($queue);

                if (isset($visited[$teamId])) {
                    continue;
                }

                $visited[$teamId] = true;
                $ids->push($teamId);

                $childIds = Team::where('parent_id', $teamId)->pluck('id');

                foreach ($childIds as $childId) {
                    if (!isset($visited[$childId])) {
                        $queue[] = $childId;
                    }
                }
            }

            return $ids;
        }

        return $user->team_id ? collect([$user->team_id]) : collect();
    }
}

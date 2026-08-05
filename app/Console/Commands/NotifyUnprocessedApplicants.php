<?php

namespace App\Console\Commands;

use App\Models\Applicant;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class NotifyUnprocessedApplicants extends Command
{
    protected $signature = 'recruitment:notify-unprocessed';

    protected $description = 'Notify recruiters about applicants in Interview/Offer status with incomplete post-interview checklists';

    public function handle()
    {
        $applicants = Applicant::whereIn('status', ['Interview', 'Offer'])
            ->whereHas('checklistItems', fn ($q) => $q->where('is_done', false))
            ->get(['id', 'assigned_to']);

        $grouped = $applicants->groupBy('assigned_to');

        foreach ($grouped as $userId => $items) {
            $n = $items->count();

            if ($n <= 0) {
                continue;
            }

            NotificationService::send([
                'title' => 'Applicants need attention',
                'message' => "You have {$n} applicant(s) with incomplete post-interview checklists.",
                'target' => ['type' => 'user', 'user_id' => $userId],
                'link' => ['title' => 'View applicants', 'url' => '/page_applicants?scope=mine'],
            ]);
        }

        return Command::SUCCESS;
    }
}

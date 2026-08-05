<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('run:something')->everyMinute();
        $schedule->command('check:dueDocument')->everyMinute();
        $schedule->command('recruitment:notify-unprocessed')->dailyAt('17:00')->withoutOverlapping();
    }
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

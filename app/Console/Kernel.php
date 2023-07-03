<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('backup:clean')
            ->everyMinute()
            ->environments(['production'])
            ->onSuccess(function () {
                Log::channel('backups')->info('✅ Clean Backups');
            })
            ->onFailure(function () {
                Log::channel('backups')->error('❌ Clean Backups');
            })
            ->appendOutputTo(storage_path('logs/scheduled-backups.log'));

        $schedule->command('backup:run')
            ->daily()->at('01:30')
            ->environments(['production'])
            ->onSuccess(function () {
                Log::channel('backups')->info('✅ Clean Backups');
            })
            ->onFailure(function () {
                Log::channel('backups')->error('❌ Clean Backups');
            })
            ->appendOutputTo(storage_path('logs/scheduled-backups.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

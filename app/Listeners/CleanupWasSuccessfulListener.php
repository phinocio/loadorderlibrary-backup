<?php

namespace App\Listeners;

use App\Models\Backup;
use Spatie\Backup\Events\CleanupWasSuccessful;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CleanupWasSuccessfulListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CleanupWasSuccessful $event): void
    {
		if ($event->backupDestination->filesystemType() === 'localfilesystemadapter') {
			Backup::whereFile($event->backupDestination->oldestBackup()->path())->delete();
		}
    }
}

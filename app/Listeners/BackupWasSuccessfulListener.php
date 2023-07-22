<?php

namespace App\Listeners;

use App\Models\Backup;
use Carbon\Carbon;
use Spatie\Backup\Events\BackupWasSuccessful;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class BackupWasSuccessfulListener
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
  public function handle(BackupWasSuccessful $event): void
  {
    Log::info("Backup event fired");
    Log::debug($event->backupDestination->filesystemType());
    if ($event->backupDestination->filesystemType() === 'localfilesystemadapter') {
      $backup = new Backup();
      $backup->file = $event->backupDestination->newestBackup()->path();
      $backup->size = $event->backupDestination->newestBackup()->sizeInBytes();
      $backup->save();
    }
  }
}

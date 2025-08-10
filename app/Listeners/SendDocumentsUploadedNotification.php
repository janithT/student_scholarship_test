<?php

namespace App\Listeners;

use App\Events\ApplicationDocumentsUploaded;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendDocumentsUploadedNotification
{
    use InteractsWithQueue;
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
    public function handle(ApplicationDocumentsUploaded $event): void
    {
        Log::info("Documents uploaded for Application ID {$event->application->id}");
    }
}

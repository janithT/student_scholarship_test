<?php

namespace App\Observers;

use App\Models\Application;
use App\Models\ObserverModels\StudentApplicationLog;
use App\Models\Scholarship;
use Illuminate\Support\Facades\Auth;

class ApplicationObserver
{
    /**
     * Handle the Application "created" event.
     */
    public function created(Application $application): void
    {
        $scholar = Scholarship::find($application->scholarship_id);
        if (!$scholar) {
            return; 
        }
        $this->logChange($application, 'created', [
            'message' => "Application for scholarship '{$scholar->title}' created successfully",
        ]);
    }

    /**
     * Handle the Application "updated" event.
     */
    public function updated(Application $application): void
    {
        //
    }

    /**
     * Handle the Application "deleted" event.
     */
    public function deleted(Application $application): void
    {
        //
    }

    /**
     * Handle the Application "restored" event.
     */
    public function restored(Application $application): void
    {
        //
    }

    /**
     * Handle the Application "force deleted" event.
     */
    public function forceDeleted(Application $application): void
    {
        //
    }

    // Protected method to log changes
    protected function logChange(Application $application, string $action, array $changes = null)
    {
        // move this to seperate repository or service

        // $this->logApplicationRepository($application, $action, $changes);
        StudentApplicationLog::create([
            'application_id' => $application->id,
            'scholarship_id' => $application->scholarship_id,
            'user_id'        => Auth::id(),
            'action'         => $action,
            'changes'        => $changes ? json_encode($changes) : null,
        ]);
    }
}

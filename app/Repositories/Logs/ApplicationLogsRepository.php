<?php

namespace App\Repositories\Logs;

use App\Models\Application;
use App\Models\ObserverModels\StudentApplicationLog;
use Illuminate\Support\Facades\Auth;

class ApplicationLogsRepository
{
    /**
     * Get all applications.
     * @param int $userId
     * @return \Illuminate\Database\Eloquent\Collection
     * 
     */
    public function getMyAppById(int $application_id, int $userId)
    {
        return StudentApplicationLog::where('user_id', $userId)
        ->where('application_id', $application_id)
        ->orderByDesc('created_at')
        ->get();
    }

 
}

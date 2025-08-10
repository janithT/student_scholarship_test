<?php

namespace App\Services\Logs;

use App\Repositories\Logs\ApplicationLogsRepository;
use Illuminate\Support\Facades\Auth;

class ApplicationLogService {

    /**
     * Create a new service instance.
     *
     * @param ApplicationLogsRepository $applicationLogsRepository
     */
    public function __construct(public ApplicationLogsRepository $applicationLogsRepository)
    {
        
    }

    /**
     * Get application logs by application ID.
     *
     * @param array $data
     * @param Application $application
     * @return object
     */
    public function getMyApplicationsLogs(array $data, $application): object
    {
        try {
            $user_id = Auth::user()->id;
            $applicationLogs = $this->applicationLogsRepository->getMyAppById($application->id, $user_id);
            return apiServiceResponse($applicationLogs, true, 'Application logs retrieved successfully');
             
        } catch (\Exception $e) {dd($e);
            return apiServiceResponse([], false, $e->getMessage());
        
        }
    }
}
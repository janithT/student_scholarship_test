<?php

namespace App\Services;

use App\Jobs\ProcessApplicationDocuments;
use App\Models\Application;
use App\Models\Scholarship;
use App\Repositories\ApplicationRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApplicationService
{

    public function __construct(public ApplicationRepository $applicationRepository)
    {
        
    }
    /**
     * Get all scholarships.
     *
     * 
     */
    public function getMyApplications(): object
    {
        try {
            $user_id = Auth::user()->id;
            $scholarships = $this->applicationRepository->getMyApps($user_id);
            return apiServiceResponse($scholarships, true, 'Applications retrived successfully');
             
        } catch (\Exception $e) {
            return apiServiceResponse([], false, $e->getMessage());
        
        }
    }

    /**
     * Get a single scholarship by ID.
     * 
     */
    public function getMyApplicationsbyId(array $data, $application): object
    {
        try {
            $user_id = Auth::user()->id; // or this
            $scholarships = $this->applicationRepository->getById($application->user_id);
            return apiServiceResponse($scholarships, true, 'Applications retrived successfully');
             
        } catch (\Exception $e) {
            return apiServiceResponse([], false, $e->getMessage());
        
        }
    }

    /**
     * Create a new scholarship.
     *
     * @param array $data
     * @return Scholarship
     */
    public function createApplication(array $data): object
    {
         try {

            // create new application
            $newApplication = $this->applicationRepository->create($data);

            // upload documents if provided from post/create request
            // use reusable upload from helper function

            return apiServiceResponse($newApplication, true, 'Enrolled scholarship successfully');
             
        } catch (\Exception $e) {
            return apiServiceResponse([], false, $e->getMessage());
        }
    }

    /**
     * Update an existing scholarship.
     *
     * @param string $id
     * @param array $data
     * @return bool
     */
    public function updateApplication(array $data, int $id): object
    {
        try {
            $updated = $this->applicationRepository->update($data, $id);
            return apiServiceResponse($updated, true, 'Scholars updated successfully');
             
        } catch (\Exception $e) {
            return apiServiceResponse([], false, $e->getMessage());
        
        }

    }

    /**
     * Delete a scholarship.
     *
     * @param string $id
     * @return bool|null
     */
    public function deleteApplications(string $id)
    {
        try {
            $updated = $this->applicationRepository->delete($id);
            return apiServiceResponse($updated, true, 'Scholars deleted successfully');
             
        } catch (\Exception $e) {
            return apiServiceResponse([], false, $e->getMessage());
        
        }

    }


    /**
     * Upload documents for the application.
     */
    public function uploadDocuments(array $data, Application $application): object
    {
        try {
            DB::beginTransaction();

            if(!$application) {
                throw new \InvalidArgumentException('You are not allowed to do that.');
            }

            // Store temporary files
            $path = "assets/student/{$application->user_id}/applications/{$application->id}";
            $storedDocuments = storeFiles($application, $data, $path, 'public');

            // Dispatch job to process documents
            ProcessApplicationDocuments::dispatch($application, $storedDocuments);

            DB::commit();
            return apiServiceResponse($application->documents, true, 'Documents uploaded successfully');
             
        } catch (\Exception $e) {
            DB::rollBack();
            return apiServiceResponse([], false, $e->getMessage());
        
        }
    }
}
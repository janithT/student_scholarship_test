<?php

namespace App\Services;

use App\Models\Scholarship;
use App\Repositories\ScholarsRepository;

class ScholarshipService
{

    public function __construct(public ScholarsRepository $scholarsRepository)
    {
        
    }
    /**
     * Get all scholarships.
     *
     * 
     */
    public function getAllScholarships(): object
    {
        try {
            $scholarships = $this->scholarsRepository->getAll();
            return apiServiceResponse($scholarships, true, 'Scholars retrived successfully');
             
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
    public function createScholarship(array $data): object
    {
         try {
            $scholarships = $this->scholarsRepository->create($data);
            return apiServiceResponse($scholarships, true, 'Scholars created successfully');
             
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
    public function updateScholarship(array $data, int $id): object
    {
        try {
            $updated = $this->scholarsRepository->update($data, $id);
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
    public function deleteScholarship(string $id) : object
    {
        try {
            $updated = $this->scholarsRepository->delete($id);
            return apiServiceResponse($updated, true, 'Scholars deleted successfully');
             
        } catch (\Exception $e) {
            return apiServiceResponse([], false, $e->getMessage());
        
        }

    }
}
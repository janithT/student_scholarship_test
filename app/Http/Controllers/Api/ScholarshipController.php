<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Scholarships\ScholarshipRequest;
use App\Http\Requests\Scholarships\UpdateScholarshipRequest;
use App\Services\ScholarshipService;
use Illuminate\Http\JsonResponse;

class ScholarshipController extends Controller
{

    public function __construct(public ScholarshipService $scholarshipService)
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index() : JsonResponse
    {
        $scholars = $this->scholarshipService->getAllScholarships();

        if ($scholars->status) {
            return apiResponseWithStatusCode($scholars->data, 'success', $scholars->message, '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $scholars->message, '', 422);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() 
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ScholarshipRequest $request): JsonResponse
    {
        $scholars = $this->scholarshipService->createScholarship($request->validated());

        if ($scholars && $scholars->status) {
            return apiResponseWithStatusCode($scholars->data, 'success', 'Successfully created', '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $scholars->message, '', 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScholarshipRequest $request, int $id): JsonResponse
    {
        $updatedScholars = $this->scholarshipService->updateScholarship($request->validated(), $id);

        if ($updatedScholars && $updatedScholars->status) {
            return apiResponseWithStatusCode($updatedScholars->data, 'success', 'Successfully created', '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $updatedScholars->message, '', 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id) : JsonResponse
    {
        $deletedScholars = $this->scholarshipService->deleteScholarship($id);

        if ($deletedScholars && $deletedScholars->status) {
            return apiResponseWithStatusCode($deletedScholars->data, 'success', 'Successfully created', '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $deletedScholars->message, '', 422);
    }
}

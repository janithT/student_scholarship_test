<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\ApplicationByIdRequest;
use App\Http\Requests\Applications\ApplicationDocumentUploadRequest;
use App\Http\Requests\Applications\ApplicationStoreRequest;
use App\Models\Application;
use App\Services\ApplicationService;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{

    public function __construct(
        public ApplicationService $applicationService
    ) {
        // Constructor logic if needed
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $createApplication = $this->applicationService->getMyApplications();

        if ($createApplication && $createApplication->status) {
            return apiResponseWithStatusCode($createApplication->data, 'success', $createApplication->message, '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $createApplication->message, '', 422);
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
    public function store(ApplicationStoreRequest $request)
    {
        $createApplication = $this->applicationService->createApplication($request->validated());

        if ($createApplication && $createApplication->status) {
            return apiResponseWithStatusCode($createApplication->data, 'success', $createApplication->message, '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $createApplication->message, '', 422);
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicationByIdRequest $request, Application $application)
    {
        $showApplication = $this->applicationService->getMyApplicationsbyId($request->validated(), $application);

        if ($showApplication && $showApplication->status) {
            return apiResponseWithStatusCode($showApplication->data, 'success', $showApplication->message, '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $showApplication->message, '', 422);
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Upload documents for the application.
     */
    public function uploadDocuments(ApplicationDocumentUploadRequest $request, Application $application)
    {
        // Call the service to handle document upload
       $createApplication = $this->applicationService->uploadDocuments($request->validated(), $application);

        if ($createApplication && $createApplication->status) {
            return apiResponseWithStatusCode($createApplication->data, 'success', $createApplication->message, '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $createApplication->message, '', 422);
    }
}

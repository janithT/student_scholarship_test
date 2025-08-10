<?php

namespace App\Http\Controllers\Logs;

use App\Http\Controllers\Controller;
use App\Http\Requests\Applications\ApplicationByIdRequest;
use App\Models\Application;
use App\Services\Logs\ApplicationLogService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApplicationLogController extends Controller
{
    //
    public function __construct(public ApplicationLogService $applicationLogService)
    {
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicationByIdRequest $request, Application $application) : JsonResponse
    {
        $applicationLog = $this->applicationLogService->getMyApplicationsLogs($request->validated(), $application);

        if ($applicationLog && $applicationLog->status) {
            return apiResponseWithStatusCode($applicationLog->data, 'success', $applicationLog->message, '', 200);
        }

        return apiResponseWithStatusCode([], 'error', $applicationLog->message, '', 422);
    }
}

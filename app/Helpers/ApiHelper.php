<?php
// Resusable helper functions

use App\Mail\SystemMail;
use App\Models\Application;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


// Reusable API response function

function apiResponseWithStatusCode($data, $status, $message, $user, $statusCode)
{
    $response = [];
    $response['status'] = $status;
    $response['message'] = $message;
    if ($user) {
        $response['user'] = $user;
    }
    $response['data'] = $data;
    // if ($token) {
    //     $response['token'] = $token;
    // } 
    return  response()->json($response, $statusCode);
}

// generate key for system use
function generateTaskKey($perfix): string
{
    return $perfix . Str::random(10);
}

// generate key for system use
function generateTime(): string
{
    return now()->format('YmdHisv');
}

// for service response
function apiServiceResponse($data, $status, $message)
{
    return (object)[
        'status' => $status,
        'message' => $message,
        'data' => $data
    ];
}

// send emails

function sendSystemEmail(array $data = [])
{
    // if data is exists
    if (!empty($data) && isset($data['to'])) {
        try {
            Mail::to($data['to'])->queue(new SystemMail($data));
            return true;
        } catch (\Exception $e) {
            Log::error('Welcome email sending failed: ' . $e->getMessage());

            return false;
        }
    }
    return false;
}

/**
 * 
 * Store files
 */
function storeFiles(object $model, array $files, string $tempFolder = 'temp/application_docs', string $disk = 'public'): array
{
    $storedFiles = [];

    $disk = $disk ?: config('filesystems.default');

    // If model is Application and cleanup is needed, do it once before the loop
    if ($model instanceof Application) {
        if (Storage::disk($disk)->exists($tempFolder)) {
            $deleteExisting = Storage::disk($disk)->deleteDirectory($tempFolder);
            if (!$deleteExisting) {
                Log::error("Failed to delete existing documents for application ID: {$model->id}");
            }
        }
    }

    // Uploading each file here.
    foreach ($files['documents'] as $file) {
        if (!$file instanceof UploadedFile) {
            Log::warning("Skipping invalid file input.");
            continue;
        }

        // Store the file
        $tempPath = Storage::disk($disk)->putFile($tempFolder, $file);

        // Save file metadata
        $storedFiles[] = [
            'temp_path' => $tempPath,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getClientMimeType(),
            'disk' => $disk,
        ];
    }

    return $storedFiles;
}
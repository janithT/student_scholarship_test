<?php

namespace App\Jobs;

use App\Events\ApplicationDocumentsUploaded;
use App\Models\Application;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessApplicationDocuments implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $application;
    protected $documents;

    /**
     * Create a new job instance.
     */
    public function __construct(Application $application, array $documents)
    {
        $this->application = $application;
        $this->documents = $documents;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Processing application documents', [
            'application_id' => $this->application->id,
            'user_id' => $this->application->user_id,
            'document_count' => count($this->documents),
        ]);

        try {
            // Remove old data and update new
            $this->application->documents()->delete();

            foreach ($this->documents as $doc) {
                $document = $this->application->documents()->create([
                    'user_id'    => $this->application->user_id,
                    'file_path'  => $doc['temp_path'],
                    'file_name'  => $doc['original_name'],
                    'mime_type'  => $doc['mime_type'],
                ]);

                Log::info('Document saved', [
                    'document_id' => $document->id,
                    'file_name' => $document->file_name,
                ]);
            }

            event(new ApplicationDocumentsUploaded($this->application));

            Log::info('Documents processing completed', [
                'application_id' => $this->application->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error processing documents', [
                'application_id' => $this->application->id,
                'error' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}

<?php

namespace App\Http\Requests\Applications;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApplicationDocumentUploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the user is authenticated and owns the application
        $application = $this->route('application');
        return $application && $application->user_id === Auth::user()->id;

    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'application_id' => $this->route('application')->id,
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'application_id' => 'required|exists:applications,id',
            "documents" => "required|array",
            "documents.*" => "file|mimes:pdf|max:2048",
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'documents.required' => 'Documents are required.',
            'documents.*.file' => 'Each document must be a file.',
            'documents.*.mimes' => 'Each document must be a PDF file.',
            'documents.*.max' => 'Each document may not be greater than 2MB.',

            'application_id.exists' => 'The application you are trying to upload documents to does not exist.',
        ];
    }
}

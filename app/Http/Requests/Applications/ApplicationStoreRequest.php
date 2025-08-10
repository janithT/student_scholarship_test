<?php

namespace App\Http\Requests\Applications;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "user_id" => "required|exists:users,id", // or if user id not coming from frontend. remove this line and user auth() user.
            "scholarship_id" => "required|exists:scholarships,id",
            "status" => "required|in:pending,approved,rejected",
            "remarks" => "nullable|string|max:255",
            // "documents.*" => "file|mimes:pdf|max:2048",
            
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user does not exist.',

            'scholarship_id.required' => 'The scholarship ID is required.',
            'scholarship_id.exists' => 'The selected scholarship does not exist.',

            'status.required' => 'The status is required.',
            'status.in' => 'The status must be one of the following: pending, approved, rejected.',

            'remarks.string' => 'The remarks must be a string.',
            'remarks.max' => 'The remarks may not be greater than 255 characters.',

            // 'documents.*.file' => 'Each document must be a file.',
            // 'documents.*.mimes' => 'Each document must be a PDF file.',
            // 'documents.*.max' => 'Each document may not be greater than 2MB.',
        ];
    }
}

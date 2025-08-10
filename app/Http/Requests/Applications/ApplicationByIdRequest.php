<?php

namespace App\Http\Requests\Applications;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ApplicationByIdRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if the user is authenticated and owns the application
        $user_id = Auth::user()->id;
        $application = $this->route('application');
        return $application && $application->user_id === $user_id;

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
        ];
    }


    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [

            'application_id.exists' => 'The application you are trying to show does not exist.',
        ];
    }
}

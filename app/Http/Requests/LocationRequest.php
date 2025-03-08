<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LocationRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'zone_id' => 'required|integer|exists:zones,id',
            'area_id' => 'required|integer|exists:areas,id',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.integer' => 'The user ID must be an integer.',
            'user_id.exists' => 'The user ID does not exist in our records.',

            'zone_id.required' => 'The zone ID is required.',
            'zone_id.integer' => 'The zone ID must be an integer.',
            'zone_id.exists' => 'The zone ID does not exist in our records.',

            'area_id.required' => 'The area ID is required.',
            'area_id.integer' => 'The area ID must be an integer.',
            'area_id.exists' => 'The area ID does not exist in our records.',
        ];
    }

    /**
     * Handle validation failure response.
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => 'Validation failed.',
            'errors' => $validator->errors()
        ], 422));
    }
}

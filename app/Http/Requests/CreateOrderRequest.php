<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer',
            'price' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'product_id.required' => 'The user ID is required.',
            'product_id.integer' => 'The user ID must be an integer.',
            'product_id.exists' => 'The user ID does not exist in our records.',

            'quantity.required' => 'The zone ID is required.',
            'quantity.integer' => 'The zone ID must be an integer.',


            'price.required' => 'The area price is required.',

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

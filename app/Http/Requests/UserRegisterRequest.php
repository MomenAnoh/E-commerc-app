<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;


class UserRegisterRequest extends FormRequest
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
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:users|max:100',
            'mobile' => 'required|string|max:15|unique:users',
            'password' => 'required|string',
        ];
    }
    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'username.string' => 'Username must be string',
            'username.max' => 'Username max 50 characters',
            'email.required' => 'Email is required',
            'email.string' => 'Email must be string',
            'email.unique' => 'Email already exists',
            'mobile.required' => 'Mobile is required',

        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator, response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422));
    }
}

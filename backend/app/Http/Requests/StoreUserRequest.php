<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['success' => false, 'message' => $validator->errors()], 412));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            // 'first_name' => 'required|string|max:255',
            // 'last_name' => 'required|string|max:255',
            // 'gender' => 'required|in:male,female',
            // 'age' => 'required|integer|min:10|max:100',
            // 'date_of_birth' => 'required|date',
            // 'phone_number' => 'required|string|max:20',
            // 'address' => 'required|string|max:255',
            // // 'profile' => 'nullable|image|max:2048',
            // 'email' => 'required|email',
            // 'password' => 'required|string|min:8|max:255',
        ];
    }
}

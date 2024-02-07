<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:250',
            'email' => [
                'required',
                'string',
                'email:rfc,dns',
                'max:250',
                // Exclude the current user's email from the unique check
                Rule::unique('users')->ignore($this->user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required',
        ];
    }
}

<?php
// app/Http/Requests/RegisterRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'commercial_registry' => 'nullable|string|max:255',
            'company_name' => 'required|string|max:255',
            'company_logo' => 'nullable|image|max:2048',
            'company_email' => 'required|string|email|max:255',
            'representative_name' => 'required|string|max:255',
            'representative_whatsapp' => 'required|string|regex:/^\d{9}$/',
            'city' => 'required|string|max:255',
            'subscription_type' => 'required|exists:subscription_types,id',
        ];
    }
}

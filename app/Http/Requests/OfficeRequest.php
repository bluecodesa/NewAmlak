<?php

// app/Http/Requests/OfficeRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OfficeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'CRN' => 'nullable|string|max:255',
            'Company_name' => 'required|string|max:255',
            // Add validation rules for other fields
        ];
    }
}


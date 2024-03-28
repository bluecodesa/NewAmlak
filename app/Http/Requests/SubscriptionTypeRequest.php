<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriptionTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true; // You can define authorization logic here if needed
    }

    public function rules()
    {
        $period = $this->input('period');
        $periodType = $this->input('period_type');

        return [
            'price' => 'required',
            'status' => 'required',
            'period' => [
                'required',
                Rule::unique('subscription_types')->where(function ($query) use ($period, $periodType) {
                    return $query->where('period', $period)
                        ->where('period_type', $periodType)
                        ->where('is_deleted', 0);
                }),
            ],
        ];
    }

    // Additional methods can be added for custom validation messages, attributes, etc.
}
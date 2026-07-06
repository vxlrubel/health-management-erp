<?php

namespace App\Http\Requests\Ratesheet;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatesheetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => ['sometimes', 'required', 'exists:branches,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'hourly_rate' => ['sometimes', 'required', 'numeric', 'min:0', 'max:9999999999.99'],
            'weekend_rate' => ['sometimes', 'required', 'numeric', 'min:0', 'max:9999999999.99'],
            'holiday_rate' => ['sometimes', 'required', 'numeric', 'min:0', 'max:9999999999.99'],
            'night_rate' => ['sometimes', 'required', 'numeric', 'min:0', 'max:9999999999.99'],
            'status' => ['nullable', 'string', 'in:active,inactive,suspended,archived'],
        ];
    }
}

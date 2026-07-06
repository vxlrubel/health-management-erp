<?php

namespace App\Http\Requests\HolidayCalendar;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHolidayCalendarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => ['nullable', 'exists:branches,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'holiday_date' => ['sometimes', 'required', 'date'],
            'type' => ['sometimes', 'required', 'string', 'max:100'],
            'is_paid' => ['boolean'],
        ];
    }
}

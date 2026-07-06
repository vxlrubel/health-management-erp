<?php

namespace App\Http\Requests\HolidayCalendar;

use Illuminate\Foundation\Http\FormRequest;

class StoreHolidayCalendarRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => ['nullable', 'exists:branches,id'],
            'name' => ['required', 'string', 'max:255'],
            'holiday_date' => ['required', 'date'],
            'type' => ['required', 'string', 'max:100'],
            'is_paid' => ['boolean'],
        ];
    }
}

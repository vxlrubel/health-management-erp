<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;

class UpdateActivityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'schedule_id' => ['nullable', 'exists:schedules,id'],
            'employee_id' => ['sometimes', 'required', 'exists:employees,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'branch_id' => ['sometimes', 'required', 'exists:branches,id'],
            'activity_type' => ['sometimes', 'required', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
            'start_datetime' => ['sometimes', 'required', 'date'],
            'end_datetime' => ['sometimes', 'required', 'date', 'after:start_datetime'],
            'actual_hours' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'status' => ['nullable', 'string', 'in:pending,approved,in_progress,completed,cancelled,rejected'],
        ];
    }
}

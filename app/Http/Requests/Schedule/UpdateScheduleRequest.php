<?php

namespace App\Http\Requests\Schedule;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'rota_id' => ['nullable', 'exists:rotas,id'],
            'employee_id' => ['sometimes', 'required', 'exists:employees,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'branch_id' => ['sometimes', 'required', 'exists:branches,id'],
            'start_datetime' => ['sometimes', 'required', 'date'],
            'end_datetime' => ['sometimes', 'required', 'date', 'after:start_datetime'],
            'planned_hours' => ['sometimes', 'required', 'numeric', 'min:0', 'max:999999.99'],
            'status' => ['nullable', 'string', 'in:pending,running,completed,cancelled'],
        ];
    }
}

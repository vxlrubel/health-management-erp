<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSalaryRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['sometimes', 'exists:employees,id'],
            'branch_id' => ['sometimes', 'exists:branches,id'],
            'month' => ['sometimes', 'string', 'regex:/^\d{4}-\d{2}$/'],
            'working_hours' => ['nullable', 'numeric', 'min:0'],
            'hourly_rate' => ['nullable', 'numeric', 'min:0'],
            'overtime' => ['nullable', 'numeric', 'min:0'],
            'bonus' => ['nullable', 'numeric', 'min:0'],
            'deduction' => ['nullable', 'numeric', 'min:0'],
            'net_salary' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'max:50'],
        ];
    }
}

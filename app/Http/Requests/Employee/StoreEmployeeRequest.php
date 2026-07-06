<?php

namespace App\Http\Requests\Employee;

use App\Enums\EmploymentType;
use App\Enums\GeneralStatus;
use App\Enums\SalaryType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => ['required', 'exists:branches,id'],
            'user_id' => ['nullable', 'exists:users,id'],
            'employee_no' => ['required', 'string', 'max:50', 'unique:employees,employee_no'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:employees,email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'dob' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'string', 'in:male,female,other'],
            'address' => ['nullable', 'string'],
            'joining_date' => ['nullable', 'date'],
            'employment_type' => ['required', new Enum(EmploymentType::class)],
            'hourly_rate' => ['nullable', 'numeric', 'min:0', 'max:9999999999.99'],
            'salary_type' => ['required', new Enum(SalaryType::class)],
            'status' => ['required', new Enum(GeneralStatus::class)],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:50'],
        ];
    }
}

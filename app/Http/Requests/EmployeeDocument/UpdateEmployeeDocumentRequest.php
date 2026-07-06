<?php

namespace App\Http\Requests\EmployeeDocument;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'employee_id' => ['sometimes', 'exists:employees,id'],
            'type' => ['sometimes', 'string', 'max:50'],
            'title' => ['sometimes', 'string', 'max:255'],
            'file_path' => ['sometimes', 'string', 'max:255'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:today'],
            'is_verified' => ['boolean'],
            'verified_by' => ['nullable', 'exists:users,id'],
            'verified_at' => ['nullable', 'date'],
        ];
    }
}

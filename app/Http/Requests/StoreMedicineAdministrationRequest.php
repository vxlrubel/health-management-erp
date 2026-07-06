<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineAdministrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'medicine_id' => ['required', 'exists:medicines,id'],
            'client_id' => ['required', 'exists:clients,id'],
            'employee_id' => ['required', 'exists:employees,id'],
            'administered_at' => ['nullable', 'date'],
            'dose_given' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'in:active,inactive,suspended,archived'],
            'notes' => ['nullable', 'string'],
        ];
    }
}

<?php

namespace App\Http\Requests\RecurringRota;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecurringRotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => ['sometimes', 'required', 'exists:branches,id'],
            'rota_id' => ['sometimes', 'required', 'exists:rotas,id'],
            'shift_template_id' => ['sometimes', 'required', 'exists:shift_templates,id'],
            'frequency' => ['sometimes', 'required', 'string', 'in:daily,weekly,biweekly,monthly'],
            'days_of_week' => ['nullable', 'array'],
            'days_of_week.*' => ['integer', 'between:0,6'],
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['sometimes', 'required', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'string', 'in:active,inactive,suspended,archived'],
        ];
    }
}

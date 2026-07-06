<?php

namespace App\Http\Requests\RecurringRota;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecurringRotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => ['required', 'exists:branches,id'],
            'rota_id' => ['required', 'exists:rotas,id'],
            'shift_template_id' => ['required', 'exists:shift_templates,id'],
            'frequency' => ['required', 'string', 'in:daily,weekly,biweekly,monthly'],
            'days_of_week' => ['nullable', 'array'],
            'days_of_week.*' => ['integer', 'between:0,6'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['nullable', 'string', 'in:active,inactive,suspended,archived'],
        ];
    }
}

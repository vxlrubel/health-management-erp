<?php

namespace App\Http\Requests\Rota;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRotaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'branch_id' => ['sometimes', 'required', 'exists:branches,id'],
            'ratesheet_id' => ['nullable', 'exists:ratesheets,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['sometimes', 'required', 'date', 'after_or_equal:start_date'],
            'start_time' => ['sometimes', 'required', 'date_format:H:i'],
            'end_time' => ['sometimes', 'required', 'date_format:H:i'],
            'status' => ['nullable', 'string', 'in:active,inactive,suspended,archived'],
        ];
    }
}

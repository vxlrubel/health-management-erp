<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFormSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answers_json' => ['sometimes', 'json'],
            'status' => ['nullable', 'string', 'max:50'],
        ];
    }
}

<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'form_id' => ['required', 'exists:forms,id'],
            'subject_type' => ['required', 'string'],
            'subject_id' => ['required', 'integer'],
            'answers_json' => ['required', 'json'],
            'status' => ['nullable', 'string', 'max:50'],
        ];
    }
}

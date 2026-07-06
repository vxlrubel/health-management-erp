<?php

namespace App\Http\Requests\Utility;

use Illuminate\Foundation\Http\FormRequest;

class StoreSystemConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'key' => ['required', 'string', 'max:255', 'unique:system_configurations,key'],
            'value' => ['required', 'string'],
            'description' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'string', 'in:text,boolean,number,json'],
            'group' => ['nullable', 'string', 'max:255'],
        ];
    }
}

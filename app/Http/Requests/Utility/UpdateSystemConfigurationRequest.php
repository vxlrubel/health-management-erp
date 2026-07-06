<?php

namespace App\Http\Requests\Utility;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSystemConfigurationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $uuid = $this->route('system_configuration');

        return [
            'key' => ['required', 'string', 'max:255', Rule::unique('system_configurations', 'key')->ignore($uuid, 'uuid')],
            'value' => ['required', 'string'],
            'description' => ['nullable', 'string', 'max:1000'],
            'type' => ['required', 'string', 'in:text,boolean,number,json'],
            'group' => ['nullable', 'string', 'max:255'],
        ];
    }
}

<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $settingId = $this->route('setting')?->id ?? $this->route('id');

        return [
            'key' => ['sometimes', 'required', 'string', 'max:255', 'unique:settings,key,'.$settingId],
            'group' => ['nullable', 'string', 'max:255'],
            'name' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'value' => ['nullable', 'string'],
            'type' => ['nullable', 'string', 'max:50'],
            'is_public' => ['boolean'],
        ];
    }
}

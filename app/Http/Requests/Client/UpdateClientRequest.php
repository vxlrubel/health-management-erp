<?php

namespace App\Http\Requests\Client;

use App\Enums\GeneralStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $clientId = $this->route('client')?->id ?? $this->route('id');

        return [
            'branch_id' => ['sometimes', 'exists:branches,id'],
            'funder_id' => ['nullable', 'exists:funders,id'],
            'client_no' => ['sometimes', 'string', 'max:50', 'unique:clients,client_no,'.$clientId],
            'first_name' => ['sometimes', 'string', 'max:255'],
            'last_name' => ['sometimes', 'string', 'max:255'],
            'dob' => ['nullable', 'date', 'before:today'],
            'email' => ['nullable', 'email', 'max:255', 'unique:clients,email,'.$clientId],
            'phone' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string'],
            'care_level' => ['nullable', 'string', 'max:50'],
            'status' => ['sometimes', new Enum(GeneralStatus::class)],
            'next_of_kin_name' => ['nullable', 'string', 'max:255'],
            'next_of_kin_phone' => ['nullable', 'string', 'max:50'],
        ];
    }
}

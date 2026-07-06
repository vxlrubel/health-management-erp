<?php

namespace App\Http\Requests\Finance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_type' => ['nullable', 'string', 'max:50'],
            'employee_id' => ['nullable', 'exists:employees,id'],
            'client_id' => ['nullable', 'exists:clients,id'],
            'funder_id' => ['nullable', 'exists:funders,id'],
            'amount' => ['sometimes', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'total' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['nullable', 'string', 'in:draft,pending,paid,partially_paid,cancelled'],
            'due_date' => ['nullable', 'date'],
            'paid_date' => ['nullable', 'date'],
        ];
    }
}

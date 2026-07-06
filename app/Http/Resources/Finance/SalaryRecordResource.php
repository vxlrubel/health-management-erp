<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalaryRecordResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'employee_id' => $this->employee_id,
            'branch_id' => $this->branch_id,
            'month' => $this->month,
            'working_hours' => $this->working_hours,
            'hourly_rate' => $this->hourly_rate,
            'overtime' => $this->overtime,
            'bonus' => $this->bonus,
            'deduction' => $this->deduction,
            'net_salary' => $this->net_salary,
            'status' => $this->status,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'branch_id' => $this->branch_id,
            'funder_id' => $this->funder_id,
            'client_no' => $this->client_no,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'dob' => $this->dob?->format('Y-m-d'),
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'care_level' => $this->care_level,
            'status' => $this->status?->value,
            'next_of_kin_name' => $this->next_of_kin_name,
            'next_of_kin_phone' => $this->next_of_kin_phone,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'branch' => BranchResource::make($this->whenLoaded('branch')),
            'funder' => FunderResource::make($this->whenLoaded('funder')),
            'employees' => EmployeeResource::collection($this->whenLoaded('employees')),
            'carePlans' => CarePlanResource::collection($this->whenLoaded('carePlans')),
        ];
    }
}

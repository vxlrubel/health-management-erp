<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineAdministrationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'medicine_id' => $this->medicine_id,
            'client_id' => $this->client_id,
            'employee_id' => $this->employee_id,
            'administered_at' => $this->administered_at?->format('Y-m-d H:i:s'),
            'dose_given' => $this->dose_given,
            'status' => $this->status,
            'notes' => $this->notes,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'deleted_by' => $this->deleted_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'medicine' => new MedicineResource($this->whenLoaded('medicine')),
            'client' => new ClientResource($this->whenLoaded('client')),
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
        ];
    }
}

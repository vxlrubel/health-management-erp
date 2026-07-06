<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeDocumentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'employee_id' => $this->employee_id,
            'type' => $this->type,
            'title' => $this->title,
            'file_path' => $this->file_path,
            'expiry_date' => $this->expiry_date?->format('Y-m-d'),
            'is_verified' => $this->is_verified,
            'verified_by' => $this->verified_by,
            'verified_at' => $this->verified_at?->format('Y-m-d H:i:s'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'employee' => EmployeeResource::make($this->whenLoaded('employee')),
        ];
    }
}

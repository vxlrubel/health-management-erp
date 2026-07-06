<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecurringRotaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'branch_id' => $this->branch_id,
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'rota_id' => $this->rota_id,
            'rota' => new RotaResource($this->whenLoaded('rota')),
            'shift_template_id' => $this->shift_template_id,
            'shift_template' => new ShiftTemplateResource($this->whenLoaded('shiftTemplate')),
            'frequency' => $this->frequency,
            'days_of_week' => $this->days_of_week,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'schedule_id' => $this->schedule_id,
            'schedule' => new ScheduleResource($this->whenLoaded('schedule')),
            'employee_id' => $this->employee_id,
            'employee' => new EmployeeResource($this->whenLoaded('employee')),
            'client_id' => $this->client_id,
            'client' => new ClientResource($this->whenLoaded('client')),
            'branch_id' => $this->branch_id,
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'activity_type' => $this->activity_type,
            'notes' => $this->notes,
            'start_datetime' => $this->start_datetime,
            'end_datetime' => $this->end_datetime,
            'actual_hours' => $this->actual_hours,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}

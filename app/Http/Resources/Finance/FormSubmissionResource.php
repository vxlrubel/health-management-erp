<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormSubmissionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'form_id' => $this->form_id,
            'submitted_by' => $this->submitted_by,
            'subject_type' => $this->subject_type,
            'subject_id' => $this->subject_id,
            'answers_json' => $this->answers_json,
            'status' => $this->status,
            'submitted_at' => $this->submitted_at?->toISOString(),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}

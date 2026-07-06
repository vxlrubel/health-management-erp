<?php

namespace App\Http\Resources\Utility;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SystemConfigurationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'key' => $this->key,
            'value' => $this->when($request->user()?->can('view-sensitive-config'), fn () => $this->value, $this->value),
            'description' => $this->description,
            'type' => $this->type,
            'group' => $this->group,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

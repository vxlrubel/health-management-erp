<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'address' => $this->address,
            'city' => $this->city,
            'postcode' => $this->postcode,
            'phone' => $this->phone,
            'email' => $this->email,
            'manager' => new UserResource($this->whenLoaded('manager')),
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}

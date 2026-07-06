<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LeaveCollection extends ResourceCollection
{
    public $collects = LeaveResource::class;

    public function toArray(Request $request): array
    {
        return ['data' => $this->collection];
    }
}

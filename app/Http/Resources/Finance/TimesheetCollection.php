<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TimesheetCollection extends ResourceCollection
{
    public $collects = TimesheetResource::class;

    public function toArray(Request $request): array
    {
        return ['data' => $this->collection];
    }
}

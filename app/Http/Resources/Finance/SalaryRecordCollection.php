<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SalaryRecordCollection extends ResourceCollection
{
    public $collects = SalaryRecordResource::class;

    public function toArray(Request $request): array
    {
        return ['data' => $this->collection];
    }
}

<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InvoiceItemCollection extends ResourceCollection
{
    public $collects = InvoiceItemResource::class;

    public function toArray(Request $request): array
    {
        return ['data' => $this->collection];
    }
}

<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class InvoicePaymentCollection extends ResourceCollection
{
    public $collects = InvoicePaymentResource::class;

    public function toArray(Request $request): array
    {
        return ['data' => $this->collection];
    }
}

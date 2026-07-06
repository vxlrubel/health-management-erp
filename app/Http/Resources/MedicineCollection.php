<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MedicineCollection extends ResourceCollection
{
    public $collects = MedicineResource::class;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}

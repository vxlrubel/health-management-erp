<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MedicineAdministrationCollection extends ResourceCollection
{
    public $collects = MedicineAdministrationResource::class;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}

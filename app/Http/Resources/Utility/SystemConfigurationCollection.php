<?php

namespace App\Http\Resources\Utility;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SystemConfigurationCollection extends ResourceCollection
{
    public $collects = SystemConfigurationResource::class;

    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection,
        ];
    }
}

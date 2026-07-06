<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingCollection extends ResourceCollection
{
    public $collects = SettingResource::class;

    public function toArray(Request $request): array
    {
        return parent::toArray($request);
    }
}

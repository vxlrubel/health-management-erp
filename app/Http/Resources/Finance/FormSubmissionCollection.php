<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FormSubmissionCollection extends ResourceCollection
{
    public $collects = FormSubmissionResource::class;

    public function toArray(Request $request): array
    {
        return ['data' => $this->collection];
    }
}

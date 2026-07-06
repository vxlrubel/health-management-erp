<?php

namespace App\Repositories\Eloquent;

use App\Models\Report;

class ReportRepository extends BaseRepository
{
    public function __construct(Report $model)
    {
        parent::__construct($model);
    }

    protected function searchableFields(): array
    {
        return ['name', 'type', 'status'];
    }
}

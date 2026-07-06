<?php

namespace App\Repositories\Eloquent;

use App\Models\Medicine;

class MedicineRepository extends BaseRepository
{
    public function __construct(Medicine $model)
    {
        parent::__construct($model);
    }

    protected function searchableFields(): array
    {
        return ['name', 'dosage', 'frequency', 'route', 'prescribed_by'];
    }
}

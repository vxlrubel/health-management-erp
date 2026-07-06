<?php

namespace App\Repositories\Eloquent;

use App\Models\MedicineAdministration;

class MedicineAdministrationRepository extends BaseRepository
{
    public function __construct(MedicineAdministration $model)
    {
        parent::__construct($model);
    }

    protected function searchableFields(): array
    {
        return ['dose_given', 'notes'];
    }
}

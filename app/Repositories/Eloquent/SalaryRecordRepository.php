<?php

namespace App\Repositories\Eloquent;

use App\Models\SalaryRecord;
use App\Repositories\Contracts\SalaryRecordRepositoryInterface;

class SalaryRecordRepository extends BaseRepository implements SalaryRecordRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new SalaryRecord);
    }
}

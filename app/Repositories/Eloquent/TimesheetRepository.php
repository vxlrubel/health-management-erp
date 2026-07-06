<?php

namespace App\Repositories\Eloquent;

use App\Models\Timesheet;
use App\Repositories\Contracts\TimesheetRepositoryInterface;

class TimesheetRepository extends BaseRepository implements TimesheetRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Timesheet);
    }
}

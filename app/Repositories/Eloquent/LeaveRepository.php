<?php

namespace App\Repositories\Eloquent;

use App\Models\Leave;
use App\Repositories\Contracts\LeaveRepositoryInterface;

class LeaveRepository extends BaseRepository implements LeaveRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Leave);
    }
}

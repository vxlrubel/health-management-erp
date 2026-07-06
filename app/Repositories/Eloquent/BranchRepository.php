<?php

namespace App\Repositories\Eloquent;

use App\Models\Branch;
use App\Repositories\Contracts\BranchRepositoryInterface;

class BranchRepository extends BaseRepository implements BranchRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Branch);
    }

    protected function searchableFields(): array
    {
        return ['name', 'code', 'city'];
    }
}

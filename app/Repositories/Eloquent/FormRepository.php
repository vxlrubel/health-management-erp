<?php

namespace App\Repositories\Eloquent;

use App\Models\Form;
use App\Repositories\Contracts\FormRepositoryInterface;

class FormRepository extends BaseRepository implements FormRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new Form);
    }
}

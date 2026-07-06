<?php

namespace App\Repositories\Eloquent;

use App\Models\FormSubmission;
use App\Repositories\Contracts\FormSubmissionRepositoryInterface;

class FormSubmissionRepository extends BaseRepository implements FormSubmissionRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new FormSubmission);
    }
}

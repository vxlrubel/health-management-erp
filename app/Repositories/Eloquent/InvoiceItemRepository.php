<?php

namespace App\Repositories\Eloquent;

use App\Models\InvoiceItem;
use App\Repositories\Contracts\InvoiceItemRepositoryInterface;

class InvoiceItemRepository extends BaseRepository implements InvoiceItemRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new InvoiceItem);
    }
}

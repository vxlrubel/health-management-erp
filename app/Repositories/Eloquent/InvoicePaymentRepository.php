<?php

namespace App\Repositories\Eloquent;

use App\Models\InvoicePayment;
use App\Repositories\Contracts\InvoicePaymentRepositoryInterface;

class InvoicePaymentRepository extends BaseRepository implements InvoicePaymentRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new InvoicePayment);
    }
}

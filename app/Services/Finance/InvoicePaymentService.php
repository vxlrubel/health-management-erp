<?php

namespace App\Services\Finance;

use App\Models\InvoicePayment;
use App\Repositories\Contracts\InvoicePaymentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class InvoicePaymentService
{
    public function __construct(
        protected InvoicePaymentRepositoryInterface $repository,
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $options);
    }

    public function findByUuid(string $uuid): ?InvoicePayment
    {
        return $this->repository->findByUuid($uuid);
    }

    public function create(array $data): InvoicePayment
    {
        return $this->repository->create($data);
    }

    public function update(InvoicePayment $payment, array $data): InvoicePayment
    {
        return $this->repository->update($payment, $data);
    }

    public function softDelete(InvoicePayment $payment): bool
    {
        return $this->repository->softDelete($payment);
    }

    public function restore(string $uuid): ?InvoicePayment
    {
        return $this->repository->restore($uuid);
    }

    public function forceDelete(string $uuid): bool
    {
        return $this->repository->forceDelete($uuid);
    }

    public function bulkDelete(array $uuids): bool
    {
        return $this->repository->bulkDelete($uuids);
    }

    public function bulkRestore(array $uuids): bool
    {
        return $this->repository->bulkRestore($uuids);
    }
}

<?php

namespace App\Services\Finance;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Repositories\Contracts\InvoiceRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class InvoiceService
{
    public function __construct(
        protected InvoiceRepositoryInterface $repository,
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $options);
    }

    public function findByUuid(string $uuid): ?Invoice
    {
        return $this->repository->findByUuid($uuid);
    }

    public function create(array $data): Invoice
    {
        return DB::transaction(function () use ($data) {
            $data['invoice_number'] = $data['invoice_number'] ?? $this->generateInvoiceNumber();
            $data['paid_amount'] = $data['paid_amount'] ?? 0;
            $data['balance'] = ($data['total'] ?? 0) - ($data['paid_amount'] ?? 0);
            $data['status'] = $data['status'] ?? InvoiceStatus::Draft->value;

            $invoice = $this->repository->create($data);

            if (! empty($data['items'])) {
                foreach ($data['items'] as $item) {
                    $invoice->items()->create($item);
                }
            }

            return $invoice->fresh()->load(['items', 'payments']);
        });
    }

    public function update(Invoice $invoice, array $data): Invoice
    {
        return DB::transaction(function () use ($invoice, $data) {
            if (isset($data['total'])) {
                $data['balance'] = $data['total'] - ($invoice->paid_amount ?? 0);
            }

            return $this->repository->update($invoice, $data);
        });
    }

    public function softDelete(Invoice $invoice): bool
    {
        return $this->repository->softDelete($invoice);
    }

    public function restore(string $uuid): ?Invoice
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

    public function pay(string $uuid, array $paymentData): ?Invoice
    {
        $invoice = $this->repository->findByUuid($uuid);
        if (! $invoice) {
            return null;
        }

        return DB::transaction(function () use ($invoice, $paymentData) {
            $paymentAmount = $paymentData['amount'];

            $invoice->payments()->create([
                'amount' => $paymentAmount,
                'payment_date' => $paymentData['payment_date'] ?? now(),
                'payment_method' => $paymentData['payment_method'],
                'reference' => $paymentData['reference'] ?? null,
                'status' => $paymentData['status'] ?? 'completed',
            ]);

            $newPaid = ($invoice->paid_amount ?? 0) + $paymentAmount;
            $newBalance = $invoice->total - $newPaid;

            $status = $newBalance <= 0 ? InvoiceStatus::Paid : InvoiceStatus::PartiallyPaid;

            return $this->repository->update($invoice, [
                'paid_amount' => $newPaid,
                'balance' => $newBalance,
                'status' => $status,
                'paid_date' => $status === InvoiceStatus::Paid ? now() : $invoice->paid_date,
            ]);
        });
    }

    public function cancel(string $uuid): ?Invoice
    {
        $invoice = $this->repository->findByUuid($uuid);
        if (! $invoice) {
            return null;
        }

        if ($invoice->status === InvoiceStatus::Paid) {
            return null;
        }

        return $this->repository->update($invoice, [
            'status' => InvoiceStatus::Cancelled,
        ]);
    }

    public function generateInvoiceNumber(): string
    {
        $prefix = 'INV-';
        $date = now()->format('Ymd');
        $last = Invoice::where('invoice_number', 'like', "{$prefix}{$date}-%")
            ->orderBy('id', 'desc')
            ->first();

        if ($last) {
            $lastNumber = (int) substr($last->invoice_number, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "{$prefix}{$date}-".str_pad((string) $newNumber, 4, '0', STR_PAD_LEFT);
    }
}

<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreInvoicePaymentRequest;
use App\Http\Requests\Finance\UpdateInvoicePaymentRequest;
use App\Http\Resources\Finance\InvoicePaymentCollection;
use App\Http\Resources\Finance\InvoicePaymentResource;
use App\Services\Finance\InvoicePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoicePaymentController extends Controller
{
    public function __construct(
        protected InvoicePaymentService $service,
    ) {}

    /**
     * List invoice payments
     *
     * @queryParam search string Search term.
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam page int Page number. Example: 1
     * @queryParam invoice_id int Filter by invoice ID. Example: 1
     */
    public function index(Request $request): InvoicePaymentCollection
    {
        $payments = $this->service->paginate($request->all(), $request->all());

        return new InvoicePaymentCollection($payments);
    }

    /**
     * Show invoice payment
     *
     * @urlParam uuid string required Payment UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $payment = $this->service->findByUuid($uuid);

        if (! $payment) {
            return $this->notFoundResponse('Payment not found.');
        }

        return $this->successResponse(new InvoicePaymentResource($payment));
    }

    /**
     * Create invoice payment
     *
     * @bodyParam invoice_id int required Invoice ID. Example: 1
     * @bodyParam amount numeric required Payment amount. Example: 500.00
     * @bodyParam payment_date date required Payment date. Example: 2024-01-15
     * @bodyParam payment_method string required Payment method. Enum: cash,bank_transfer,card,cheque,direct_debit,other
     * @bodyParam reference string Payment reference. Example: "TXN123"
     */
    public function store(StoreInvoicePaymentRequest $request): JsonResponse
    {
        $payment = $this->service->create($request->validated());

        return $this->createdResponse(new InvoicePaymentResource($payment), 'Payment created successfully.');
    }

    /**
     * Update invoice payment
     *
     * @urlParam uuid string required Payment UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @bodyParam amount numeric Payment amount. Example: 600.00
     */
    public function update(UpdateInvoicePaymentRequest $request, string $uuid): JsonResponse
    {
        $payment = $this->service->findByUuid($uuid);

        if (! $payment) {
            return $this->notFoundResponse('Payment not found.');
        }

        $payment = $this->service->update($payment, $request->validated());

        return $this->successResponse(new InvoicePaymentResource($payment), 'Payment updated successfully.');
    }

    /**
     * Delete invoice payment (soft)
     *
     * @urlParam uuid string required Payment UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $payment = $this->service->findByUuid($uuid);

        if (! $payment) {
            return $this->notFoundResponse('Payment not found.');
        }

        $this->service->softDelete($payment);

        return $this->deletedResponse('Payment deleted successfully.');
    }

    /**
     * List trashed payments
     *
     * @queryParam per_page int Items per page. Example: 15
     */
    public function trash(Request $request): InvoicePaymentCollection
    {
        $payments = $this->service->paginate(
            array_merge($request->all(), ['trashed' => true]),
            $request->all()
        );

        return new InvoicePaymentCollection($payments);
    }

    /**
     * Restore payment
     *
     * @urlParam uuid string required Payment UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $payment = $this->service->restore($uuid);

        if (! $payment) {
            return $this->notFoundResponse('Payment not found in trash.');
        }

        return $this->successResponse(new InvoicePaymentResource($payment), 'Payment restored successfully.');
    }

    /**
     * Force delete payment
     *
     * @urlParam uuid string required Payment UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->service->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Payment not found.');
        }

        return $this->deletedResponse('Payment permanently deleted.');
    }

    /**
     * Bulk delete payments
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Payments deleted successfully.');
    }

    /**
     * Bulk restore payments
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Payments restored successfully.');
    }
}

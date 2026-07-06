<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreInvoiceRequest;
use App\Http\Requests\Finance\UpdateInvoiceRequest;
use App\Http\Resources\Finance\InvoiceCollection;
use App\Http\Resources\Finance\InvoiceResource;
use App\Services\Finance\InvoiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(
        protected InvoiceService $service,
    ) {}

    /**
     * List invoices
     *
     * @queryParam search string Search term. Example: "INV-"
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam page int Page number. Example: 1
     * @queryParam status string Filter by status. Example: pending
     */
    public function index(Request $request): InvoiceCollection
    {
        $invoices = $this->service->paginate($request->all(), $request->all());

        return new InvoiceCollection($invoices);
    }

    /**
     * Show invoice
     *
     * @urlParam uuid string required Invoice UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $invoice = $this->service->findByUuid($uuid);

        if (! $invoice) {
            return $this->notFoundResponse('Invoice not found.');
        }

        $invoice->load(['items', 'payments']);

        return $this->successResponse(new InvoiceResource($invoice));
    }

    /**
     * Create invoice
     *
     * @bodyParam invoice_type string Invoice type. Example: "service"
     * @bodyParam employee_id int Employee ID. Example: 1
     * @bodyParam client_id int Client ID. Example: 1
     * @bodyParam funder_id int Funder ID. Example: 1
     * @bodyParam amount numeric required Amount. Example: 1000.00
     * @bodyParam tax numeric Tax. Example: 50.00
     * @bodyParam discount numeric Discount. Example: 20.00
     * @bodyParam total numeric required Total. Example: 1030.00
     * @bodyParam due_date date Due date. Example: 2024-02-01
     * @bodyParam items array Invoice items. Example: [{"description":"Service","quantity":1,"unit_price":1000,"total":1000}]
     */
    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        $invoice = $this->service->create($request->validated());

        return $this->createdResponse(new InvoiceResource($invoice), 'Invoice created successfully.');
    }

    /**
     * Update invoice
     *
     * @urlParam uuid string required Invoice UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @bodyParam amount numeric Amount. Example: 1200.00
     * @bodyParam total numeric Total. Example: 1230.00
     */
    public function update(UpdateInvoiceRequest $request, string $uuid): JsonResponse
    {
        $invoice = $this->service->findByUuid($uuid);

        if (! $invoice) {
            return $this->notFoundResponse('Invoice not found.');
        }

        $invoice = $this->service->update($invoice, $request->validated());

        return $this->successResponse(new InvoiceResource($invoice), 'Invoice updated successfully.');
    }

    /**
     * Delete invoice (soft)
     *
     * @urlParam uuid string required Invoice UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $invoice = $this->service->findByUuid($uuid);

        if (! $invoice) {
            return $this->notFoundResponse('Invoice not found.');
        }

        $this->service->softDelete($invoice);

        return $this->deletedResponse('Invoice deleted successfully.');
    }

    /**
     * Pay invoice
     *
     * @urlParam uuid string required Invoice UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @bodyParam amount numeric required Payment amount. Example: 500.00
     * @bodyParam payment_method string required Payment method. Enum: cash,bank_transfer,card,cheque,direct_debit,other
     * @bodyParam payment_date date Payment date. Example: 2024-01-15
     * @bodyParam reference string Payment reference. Example: "TXN123"
     */
    public function pay(Request $request, string $uuid): JsonResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'payment_method' => ['required', 'string', 'in:cash,bank_transfer,card,cheque,direct_debit,other'],
            'payment_date' => ['nullable', 'date'],
            'reference' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string'],
        ]);

        $invoice = $this->service->pay($uuid, $request->all());

        if (! $invoice) {
            return $this->notFoundResponse('Invoice not found or already paid.');
        }

        return $this->successResponse(new InvoiceResource($invoice), 'Payment recorded successfully.');
    }

    /**
     * Cancel invoice
     *
     * @urlParam uuid string required Invoice UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function cancel(string $uuid): JsonResponse
    {
        $invoice = $this->service->cancel($uuid);

        if (! $invoice) {
            return $this->notFoundResponse('Invoice not found or cannot be cancelled.');
        }

        return $this->successResponse(new InvoiceResource($invoice), 'Invoice cancelled successfully.');
    }

    /**
     * List trashed invoices
     *
     * @queryParam per_page int Items per page. Example: 15
     */
    public function trash(Request $request): InvoiceCollection
    {
        $invoices = $this->service->paginate(
            array_merge($request->all(), ['trashed' => true]),
            $request->all()
        );

        return new InvoiceCollection($invoices);
    }

    /**
     * Restore invoice
     *
     * @urlParam uuid string required Invoice UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $invoice = $this->service->restore($uuid);

        if (! $invoice) {
            return $this->notFoundResponse('Invoice not found in trash.');
        }

        return $this->successResponse(new InvoiceResource($invoice), 'Invoice restored successfully.');
    }

    /**
     * Force delete invoice
     *
     * @urlParam uuid string required Invoice UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->service->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Invoice not found.');
        }

        return $this->deletedResponse('Invoice permanently deleted.');
    }

    /**
     * Bulk delete invoices
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Invoices deleted successfully.');
    }

    /**
     * Bulk restore invoices
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Invoices restored successfully.');
    }

    /**
     * Export invoices
     *
     * @queryParam status string Filter by status. Example: paid
     * @queryParam from string Start date. Example: 2024-01-01
     * @queryParam to string End date. Example: 2024-12-31
     */
    public function export(Request $request): JsonResponse
    {
        $invoices = $this->service->paginate($request->all(), array_merge($request->all(), ['per_page' => 1000]));

        return $this->successResponse(new InvoiceCollection($invoices), 'Invoices exported successfully.');
    }
}

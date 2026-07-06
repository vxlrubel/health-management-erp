<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Http\Resources\MedicineCollection;
use App\Http\Resources\MedicineResource;
use App\Models\Medicine;
use App\Services\MedicineService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function __construct(
        protected MedicineService $medicineService
    ) {}

    /**
     * List medicines
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'status', 'client_id']);
        $options = [
            'per_page' => $request->input('per_page', 15),
            'sort_by' => $request->input('sort_by', 'created_at'),
            'sort_order' => $request->input('sort_order', 'desc'),
        ];

        $medicines = $this->medicineService->paginate($filters, $options);

        return $this->paginatedResponse(
            new MedicineCollection($medicines)
        );
    }

    /**
     * Show medicine
     */
    public function show(string $uuid): JsonResponse
    {
        $medicine = $this->medicineService->findByUuid($uuid);

        if (! $medicine) {
            return $this->notFoundResponse('Medicine not found.');
        }

        return $this->successResponse(
            new MedicineResource($medicine->load(['client', 'administrations']))
        );
    }

    /**
     * Create medicine
     */
    public function store(StoreMedicineRequest $request): JsonResponse
    {
        $medicine = $this->medicineService->create($request->validated());

        return $this->createdResponse(
            new MedicineResource($medicine),
            'Medicine created successfully.'
        );
    }

    /**
     * Update medicine
     */
    public function update(UpdateMedicineRequest $request, string $uuid): JsonResponse
    {
        $medicine = $this->medicineService->findByUuid($uuid);

        if (! $medicine) {
            return $this->notFoundResponse('Medicine not found.');
        }

        $medicine = $this->medicineService->update($medicine, $request->validated());

        return $this->successResponse(
            new MedicineResource($medicine),
            'Medicine updated successfully.'
        );
    }

    /**
     * Delete medicine (soft delete)
     */
    public function destroy(string $uuid): JsonResponse
    {
        $medicine = $this->medicineService->findByUuid($uuid);

        if (! $medicine) {
            return $this->notFoundResponse('Medicine not found.');
        }

        $this->medicineService->delete($medicine);

        return $this->deletedResponse('Medicine deleted successfully.');
    }

    /**
     * List trashed medicines
     */
    public function trash(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);

        $medicines = Medicine::onlyTrashed()->paginate($perPage);

        return $this->paginatedResponse(
            new MedicineCollection($medicines)
        );
    }

    /**
     * Restore medicine
     */
    public function restore(string $uuid): JsonResponse
    {
        $medicine = $this->medicineService->restore($uuid);

        if (! $medicine) {
            return $this->notFoundResponse('Medicine not found or not trashed.');
        }

        return $this->successResponse(
            new MedicineResource($medicine),
            'Medicine restored successfully.'
        );
    }

    /**
     * Force delete medicine
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->medicineService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Medicine not found.');
        }

        return $this->deletedResponse('Medicine permanently deleted.');
    }

    /**
     * Bulk delete medicines
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'exists:medicines,uuid']]);

        $this->medicineService->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Medicines deleted successfully.');
    }

    /**
     * Bulk restore medicines
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string']]);

        $this->medicineService->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Medicines restored successfully.');
    }

    /**
     * Export medicines
     */
    public function export(): JsonResponse
    {
        $medicines = $this->medicineService->export();

        return $this->successResponse(
            MedicineResource::collection($medicines),
            'Medicines exported successfully.'
        );
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarePlan\StoreCarePlanRequest;
use App\Http\Requests\CarePlan\UpdateCarePlanRequest;
use App\Http\Resources\CarePlanCollection;
use App\Http\Resources\CarePlanResource;
use App\Models\CarePlan;
use App\Services\CarePlanService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarePlanController extends Controller
{
    protected CarePlanService $carePlanService;

    public function __construct(CarePlanService $carePlanService)
    {
        $this->carePlanService = $carePlanService;
    }

    /**
     * Display a paginated listing of care plans.
     */
    public function index(Request $request): JsonResponse
    {
        $carePlans = $this->carePlanService->paginate(
            $request->only(['search', 'status', 'client_id']),
            $request->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(new CarePlanCollection($carePlans));
    }

    /**
     * Display the specified care plan.
     */
    public function show(string $uuid): JsonResponse
    {
        $carePlan = $this->carePlanService->findByUuid($uuid);

        if (! $carePlan) {
            return $this->notFoundResponse('Care plan not found.');
        }

        return $this->successResponse(new CarePlanResource($carePlan));
    }

    /**
     * Store a newly created care plan.
     */
    public function store(StoreCarePlanRequest $request): JsonResponse
    {
        $carePlan = $this->carePlanService->create($request->validated());

        return $this->createdResponse(new CarePlanResource($carePlan), 'Care plan created successfully.');
    }

    /**
     * Update the specified care plan.
     */
    public function update(UpdateCarePlanRequest $request, CarePlan $carePlan): JsonResponse
    {
        $carePlan = $this->carePlanService->update($carePlan, $request->validated());

        return $this->successResponse(new CarePlanResource($carePlan), 'Care plan updated successfully.');
    }

    /**
     * Remove the specified care plan (soft delete).
     */
    public function destroy(CarePlan $carePlan): JsonResponse
    {
        $this->carePlanService->delete($carePlan);

        return $this->deletedResponse('Care plan deleted successfully.');
    }

    /**
     * Display a paginated listing of trashed care plans.
     */
    public function trash(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $carePlans = CarePlan::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse(new CarePlanCollection($carePlans));
    }

    /**
     * Restore a trashed care plan.
     */
    public function restore(string $uuid): JsonResponse
    {
        $carePlan = $this->carePlanService->restore($uuid);

        if (! $carePlan) {
            return $this->notFoundResponse('Care plan not found or not trashed.');
        }

        return $this->successResponse(new CarePlanResource($carePlan), 'Care plan restored successfully.');
    }

    /**
     * Permanently delete a trashed care plan.
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->carePlanService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Care plan not found.');
        }

        return $this->deletedResponse('Care plan permanently deleted.');
    }

    /**
     * Bulk delete care plans.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'exists:care_plans,uuid']]);

        $this->carePlanService->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Care plans deleted successfully.');
    }

    /**
     * Bulk restore care plans.
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string']]);

        $this->carePlanService->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Care plans restored successfully.');
    }

    /**
     * Export care plans list.
     */
    public function export(Request $request): JsonResponse
    {
        return $this->successResponse(null, 'Export functionality not implemented yet.');
    }
}

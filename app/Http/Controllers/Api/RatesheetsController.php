<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ratesheet\StoreRatesheetRequest;
use App\Http\Requests\Ratesheet\UpdateRatesheetRequest;
use App\Http\Resources\RatesheetCollection;
use App\Http\Resources\RatesheetResource;
use App\Services\RatesheetService;
use Illuminate\Http\JsonResponse;

class RatesheetsController extends Controller
{
    public function __construct(
        private readonly RatesheetService $ratesheetService
    ) {}

    /**
     * List all ratesheets.
     *
     * @queryParam search string Search by name or description. Example: Standard
     * @queryParam branch_id int Filter by branch. Example: 1
     * @queryParam status string Filter by status (active,inactive,suspended,archived). Example: active
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam sort_by string Field to sort by. Example: created_at
     * @queryParam sort_order string Sort direction (asc,desc). Example: desc
     */
    public function index(): JsonResponse
    {
        $ratesheets = $this->ratesheetService->paginate(
            request()->only(['search', 'branch_id', 'status']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new RatesheetCollection($ratesheets)
        );
    }

    /**
     * Store a newly created ratesheet.
     *
     * @bodyParam branch_id int required Branch ID. Example: 1
     * @bodyParam name string required Ratesheet name. Example: Standard Rate
     * @bodyParam description string optional Description. Example: Standard hourly rate for regular hours
     * @bodyParam hourly_rate numeric required Hourly rate. Example: 25.50
     * @bodyParam weekend_rate numeric required Weekend rate. Example: 35.00
     * @bodyParam holiday_rate numeric required Holiday rate. Example: 45.00
     * @bodyParam night_rate numeric required Night rate. Example: 30.00
     * @bodyParam status string optional Status. Example: active
     */
    public function store(StoreRatesheetRequest $request): JsonResponse
    {
        $ratesheet = $this->ratesheetService->create($request->validated());

        return $this->createdResponse(
            new RatesheetResource($ratesheet),
            'Ratesheet created successfully.'
        );
    }

    /**
     * Show the specified ratesheet.
     *
     * @urlParam uuid string required The UUID of the ratesheet. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $ratesheet = $this->ratesheetService->findByUuid($uuid);

        if (! $ratesheet) {
            return $this->notFoundResponse('Ratesheet not found.');
        }

        return $this->successResponse(
            new RatesheetResource($ratesheet)
        );
    }

    /**
     * Update the specified ratesheet.
     *
     * @urlParam uuid string required The UUID of the ratesheet. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function update(UpdateRatesheetRequest $request, string $uuid): JsonResponse
    {
        $ratesheet = $this->ratesheetService->findByUuid($uuid);

        if (! $ratesheet) {
            return $this->notFoundResponse('Ratesheet not found.');
        }

        $ratesheet = $this->ratesheetService->update($ratesheet, $request->validated());

        return $this->successResponse(
            new RatesheetResource($ratesheet),
            'Ratesheet updated successfully.'
        );
    }

    /**
     * Soft delete the specified ratesheet.
     *
     * @urlParam uuid string required The UUID of the ratesheet. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $ratesheet = $this->ratesheetService->findByUuid($uuid);

        if (! $ratesheet) {
            return $this->notFoundResponse('Ratesheet not found.');
        }

        $this->ratesheetService->delete($ratesheet);

        return $this->deletedResponse('Ratesheet deleted successfully.');
    }

    /**
     * Restore a soft deleted ratesheet.
     *
     * @urlParam uuid string required The UUID of the ratesheet. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $ratesheet = $this->ratesheetService->restore($uuid);

        if (! $ratesheet) {
            return $this->notFoundResponse('Ratesheet not found or not deleted.');
        }

        return $this->successResponse(
            new RatesheetResource($ratesheet),
            'Ratesheet restored successfully.'
        );
    }

    /**
     * List soft deleted ratesheets.
     */
    public function trash(): JsonResponse
    {
        $ratesheets = $this->ratesheetService->paginateTrashed(
            request()->only(['search', 'branch_id']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new RatesheetCollection($ratesheets)
        );
    }

    /**
     * Bulk delete ratesheets.
     *
     * @bodyParam uuids array required Array of UUIDs to delete. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->ratesheetService->bulkDelete($uuids);

        return $this->deletedResponse('Ratesheets deleted successfully.');
    }

    /**
     * Bulk restore ratesheets.
     *
     * @bodyParam uuids array required Array of UUIDs to restore. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->ratesheetService->bulkRestore($uuids);

        return $this->successResponse(null, 'Ratesheets restored successfully.');
    }

    /**
     * Permanently delete the specified ratesheet.
     *
     * @urlParam uuid string required The UUID of the ratesheet. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->ratesheetService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Ratesheet not found.');
        }

        return $this->deletedResponse('Ratesheet force deleted successfully.');
    }
}

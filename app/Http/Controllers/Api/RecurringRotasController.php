<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecurringRota\StoreRecurringRotaRequest;
use App\Http\Requests\RecurringRota\UpdateRecurringRotaRequest;
use App\Http\Resources\RecurringRotaCollection;
use App\Http\Resources\RecurringRotaResource;
use App\Http\Resources\ScheduleResource;
use App\Services\RecurringRotaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class RecurringRotasController extends Controller
{
    public function __construct(
        private readonly RecurringRotaService $recurringRotaService
    ) {}

    /**
     * List all recurring rotas.
     *
     * @queryParam search string Search by rota name. Example: Weekly
     * @queryParam branch_id int Filter by branch. Example: 1
     * @queryParam rota_id int Filter by rota. Example: 1
     * @queryParam status string Filter by status. Example: active
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam sort_by string Field to sort by. Example: created_at
     * @queryParam sort_order string Sort direction. Example: desc
     */
    public function index(): JsonResponse
    {
        $recurringRotas = $this->recurringRotaService->paginate(
            request()->only(['search', 'branch_id', 'rota_id', 'status']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new RecurringRotaCollection($recurringRotas)
        );
    }

    /**
     * Store a newly created recurring rota.
     *
     * @bodyParam branch_id int required Branch ID. Example: 1
     * @bodyParam rota_id int required Rota ID. Example: 1
     * @bodyParam shift_template_id int required Shift template ID. Example: 1
     * @bodyParam frequency string required Frequency (daily,weekly,biweekly,monthly). Example: weekly
     * @bodyParam days_of_week array optional Days of week (0=Sun,6=Sat). Example: [1,2,3,4,5]
     * @bodyParam start_date date required Start date. Example: 2024-01-01
     * @bodyParam end_date date required End date. Example: 2024-12-31
     * @bodyParam status string optional Status. Example: active
     */
    public function store(StoreRecurringRotaRequest $request): JsonResponse
    {
        $recurringRota = $this->recurringRotaService->create($request->validated());

        return $this->createdResponse(
            new RecurringRotaResource($recurringRota),
            'Recurring rota created successfully.'
        );
    }

    /**
     * Show the specified recurring rota.
     *
     * @urlParam uuid string required The UUID of the recurring rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $recurringRota = $this->recurringRotaService->findByUuid($uuid);

        if (! $recurringRota) {
            return $this->notFoundResponse('Recurring rota not found.');
        }

        return $this->successResponse(
            new RecurringRotaResource($recurringRota)
        );
    }

    /**
     * Update the specified recurring rota.
     *
     * @urlParam uuid string required The UUID of the recurring rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function update(UpdateRecurringRotaRequest $request, string $uuid): JsonResponse
    {
        $recurringRota = $this->recurringRotaService->findByUuid($uuid);

        if (! $recurringRota) {
            return $this->notFoundResponse('Recurring rota not found.');
        }

        $recurringRota = $this->recurringRotaService->update($recurringRota, $request->validated());

        return $this->successResponse(
            new RecurringRotaResource($recurringRota),
            'Recurring rota updated successfully.'
        );
    }

    /**
     * Soft delete the specified recurring rota.
     *
     * @urlParam uuid string required The UUID of the recurring rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $recurringRota = $this->recurringRotaService->findByUuid($uuid);

        if (! $recurringRota) {
            return $this->notFoundResponse('Recurring rota not found.');
        }

        $this->recurringRotaService->delete($recurringRota);

        return $this->deletedResponse('Recurring rota deleted successfully.');
    }

    /**
     * Restore a soft deleted recurring rota.
     *
     * @urlParam uuid string required The UUID of the recurring rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $recurringRota = $this->recurringRotaService->restore($uuid);

        if (! $recurringRota) {
            return $this->notFoundResponse('Recurring rota not found or not deleted.');
        }

        return $this->successResponse(
            new RecurringRotaResource($recurringRota),
            'Recurring rota restored successfully.'
        );
    }

    /**
     * List soft deleted recurring rotas.
     */
    public function trash(): JsonResponse
    {
        $recurringRotas = $this->recurringRotaService->paginateTrashed(
            request()->only(['search', 'branch_id']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new RecurringRotaCollection($recurringRotas)
        );
    }

    /**
     * Bulk delete recurring rotas.
     *
     * @bodyParam uuids array required Array of UUIDs to delete. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->recurringRotaService->bulkDelete($uuids);

        return $this->deletedResponse('Recurring rotas deleted successfully.');
    }

    /**
     * Bulk restore recurring rotas.
     *
     * @bodyParam uuids array required Array of UUIDs to restore. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->recurringRotaService->bulkRestore($uuids);

        return $this->successResponse(null, 'Recurring rotas restored successfully.');
    }

    /**
     * Permanently delete the specified recurring rota.
     *
     * @urlParam uuid string required The UUID of the recurring rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->recurringRotaService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Recurring rota not found.');
        }

        return $this->deletedResponse('Recurring rota force deleted successfully.');
    }

    /**
     * Generate schedules from a recurring rota.
     *
     * Generates schedule entries for the entire date range of the recurring rota.
     *
     * @urlParam uuid string required The UUID of the recurring rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function generate(string $uuid): JsonResponse
    {
        $recurringRota = $this->recurringRotaService->findByUuid($uuid);

        if (! $recurringRota) {
            return $this->notFoundResponse('Recurring rota not found.');
        }

        $schedules = $this->recurringRotaService->generate($uuid, Auth::user());

        return $this->successResponse(
            ScheduleResource::collection($schedules),
            'Schedules generated successfully.'
        );
    }
}

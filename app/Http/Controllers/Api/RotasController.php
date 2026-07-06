<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rota\StoreRotaRequest;
use App\Http\Requests\Rota\UpdateRotaRequest;
use App\Http\Resources\RotaCollection;
use App\Http\Resources\RotaResource;
use App\Services\RotaService;
use Illuminate\Http\JsonResponse;

class RotasController extends Controller
{
    public function __construct(
        private readonly RotaService $rotaService
    ) {}

    /**
     * List all rotas.
     *
     * @queryParam search string Search by name. Example: Morning Shift
     * @queryParam branch_id int Filter by branch. Example: 1
     * @queryParam ratesheet_id int Filter by ratesheet. Example: 1
     * @queryParam status string Filter by status. Example: active
     * @queryParam date_from string Filter by start date from. Example: 2024-01-01
     * @queryParam date_to string Filter by end date to. Example: 2024-12-31
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam sort_by string Field to sort by. Example: created_at
     * @queryParam sort_order string Sort direction. Example: desc
     */
    public function index(): JsonResponse
    {
        $rotas = $this->rotaService->paginate(
            request()->only(['search', 'branch_id', 'ratesheet_id', 'status', 'date_from', 'date_to']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new RotaCollection($rotas)
        );
    }

    /**
     * Store a newly created rota.
     *
     * @bodyParam branch_id int required Branch ID. Example: 1
     * @bodyParam ratesheet_id int optional Ratesheet ID. Example: 1
     * @bodyParam name string required Rota name. Example: Morning Shift
     * @bodyParam start_date date required Start date. Example: 2024-01-01
     * @bodyParam end_date date required End date. Example: 2024-01-31
     * @bodyParam start_time string required Start time (H:i). Example: 09:00
     * @bodyParam end_time string required End time (H:i). Example: 17:00
     * @bodyParam status string optional Status. Example: active
     */
    public function store(StoreRotaRequest $request): JsonResponse
    {
        $rota = $this->rotaService->create($request->validated());

        return $this->createdResponse(
            new RotaResource($rota),
            'Rota created successfully.'
        );
    }

    /**
     * Show the specified rota.
     *
     * @urlParam uuid string required The UUID of the rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $rota = $this->rotaService->findByUuid($uuid);

        if (! $rota) {
            return $this->notFoundResponse('Rota not found.');
        }

        return $this->successResponse(
            new RotaResource($rota)
        );
    }

    /**
     * Update the specified rota.
     *
     * @urlParam uuid string required The UUID of the rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function update(UpdateRotaRequest $request, string $uuid): JsonResponse
    {
        $rota = $this->rotaService->findByUuid($uuid);

        if (! $rota) {
            return $this->notFoundResponse('Rota not found.');
        }

        $rota = $this->rotaService->update($rota, $request->validated());

        return $this->successResponse(
            new RotaResource($rota),
            'Rota updated successfully.'
        );
    }

    /**
     * Soft delete the specified rota.
     *
     * @urlParam uuid string required The UUID of the rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $rota = $this->rotaService->findByUuid($uuid);

        if (! $rota) {
            return $this->notFoundResponse('Rota not found.');
        }

        $this->rotaService->delete($rota);

        return $this->deletedResponse('Rota deleted successfully.');
    }

    /**
     * Restore a soft deleted rota.
     *
     * @urlParam uuid string required The UUID of the rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $rota = $this->rotaService->restore($uuid);

        if (! $rota) {
            return $this->notFoundResponse('Rota not found or not deleted.');
        }

        return $this->successResponse(
            new RotaResource($rota),
            'Rota restored successfully.'
        );
    }

    /**
     * List soft deleted rotas.
     */
    public function trash(): JsonResponse
    {
        $rotas = $this->rotaService->paginateTrashed(
            request()->only(['search', 'branch_id']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new RotaCollection($rotas)
        );
    }

    /**
     * Bulk delete rotas.
     *
     * @bodyParam uuids array required Array of UUIDs to delete. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->rotaService->bulkDelete($uuids);

        return $this->deletedResponse('Rotas deleted successfully.');
    }

    /**
     * Bulk restore rotas.
     *
     * @bodyParam uuids array required Array of UUIDs to restore. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->rotaService->bulkRestore($uuids);

        return $this->successResponse(null, 'Rotas restored successfully.');
    }

    /**
     * Permanently delete the specified rota.
     *
     * @urlParam uuid string required The UUID of the rota. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->rotaService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Rota not found.');
        }

        return $this->deletedResponse('Rota force deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShiftTemplate\StoreShiftTemplateRequest;
use App\Http\Requests\ShiftTemplate\UpdateShiftTemplateRequest;
use App\Http\Resources\ShiftTemplateCollection;
use App\Http\Resources\ShiftTemplateResource;
use App\Services\ShiftTemplateService;
use Illuminate\Http\JsonResponse;

class ShiftTemplatesController extends Controller
{
    public function __construct(
        private readonly ShiftTemplateService $shiftTemplateService
    ) {}

    /**
     * List all shift templates.
     *
     * @queryParam search string Search by name. Example: Day Shift
     * @queryParam branch_id int Filter by branch. Example: 1
     * @queryParam status string Filter by status. Example: active
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam sort_by string Field to sort by. Example: created_at
     * @queryParam sort_order string Sort direction. Example: desc
     */
    public function index(): JsonResponse
    {
        $templates = $this->shiftTemplateService->paginate(
            request()->only(['search', 'branch_id', 'status']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new ShiftTemplateCollection($templates)
        );
    }

    /**
     * Store a newly created shift template.
     *
     * @bodyParam branch_id int required Branch ID. Example: 1
     * @bodyParam name string required Template name. Example: Day Shift
     * @bodyParam start_time string required Start time (H:i). Example: 09:00
     * @bodyParam end_time string required End time (H:i). Example: 17:00
     * @bodyParam planned_hours numeric required Planned hours. Example: 8.00
     * @bodyParam break_minutes int optional Break minutes. Example: 30
     * @bodyParam status string optional Status. Example: active
     */
    public function store(StoreShiftTemplateRequest $request): JsonResponse
    {
        $template = $this->shiftTemplateService->create($request->validated());

        return $this->createdResponse(
            new ShiftTemplateResource($template),
            'Shift template created successfully.'
        );
    }

    /**
     * Show the specified shift template.
     *
     * @urlParam uuid string required The UUID of the shift template. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $template = $this->shiftTemplateService->findByUuid($uuid);

        if (! $template) {
            return $this->notFoundResponse('Shift template not found.');
        }

        return $this->successResponse(
            new ShiftTemplateResource($template)
        );
    }

    /**
     * Update the specified shift template.
     *
     * @urlParam uuid string required The UUID of the shift template. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function update(UpdateShiftTemplateRequest $request, string $uuid): JsonResponse
    {
        $template = $this->shiftTemplateService->findByUuid($uuid);

        if (! $template) {
            return $this->notFoundResponse('Shift template not found.');
        }

        $template = $this->shiftTemplateService->update($template, $request->validated());

        return $this->successResponse(
            new ShiftTemplateResource($template),
            'Shift template updated successfully.'
        );
    }

    /**
     * Soft delete the specified shift template.
     *
     * @urlParam uuid string required The UUID of the shift template. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $template = $this->shiftTemplateService->findByUuid($uuid);

        if (! $template) {
            return $this->notFoundResponse('Shift template not found.');
        }

        $this->shiftTemplateService->delete($template);

        return $this->deletedResponse('Shift template deleted successfully.');
    }

    /**
     * Restore a soft deleted shift template.
     *
     * @urlParam uuid string required The UUID of the shift template. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $template = $this->shiftTemplateService->restore($uuid);

        if (! $template) {
            return $this->notFoundResponse('Shift template not found or not deleted.');
        }

        return $this->successResponse(
            new ShiftTemplateResource($template),
            'Shift template restored successfully.'
        );
    }

    /**
     * List soft deleted shift templates.
     */
    public function trash(): JsonResponse
    {
        $templates = $this->shiftTemplateService->paginateTrashed(
            request()->only(['search', 'branch_id']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new ShiftTemplateCollection($templates)
        );
    }

    /**
     * Bulk delete shift templates.
     *
     * @bodyParam uuids array required Array of UUIDs to delete. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->shiftTemplateService->bulkDelete($uuids);

        return $this->deletedResponse('Shift templates deleted successfully.');
    }

    /**
     * Bulk restore shift templates.
     *
     * @bodyParam uuids array required Array of UUIDs to restore. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->shiftTemplateService->bulkRestore($uuids);

        return $this->successResponse(null, 'Shift templates restored successfully.');
    }

    /**
     * Permanently delete the specified shift template.
     *
     * @urlParam uuid string required The UUID of the shift template. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->shiftTemplateService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Shift template not found.');
        }

        return $this->deletedResponse('Shift template force deleted successfully.');
    }
}

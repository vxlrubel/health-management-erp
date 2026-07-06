<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Schedule\StoreScheduleRequest;
use App\Http\Requests\Schedule\UpdateScheduleRequest;
use App\Http\Resources\ScheduleCollection;
use App\Http\Resources\ScheduleResource;
use App\Services\ScheduleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class SchedulesController extends Controller
{
    public function __construct(
        private readonly ScheduleService $scheduleService
    ) {}

    /**
     * List all schedules.
     *
     * @queryParam search string Search by employee name. Example: John
     * @queryParam employee_id int Filter by employee. Example: 1
     * @queryParam branch_id int Filter by branch. Example: 1
     * @queryParam rota_id int Filter by rota. Example: 1
     * @queryParam status string Filter by status (pending,running,completed,cancelled). Example: pending
     * @queryParam date_from string Filter by start datetime from. Example: 2024-01-01
     * @queryParam date_to string Filter by end datetime to. Example: 2024-12-31
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam sort_by string Field to sort by. Example: start_datetime
     * @queryParam sort_order string Sort direction. Example: asc
     */
    public function index(): JsonResponse
    {
        $schedules = $this->scheduleService->paginate(
            request()->only(['search', 'employee_id', 'branch_id', 'rota_id', 'status', 'date_from', 'date_to']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new ScheduleCollection($schedules)
        );
    }

    /**
     * Store a newly created schedule.
     *
     * @bodyParam rota_id int optional Rota ID. Example: 1
     * @bodyParam employee_id int required Employee ID. Example: 1
     * @bodyParam client_id int optional Client ID. Example: 1
     * @bodyParam branch_id int required Branch ID. Example: 1
     * @bodyParam start_datetime datetime required Start datetime. Example: 2024-01-01T09:00:00
     * @bodyParam end_datetime datetime required End datetime. Example: 2024-01-01T17:00:00
     * @bodyParam planned_hours numeric required Planned hours. Example: 8.00
     * @bodyParam status string optional Status. Example: pending
     */
    public function store(StoreScheduleRequest $request): JsonResponse
    {
        $schedule = $this->scheduleService->create($request->validated());

        return $this->createdResponse(
            new ScheduleResource($schedule),
            'Schedule created successfully.'
        );
    }

    /**
     * Show the specified schedule.
     *
     * @urlParam uuid string required The UUID of the schedule. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $schedule = $this->scheduleService->findByUuid($uuid);

        if (! $schedule) {
            return $this->notFoundResponse('Schedule not found.');
        }

        return $this->successResponse(
            new ScheduleResource($schedule)
        );
    }

    /**
     * Update the specified schedule.
     *
     * @urlParam uuid string required The UUID of the schedule. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function update(UpdateScheduleRequest $request, string $uuid): JsonResponse
    {
        $schedule = $this->scheduleService->findByUuid($uuid);

        if (! $schedule) {
            return $this->notFoundResponse('Schedule not found.');
        }

        $schedule = $this->scheduleService->update($schedule, $request->validated());

        return $this->successResponse(
            new ScheduleResource($schedule),
            'Schedule updated successfully.'
        );
    }

    /**
     * Soft delete the specified schedule.
     *
     * @urlParam uuid string required The UUID of the schedule. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $schedule = $this->scheduleService->findByUuid($uuid);

        if (! $schedule) {
            return $this->notFoundResponse('Schedule not found.');
        }

        $this->scheduleService->delete($schedule);

        return $this->deletedResponse('Schedule deleted successfully.');
    }

    /**
     * Restore a soft deleted schedule.
     *
     * @urlParam uuid string required The UUID of the schedule. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $schedule = $this->scheduleService->restore($uuid);

        if (! $schedule) {
            return $this->notFoundResponse('Schedule not found or not deleted.');
        }

        return $this->successResponse(
            new ScheduleResource($schedule),
            'Schedule restored successfully.'
        );
    }

    /**
     * List soft deleted schedules.
     */
    public function trash(): JsonResponse
    {
        $schedules = $this->scheduleService->paginateTrashed(
            request()->only(['search', 'employee_id', 'branch_id']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new ScheduleCollection($schedules)
        );
    }

    /**
     * Bulk delete schedules.
     *
     * @bodyParam uuids array required Array of UUIDs to delete. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->scheduleService->bulkDelete($uuids);

        return $this->deletedResponse('Schedules deleted successfully.');
    }

    /**
     * Bulk restore schedules.
     *
     * @bodyParam uuids array required Array of UUIDs to restore. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->scheduleService->bulkRestore($uuids);

        return $this->successResponse(null, 'Schedules restored successfully.');
    }

    /**
     * Permanently delete the specified schedule.
     *
     * @urlParam uuid string required The UUID of the schedule. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->scheduleService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Schedule not found.');
        }

        return $this->deletedResponse('Schedule force deleted successfully.');
    }

    /**
     * Approve the specified schedule.
     *
     * @urlParam uuid string required The UUID of the schedule. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function approve(string $uuid): JsonResponse
    {
        $schedule = $this->scheduleService->findByUuid($uuid);

        if (! $schedule) {
            return $this->notFoundResponse('Schedule not found.');
        }

        $schedule = $this->scheduleService->approve($schedule, Auth::user());

        return $this->successResponse(
            new ScheduleResource($schedule),
            'Schedule approved successfully.'
        );
    }

    /**
     * Cancel the specified schedule.
     *
     * @urlParam uuid string required The UUID of the schedule. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function cancel(string $uuid): JsonResponse
    {
        $schedule = $this->scheduleService->findByUuid($uuid);

        if (! $schedule) {
            return $this->notFoundResponse('Schedule not found.');
        }

        $schedule = $this->scheduleService->cancel($schedule, Auth::user());

        return $this->successResponse(
            new ScheduleResource($schedule),
            'Schedule cancelled successfully.'
        );
    }

    /**
     * Complete the specified schedule.
     *
     * @urlParam uuid string required The UUID of the schedule. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function complete(string $uuid): JsonResponse
    {
        $schedule = $this->scheduleService->findByUuid($uuid);

        if (! $schedule) {
            return $this->notFoundResponse('Schedule not found.');
        }

        $schedule = $this->scheduleService->complete($schedule, Auth::user());

        return $this->successResponse(
            new ScheduleResource($schedule),
            'Schedule completed successfully.'
        );
    }
}

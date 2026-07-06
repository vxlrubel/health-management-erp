<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Activity\StoreActivityRequest;
use App\Http\Requests\Activity\UpdateActivityRequest;
use App\Http\Resources\ActivityCollection;
use App\Http\Resources\ActivityResource;
use App\Services\ActivityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ActivitiesController extends Controller
{
    public function __construct(
        private readonly ActivityService $activityService
    ) {}

    /**
     * List all activities.
     *
     * @queryParam search string Search by activity type or notes. Example: Consultation
     * @queryParam employee_id int Filter by employee. Example: 1
     * @queryParam branch_id int Filter by branch. Example: 1
     * @queryParam schedule_id int Filter by schedule. Example: 1
     * @queryParam status string Filter by status. Example: pending
     * @queryParam activity_type string Filter by activity type. Example: visit
     * @queryParam date_from string Filter by start datetime from. Example: 2024-01-01
     * @queryParam date_to string Filter by end datetime to. Example: 2024-12-31
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam sort_by string Field to sort by. Example: start_datetime
     * @queryParam sort_order string Sort direction. Example: desc
     */
    public function index(): JsonResponse
    {
        $activities = $this->activityService->paginate(
            request()->only(['search', 'employee_id', 'branch_id', 'schedule_id', 'status', 'activity_type', 'date_from', 'date_to']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new ActivityCollection($activities)
        );
    }

    /**
     * Store a newly created activity.
     *
     * @bodyParam schedule_id int optional Schedule ID. Example: 1
     * @bodyParam employee_id int required Employee ID. Example: 1
     * @bodyParam client_id int optional Client ID. Example: 1
     * @bodyParam branch_id int required Branch ID. Example: 1
     * @bodyParam activity_type string required Activity type. Example: visit
     * @bodyParam notes string optional Notes. Example: Home care visit
     * @bodyParam start_datetime datetime required Start datetime. Example: 2024-01-01T09:00:00
     * @bodyParam end_datetime datetime required End datetime. Example: 2024-01-01T10:00:00
     * @bodyParam actual_hours numeric optional Actual hours. Example: 1.00
     * @bodyParam status string optional Status. Example: pending
     */
    public function store(StoreActivityRequest $request): JsonResponse
    {
        $activity = $this->activityService->create($request->validated());

        return $this->createdResponse(
            new ActivityResource($activity),
            'Activity created successfully.'
        );
    }

    /**
     * Show the specified activity.
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $activity = $this->activityService->findByUuid($uuid);

        if (! $activity) {
            return $this->notFoundResponse('Activity not found.');
        }

        return $this->successResponse(
            new ActivityResource($activity)
        );
    }

    /**
     * Update the specified activity.
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function update(UpdateActivityRequest $request, string $uuid): JsonResponse
    {
        $activity = $this->activityService->findByUuid($uuid);

        if (! $activity) {
            return $this->notFoundResponse('Activity not found.');
        }

        $activity = $this->activityService->update($activity, $request->validated());

        return $this->successResponse(
            new ActivityResource($activity),
            'Activity updated successfully.'
        );
    }

    /**
     * Soft delete the specified activity.
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $activity = $this->activityService->findByUuid($uuid);

        if (! $activity) {
            return $this->notFoundResponse('Activity not found.');
        }

        $this->activityService->delete($activity);

        return $this->deletedResponse('Activity deleted successfully.');
    }

    /**
     * Restore a soft deleted activity.
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $activity = $this->activityService->restore($uuid);

        if (! $activity) {
            return $this->notFoundResponse('Activity not found or not deleted.');
        }

        return $this->successResponse(
            new ActivityResource($activity),
            'Activity restored successfully.'
        );
    }

    /**
     * List soft deleted activities.
     */
    public function trash(): JsonResponse
    {
        $activities = $this->activityService->paginateTrashed(
            request()->only(['search', 'employee_id', 'branch_id', 'schedule_id']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new ActivityCollection($activities)
        );
    }

    /**
     * Bulk delete activities.
     *
     * @bodyParam uuids array required Array of UUIDs to delete. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->activityService->bulkDelete($uuids);

        return $this->deletedResponse('Activities deleted successfully.');
    }

    /**
     * Bulk restore activities.
     *
     * @bodyParam uuids array required Array of UUIDs to restore. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(): JsonResponse
    {
        $uuids = request()->input('uuids', []);

        if (empty($uuids)) {
            return $this->errorResponse('No UUIDs provided.', 422);
        }

        $this->activityService->bulkRestore($uuids);

        return $this->successResponse(null, 'Activities restored successfully.');
    }

    /**
     * Permanently delete the specified activity.
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->activityService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Activity not found.');
        }

        return $this->deletedResponse('Activity force deleted successfully.');
    }

    /**
     * Approve the specified activity.
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function approve(string $uuid): JsonResponse
    {
        $activity = $this->activityService->findByUuid($uuid);

        if (! $activity) {
            return $this->notFoundResponse('Activity not found.');
        }

        $activity = $this->activityService->approve($activity, Auth::user());

        return $this->successResponse(
            new ActivityResource($activity),
            'Activity approved successfully.'
        );
    }

    /**
     * Cancel the specified activity.
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function cancel(string $uuid): JsonResponse
    {
        $activity = $this->activityService->findByUuid($uuid);

        if (! $activity) {
            return $this->notFoundResponse('Activity not found.');
        }

        $activity = $this->activityService->cancel($activity, Auth::user());

        return $this->successResponse(
            new ActivityResource($activity),
            'Activity cancelled successfully.'
        );
    }

    /**
     * Complete the specified activity.
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function complete(string $uuid): JsonResponse
    {
        $activity = $this->activityService->findByUuid($uuid);

        if (! $activity) {
            return $this->notFoundResponse('Activity not found.');
        }

        $activity = $this->activityService->complete($activity, Auth::user());

        return $this->successResponse(
            new ActivityResource($activity),
            'Activity completed successfully.'
        );
    }

    /**
     * Start the specified activity (sets status to in_progress).
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function start(string $uuid): JsonResponse
    {
        $activity = $this->activityService->findByUuid($uuid);

        if (! $activity) {
            return $this->notFoundResponse('Activity not found.');
        }

        $activity = $this->activityService->start($activity, Auth::user());

        return $this->successResponse(
            new ActivityResource($activity),
            'Activity started successfully.'
        );
    }

    /**
     * Stop the specified activity (completes it and calculates actual hours).
     *
     * @urlParam uuid string required The UUID of the activity. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function stop(string $uuid): JsonResponse
    {
        $activity = $this->activityService->findByUuid($uuid);

        if (! $activity) {
            return $this->notFoundResponse('Activity not found.');
        }

        $activity = $this->activityService->stop($activity, Auth::user());

        return $this->successResponse(
            new ActivityResource($activity),
            'Activity stopped successfully.'
        );
    }
}

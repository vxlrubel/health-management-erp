<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreTimesheetRequest;
use App\Http\Requests\Finance\UpdateTimesheetRequest;
use App\Http\Resources\Finance\TimesheetCollection;
use App\Http\Resources\Finance\TimesheetResource;
use App\Services\Finance\TimesheetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    public function __construct(
        protected TimesheetService $service,
    ) {}

    /**
     * List timesheets
     *
     * @queryParam search string Search term. Example: "John"
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam page int Page number. Example: 1
     */
    public function index(Request $request): TimesheetCollection
    {
        $timesheets = $this->service->paginate($request->all(), $request->all());

        return new TimesheetCollection($timesheets);
    }

    /**
     * Show timesheet
     *
     * @urlParam uuid string required Timesheet UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $timesheet = $this->service->findByUuid($uuid);

        if (! $timesheet) {
            return $this->notFoundResponse('Timesheet not found.');
        }

        return $this->successResponse(new TimesheetResource($timesheet));
    }

    /**
     * Create timesheet
     *
     * @bodyParam employee_id int required Employee ID. Example: 1
     * @bodyParam branch_id int required Branch ID. Example: 1
     * @bodyParam period_start date required Period start. Example: 2024-01-01
     * @bodyParam period_end date required Period end. Example: 2024-01-31
     * @bodyParam regular_hours numeric Regular hours. Example: 160
     * @bodyParam overtime_hours numeric Overtime hours. Example: 10
     * @bodyParam holiday_hours numeric Holiday hours. Example: 8
     */
    public function store(StoreTimesheetRequest $request): JsonResponse
    {
        $timesheet = $this->service->create($request->validated());

        return $this->createdResponse(new TimesheetResource($timesheet), 'Timesheet created successfully.');
    }

    /**
     * Update timesheet
     *
     * @urlParam uuid string required Timesheet UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @bodyParam regular_hours numeric Regular hours. Example: 160
     * @bodyParam overtime_hours numeric Overtime hours. Example: 10
     */
    public function update(UpdateTimesheetRequest $request, string $uuid): JsonResponse
    {
        $timesheet = $this->service->findByUuid($uuid);

        if (! $timesheet) {
            return $this->notFoundResponse('Timesheet not found.');
        }

        $timesheet = $this->service->update($timesheet, $request->validated());

        return $this->successResponse(new TimesheetResource($timesheet), 'Timesheet updated successfully.');
    }

    /**
     * Delete timesheet (soft)
     *
     * @urlParam uuid string required Timesheet UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $timesheet = $this->service->findByUuid($uuid);

        if (! $timesheet) {
            return $this->notFoundResponse('Timesheet not found.');
        }

        $this->service->softDelete($timesheet);

        return $this->deletedResponse('Timesheet deleted successfully.');
    }

    /**
     * List trashed timesheets
     *
     * @queryParam per_page int Items per page. Example: 15
     */
    public function trash(Request $request): TimesheetCollection
    {
        $timesheets = $this->service->paginate(
            array_merge($request->all(), ['trashed' => true]),
            $request->all()
        );

        return new TimesheetCollection($timesheets);
    }

    /**
     * Restore timesheet
     *
     * @urlParam uuid string required Timesheet UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $timesheet = $this->service->restore($uuid);

        if (! $timesheet) {
            return $this->notFoundResponse('Timesheet not found in trash.');
        }

        return $this->successResponse(new TimesheetResource($timesheet), 'Timesheet restored successfully.');
    }

    /**
     * Force delete timesheet
     *
     * @urlParam uuid string required Timesheet UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->service->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Timesheet not found.');
        }

        return $this->deletedResponse('Timesheet permanently deleted.');
    }

    /**
     * Bulk delete timesheets
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Timesheets deleted successfully.');
    }

    /**
     * Bulk restore timesheets
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Timesheets restored successfully.');
    }
}

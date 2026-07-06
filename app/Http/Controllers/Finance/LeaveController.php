<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreLeaveRequest;
use App\Http\Requests\Finance\UpdateLeaveRequest;
use App\Http\Resources\Finance\LeaveCollection;
use App\Http\Resources\Finance\LeaveResource;
use App\Services\Finance\LeaveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function __construct(
        protected LeaveService $service,
    ) {}

    /**
     * List leaves
     *
     * @queryParam search string Search term. Example: "John"
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam page int Page number. Example: 1
     * @queryParam status string Filter by status. Example: pending
     */
    public function index(Request $request): LeaveCollection
    {
        $leaves = $this->service->paginate($request->all(), $request->all());

        return new LeaveCollection($leaves);
    }

    /**
     * Show leave
     *
     * @urlParam uuid string required Leave UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $leave = $this->service->findByUuid($uuid);

        if (! $leave) {
            return $this->notFoundResponse('Leave not found.');
        }

        return $this->successResponse(new LeaveResource($leave));
    }

    /**
     * Create leave
     *
     * @bodyParam employee_id int required Employee ID. Example: 1
     * @bodyParam leave_type string required Leave type. Enum: annual,sick,personal,maternity,paternity,bereavement,other
     * @bodyParam reason string Reason for leave. Example: "Family vacation"
     * @bodyParam start_date date required Start date. Example: 2024-01-15
     * @bodyParam end_date date required End date. Example: 2024-01-20
     */
    public function store(StoreLeaveRequest $request): JsonResponse
    {
        $leave = $this->service->create($request->validated());

        return $this->createdResponse(new LeaveResource($leave), 'Leave created successfully.');
    }

    /**
     * Update leave
     *
     * @urlParam uuid string required Leave UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @bodyParam reason string Reason for leave. Example: "Updated reason"
     */
    public function update(UpdateLeaveRequest $request, string $uuid): JsonResponse
    {
        $leave = $this->service->findByUuid($uuid);

        if (! $leave) {
            return $this->notFoundResponse('Leave not found.');
        }

        $leave = $this->service->update($leave, $request->validated());

        return $this->successResponse(new LeaveResource($leave), 'Leave updated successfully.');
    }

    /**
     * Delete leave (soft)
     *
     * @urlParam uuid string required Leave UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $leave = $this->service->findByUuid($uuid);

        if (! $leave) {
            return $this->notFoundResponse('Leave not found.');
        }

        $this->service->softDelete($leave);

        return $this->deletedResponse('Leave deleted successfully.');
    }

    /**
     * Approve leave
     *
     * @urlParam uuid string required Leave UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function approve(string $uuid): JsonResponse
    {
        $leave = $this->service->approve($uuid);

        if (! $leave) {
            return $this->notFoundResponse('Leave not found.');
        }

        return $this->successResponse(new LeaveResource($leave), 'Leave approved successfully.');
    }

    /**
     * Reject leave
     *
     * @urlParam uuid string required Leave UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function reject(string $uuid): JsonResponse
    {
        $leave = $this->service->reject($uuid);

        if (! $leave) {
            return $this->notFoundResponse('Leave not found.');
        }

        return $this->successResponse(new LeaveResource($leave), 'Leave rejected successfully.');
    }
}

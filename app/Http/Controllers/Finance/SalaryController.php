<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Finance\StoreSalaryRecordRequest;
use App\Http\Requests\Finance\UpdateSalaryRecordRequest;
use App\Http\Resources\Finance\SalaryRecordCollection;
use App\Http\Resources\Finance\SalaryRecordResource;
use App\Services\Finance\SalaryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function __construct(
        protected SalaryService $service,
    ) {}

    /**
     * List salary records
     *
     * @queryParam search string Search term. Example: "John"
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam page int Page number. Example: 1
     * @queryParam month string Filter by month (YYYY-MM). Example: 2024-01
     * @queryParam branch_id int Filter by branch. Example: 1
     */
    public function index(Request $request): SalaryRecordCollection
    {
        $records = $this->service->paginate($request->all(), $request->all());

        return new SalaryRecordCollection($records);
    }

    /**
     * Show salary record
     *
     * @urlParam uuid string required Salary record UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $record = $this->service->findByUuid($uuid);

        if (! $record) {
            return $this->notFoundResponse('Salary record not found.');
        }

        return $this->successResponse(new SalaryRecordResource($record));
    }

    /**
     * Create salary record
     *
     * @bodyParam employee_id int required Employee ID. Example: 1
     * @bodyParam branch_id int required Branch ID. Example: 1
     * @bodyParam month string required Month (YYYY-MM). Example: 2024-01
     * @bodyParam working_hours numeric Working hours. Example: 160
     * @bodyParam hourly_rate numeric Hourly rate. Example: 25.00
     * @bodyParam overtime numeric Overtime pay. Example: 200.00
     * @bodyParam bonus numeric Bonus. Example: 100.00
     * @bodyParam deduction numeric Deduction. Example: 50.00
     * @bodyParam net_salary numeric required Net salary. Example: 4000.00
     */
    public function store(StoreSalaryRecordRequest $request): JsonResponse
    {
        $record = $this->service->create($request->validated());

        return $this->createdResponse(new SalaryRecordResource($record), 'Salary record created successfully.');
    }

    /**
     * Update salary record
     *
     * @urlParam uuid string required Salary record UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     *
     * @bodyParam net_salary numeric Net salary. Example: 4200.00
     */
    public function update(UpdateSalaryRecordRequest $request, string $uuid): JsonResponse
    {
        $record = $this->service->findByUuid($uuid);

        if (! $record) {
            return $this->notFoundResponse('Salary record not found.');
        }

        $record = $this->service->update($record, $request->validated());

        return $this->successResponse(new SalaryRecordResource($record), 'Salary record updated successfully.');
    }

    /**
     * Delete salary record (soft)
     *
     * @urlParam uuid string required Salary record UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $record = $this->service->findByUuid($uuid);

        if (! $record) {
            return $this->notFoundResponse('Salary record not found.');
        }

        $this->service->softDelete($record);

        return $this->deletedResponse('Salary record deleted successfully.');
    }

    /**
     * Generate salary records for a branch
     *
     * @bodyParam branch_id int required Branch ID. Example: 1
     * @bodyParam month string required Month (YYYY-MM). Example: 2024-01
     */
    public function generate(Request $request): JsonResponse
    {
        $request->validate([
            'branch_id' => ['required', 'exists:branches,id'],
            'month' => ['required', 'string', 'regex:/^\d{4}-\d{2}$/'],
        ]);

        $records = $this->service->generate($request->input('branch_id'), $request->input('month'));

        return $this->createdResponse(
            SalaryRecordResource::collection(collect($records)),
            'Salary records generated successfully.'
        );
    }

    /**
     * List trashed salary records
     *
     * @queryParam per_page int Items per page. Example: 15
     */
    public function trash(Request $request): SalaryRecordCollection
    {
        $records = $this->service->paginate(
            array_merge($request->all(), ['trashed' => true]),
            $request->all()
        );

        return new SalaryRecordCollection($records);
    }

    /**
     * Restore salary record
     *
     * @urlParam uuid string required Salary record UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function restore(string $uuid): JsonResponse
    {
        $record = $this->service->restore($uuid);

        if (! $record) {
            return $this->notFoundResponse('Salary record not found in trash.');
        }

        return $this->successResponse(new SalaryRecordResource($record), 'Salary record restored successfully.');
    }

    /**
     * Force delete salary record
     *
     * @urlParam uuid string required Salary record UUID. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->service->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Salary record not found.');
        }

        return $this->deletedResponse('Salary record permanently deleted.');
    }

    /**
     * Bulk delete salary records
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Salary records deleted successfully.');
    }

    /**
     * Bulk restore salary records
     *
     * @bodyParam uuids array required Array of UUIDs. Example: ["550e8400-e29b-41d4-a716-446655440000"]
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'uuid']]);

        $this->service->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Salary records restored successfully.');
    }

    /**
     * Export salary records
     *
     * @queryParam month string Filter by month (YYYY-MM). Example: 2024-01
     * @queryParam branch_id int Filter by branch. Example: 1
     */
    public function export(Request $request): JsonResponse
    {
        $records = $this->service->paginate($request->all(), array_merge($request->all(), ['per_page' => 1000]));

        return $this->successResponse(new SalaryRecordCollection($records), 'Salary records exported successfully.');
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Employee\StoreEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Client;
use App\Models\Employee;
use App\Services\EmployeeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    /**
     * Display a paginated listing of employees.
     */
    public function index(Request $request): JsonResponse
    {
        $employees = $this->employeeService->paginate(
            $request->only(['search', 'status', 'branch_id', 'employment_type']),
            $request->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(new EmployeeCollection($employees));
    }

    /**
     * Display the specified employee.
     */
    public function show(string $uuid): JsonResponse
    {
        $employee = $this->employeeService->findByUuid($uuid);

        if (! $employee) {
            return $this->notFoundResponse('Employee not found.');
        }

        return $this->successResponse(new EmployeeResource($employee));
    }

    /**
     * Store a newly created employee.
     */
    public function store(StoreEmployeeRequest $request): JsonResponse
    {
        $employee = $this->employeeService->create($request->validated());

        return $this->createdResponse(new EmployeeResource($employee), 'Employee created successfully.');
    }

    /**
     * Update the specified employee.
     */
    public function update(UpdateEmployeeRequest $request, Employee $employee): JsonResponse
    {
        $employee = $this->employeeService->update($employee, $request->validated());

        return $this->successResponse(new EmployeeResource($employee), 'Employee updated successfully.');
    }

    /**
     * Remove the specified employee (soft delete).
     */
    public function destroy(Employee $employee): JsonResponse
    {
        $this->employeeService->delete($employee);

        return $this->deletedResponse('Employee deleted successfully.');
    }

    /**
     * Display a paginated listing of trashed employees.
     */
    public function trash(Request $request): JsonResponse
    {
        $perPage = $request->input('per_page', 15);
        $employees = Employee::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate($perPage);

        return $this->paginatedResponse(new EmployeeCollection($employees));
    }

    /**
     * Restore a trashed employee.
     */
    public function restore(string $uuid): JsonResponse
    {
        $employee = $this->employeeService->restore($uuid);

        if (! $employee) {
            return $this->notFoundResponse('Employee not found or not trashed.');
        }

        return $this->successResponse(new EmployeeResource($employee), 'Employee restored successfully.');
    }

    /**
     * Permanently delete a trashed employee.
     */
    public function forceDelete(string $uuid): JsonResponse
    {
        $deleted = $this->employeeService->forceDelete($uuid);

        if (! $deleted) {
            return $this->notFoundResponse('Employee not found.');
        }

        return $this->deletedResponse('Employee permanently deleted.');
    }

    /**
     * Bulk delete employees.
     */
    public function bulkDelete(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string', 'exists:employees,uuid']]);

        $this->employeeService->bulkDelete($request->input('uuids'));

        return $this->deletedResponse('Employees deleted successfully.');
    }

    /**
     * Bulk restore employees.
     */
    public function bulkRestore(Request $request): JsonResponse
    {
        $request->validate(['uuids' => ['required', 'array'], 'uuids.*' => ['string']]);

        $this->employeeService->bulkRestore($request->input('uuids'));

        return $this->successResponse(null, 'Employees restored successfully.');
    }

    /**
     * Export employees list.
     */
    public function export(Request $request): JsonResponse
    {
        return $this->successResponse(null, 'Export functionality not implemented yet.');
    }

    /**
     * Assign a client to an employee.
     */
    public function assignClient(Employee $employee, Client $client, Request $request): JsonResponse
    {
        $request->validate([
            'assigned_from' => ['nullable', 'date'],
            'assigned_to' => ['nullable', 'date', 'after_or_equal:assigned_from'],
            'is_primary' => ['boolean'],
        ]);

        $this->employeeService->assignClient($employee, $client, $request->only(['assigned_from', 'assigned_to', 'is_primary']));

        return $this->successResponse(null, 'Client assigned to employee successfully.');
    }

    /**
     * Remove a client from an employee.
     */
    public function removeClient(Employee $employee, Client $client): JsonResponse
    {
        $this->employeeService->removeClient($employee, $client);

        return $this->successResponse(null, 'Client removed from employee successfully.');
    }

    /**
     * Get activities for an employee.
     */
    public function activities(Employee $employee): JsonResponse
    {
        return $this->successResponse($employee->activities()->with(['client'])->get());
    }

    /**
     * Get schedules for an employee.
     */
    public function schedules(Employee $employee): JsonResponse
    {
        return $this->successResponse($employee->schedules()->get());
    }

    /**
     * Get salary records for an employee.
     */
    public function salary(Employee $employee): JsonResponse
    {
        $salaryRecords = $employee->salaryRecords()->orderBy('created_at', 'desc')->get();

        return $this->successResponse($salaryRecords);
    }
}

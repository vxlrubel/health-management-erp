<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EmployeeService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Employee::query()->with(['branch', 'user', 'clients']);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('employee_no', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (! empty($filters['employment_type'])) {
            $query->where('employment_type', $filters['employment_type']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Employee
    {
        return Employee::with(['branch', 'user', 'clients', 'employeeDocuments'])->where('uuid', $uuid)->first();
    }

    public function create(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            return Employee::create($data);
        });
    }

    public function update(Employee $employee, array $data): Employee
    {
        return DB::transaction(function () use ($employee, $data) {
            $employee->update($data);

            return $employee->fresh();
        });
    }

    public function delete(Employee $employee): bool
    {
        return DB::transaction(function () use ($employee) {
            return $employee->delete();
        });
    }

    public function restore(string $uuid): ?Employee
    {
        return DB::transaction(function () use ($uuid) {
            $employee = Employee::withTrashed()->where('uuid', $uuid)->first();
            if ($employee && $employee->trashed()) {
                $employee->restore();

                return $employee;
            }

            return null;
        });
    }

    public function forceDelete(string $uuid): bool
    {
        return DB::transaction(function () use ($uuid) {
            $employee = Employee::withTrashed()->where('uuid', $uuid)->first();
            if ($employee) {
                return $employee->forceDelete();
            }

            return false;
        });
    }

    public function bulkDelete(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            Employee::whereIn('uuid', $uuids)->delete();

            return true;
        });
    }

    public function bulkRestore(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            Employee::withTrashed()->whereIn('uuid', $uuids)->restore();

            return true;
        });
    }

    public function assignClient(Employee $employee, Client $client, array $data = []): void
    {
        DB::transaction(function () use ($employee, $client, $data) {
            $employee->clients()->syncWithoutDetaching([
                $client->id => [
                    'assigned_from' => $data['assigned_from'] ?? now(),
                    'assigned_to' => $data['assigned_to'] ?? null,
                    'is_primary' => $data['is_primary'] ?? false,
                ],
            ]);
        });
    }

    public function removeClient(Employee $employee, Client $client): void
    {
        DB::transaction(function () use ($employee, $client) {
            $employee->clients()->detach($client->id);
        });
    }
}

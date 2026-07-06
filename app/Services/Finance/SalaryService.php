<?php

namespace App\Services\Finance;

use App\Models\Employee;
use App\Models\SalaryRecord;
use App\Repositories\Contracts\SalaryRecordRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class SalaryService
{
    public function __construct(
        protected SalaryRecordRepositoryInterface $repository,
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $options);
    }

    public function findByUuid(string $uuid): ?SalaryRecord
    {
        return $this->repository->findByUuid($uuid);
    }

    public function create(array $data): SalaryRecord
    {
        return $this->repository->create($data);
    }

    public function update(SalaryRecord $record, array $data): SalaryRecord
    {
        return $this->repository->update($record, $data);
    }

    public function softDelete(SalaryRecord $record): bool
    {
        return $this->repository->softDelete($record);
    }

    public function restore(string $uuid): ?SalaryRecord
    {
        return $this->repository->restore($uuid);
    }

    public function forceDelete(string $uuid): bool
    {
        return $this->repository->forceDelete($uuid);
    }

    public function bulkDelete(array $uuids): bool
    {
        return $this->repository->bulkDelete($uuids);
    }

    public function bulkRestore(array $uuids): bool
    {
        return $this->repository->bulkRestore($uuids);
    }

    public function generate(int $branchId, string $month): array
    {
        $created = [];

        $employees = Employee::where('branch_id', $branchId)->get();

        foreach ($employees as $employee) {
            $existing = SalaryRecord::where('employee_id', $employee->id)
                ->where('month', $month)
                ->first();

            if ($existing) {
                continue;
            }

            $record = $this->repository->create([
                'employee_id' => $employee->id,
                'branch_id' => $branchId,
                'month' => $month,
                'working_hours' => 0,
                'hourly_rate' => 0,
                'overtime' => 0,
                'bonus' => 0,
                'deduction' => 0,
                'net_salary' => 0,
                'status' => 'generated',
            ]);

            $created[] = $record;
        }

        return $created;
    }
}

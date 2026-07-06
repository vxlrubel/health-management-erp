<?php

namespace App\Services\Finance;

use App\Models\Timesheet;
use App\Repositories\Contracts\TimesheetRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class TimesheetService
{
    public function __construct(
        protected TimesheetRepositoryInterface $repository,
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $options);
    }

    public function findByUuid(string $uuid): ?Timesheet
    {
        return $this->repository->findByUuid($uuid);
    }

    public function create(array $data): Timesheet
    {
        return $this->repository->create($data);
    }

    public function update(Timesheet $timesheet, array $data): Timesheet
    {
        return $this->repository->update($timesheet, $data);
    }

    public function softDelete(Timesheet $timesheet): bool
    {
        return $this->repository->softDelete($timesheet);
    }

    public function restore(string $uuid): ?Timesheet
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
}

<?php

namespace App\Services\Finance;

use App\Enums\LeaveStatus;
use App\Models\Leave;
use App\Repositories\Contracts\LeaveRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class LeaveService
{
    public function __construct(
        protected LeaveRepositoryInterface $repository,
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $options);
    }

    public function findByUuid(string $uuid): ?Leave
    {
        return $this->repository->findByUuid($uuid);
    }

    public function create(array $data): Leave
    {
        return $this->repository->create($data);
    }

    public function update(Leave $leave, array $data): Leave
    {
        return $this->repository->update($leave, $data);
    }

    public function softDelete(Leave $leave): bool
    {
        return $this->repository->softDelete($leave);
    }

    public function restore(string $uuid): ?Leave
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

    public function approve(string $uuid): ?Leave
    {
        $leave = $this->repository->findByUuid($uuid);
        if (! $leave) {
            return null;
        }

        return $this->repository->update($leave, [
            'status' => LeaveStatus::Approved,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
    }

    public function reject(string $uuid): ?Leave
    {
        $leave = $this->repository->findByUuid($uuid);
        if (! $leave) {
            return null;
        }

        return $this->repository->update($leave, [
            'status' => LeaveStatus::Rejected,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
    }
}

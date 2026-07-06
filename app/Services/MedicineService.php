<?php

namespace App\Services;

use App\Models\Medicine;
use App\Repositories\Eloquent\MedicineRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MedicineService
{
    public function __construct(
        protected MedicineRepository $repository
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $options);
    }

    public function findById(int $id): ?Medicine
    {
        return $this->repository->findById($id);
    }

    public function findByUuid(string $uuid): ?Medicine
    {
        return $this->repository->findByUuid($uuid);
    }

    public function create(array $data): Medicine
    {
        return $this->repository->create($data);
    }

    public function update(Medicine $medicine, array $data): Medicine
    {
        return $this->repository->update($medicine, $data);
    }

    public function delete(Medicine $medicine): bool
    {
        return $this->repository->softDelete($medicine);
    }

    public function restore(string $uuid): ?Medicine
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

    public function export(): Collection
    {
        return $this->repository->query()->get();
    }
}

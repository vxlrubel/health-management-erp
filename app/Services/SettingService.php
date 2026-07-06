<?php

namespace App\Services;

use App\Models\Setting;
use App\Repositories\Eloquent\SettingRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SettingService
{
    public function __construct(
        protected SettingRepository $repository
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $options);
    }

    public function findById(int $id): ?Setting
    {
        return $this->repository->findById($id);
    }

    public function findByKey(string $key): ?Setting
    {
        return $this->repository->findByKey($key);
    }

    public function create(array $data): Setting
    {
        return $this->repository->create($data);
    }

    public function update(Setting $setting, array $data): Setting
    {
        return $this->repository->update($setting, $data);
    }

    public function delete(Setting $setting): bool
    {
        return $setting->delete();
    }

    public function getByGroup(string $group): Collection
    {
        return $this->repository->getByGroup($group);
    }

    public function getPublic(): Collection
    {
        return $this->repository->getPublic();
    }

    public function export(): Collection
    {
        return $this->repository->query()->get();
    }
}

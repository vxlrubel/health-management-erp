<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function query(): Builder;

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator;

    public function findById(int $id): ?Model;

    public function findByUuid(string $uuid): ?Model;

    public function create(array $data): Model;

    public function update(Model $model, array $data): Model;

    public function softDelete(Model $model): bool;

    public function restore(string $uuid): ?Model;

    public function forceDelete(string $uuid): bool;

    public function bulkDelete(array $uuids): bool;

    public function bulkRestore(array $uuids): bool;
}

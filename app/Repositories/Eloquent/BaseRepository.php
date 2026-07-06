<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function query(): Builder
    {
        return $this->model->newQuery();
    }

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = $this->query();

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                foreach ($this->searchableFields() as $field) {
                    $q->orWhere($field, 'like', "%{$search}%");
                }
            });
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?Model
    {
        return $this->query()->find($id);
    }

    public function findByUuid(string $uuid): ?Model
    {
        return $this->query()->where('uuid', $uuid)->first();
    }

    public function create(array $data): Model
    {
        return $this->query()->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);

        return $model->fresh();
    }

    public function softDelete(Model $model): bool
    {
        return $model->delete();
    }

    public function restore(string $uuid): ?Model
    {
        $model = $this->model->newQuery()->withTrashed()->where('uuid', $uuid)->first();

        if ($model && $model->trashed()) {
            $model->restore();

            return $model;
        }

        return null;
    }

    public function forceDelete(string $uuid): bool
    {
        $model = $this->model->newQuery()->withTrashed()->where('uuid', $uuid)->first();

        if ($model) {
            return $model->forceDelete();
        }

        return false;
    }

    public function bulkDelete(array $uuids): bool
    {
        $models = $this->model->newQuery()->whereIn('uuid', $uuids)->get();
        foreach ($models as $model) {
            $model->delete();
        }

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        $models = $this->model->newQuery()->withTrashed()->whereIn('uuid', $uuids)->get();
        foreach ($models as $model) {
            if ($model->trashed()) {
                $model->restore();
            }
        }

        return true;
    }

    protected function searchableFields(): array
    {
        return [];
    }
}

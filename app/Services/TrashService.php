<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class TrashService
{
    /**
     * Register models that support soft deletes for trash operations.
     */
    protected array $registeredModels = [];

    public function registerModel(string $label, string $modelClass, array $searchableColumns = ['id', 'uuid']): void
    {
        $this->registeredModels[$label] = [
            'model' => $modelClass,
            'searchable_columns' => $searchableColumns,
        ];
    }

    public function getRegisteredModels(): array
    {
        return $this->registeredModels;
    }

    public function getAllTrashed(?string $search = null): Collection
    {
        $results = collect();

        foreach ($this->registeredModels as $label => $config) {
            $modelClass = $config['model'];
            $query = $modelClass::onlyTrashed();

            if ($search && ! empty($config['searchable_columns'])) {
                $query->where(function ($q) use ($search, $config) {
                    foreach ($config['searchable_columns'] as $column) {
                        $q->orWhere($column, 'like', "%{$search}%");
                    }
                });
            }

            $query->chunk(100, function ($items) use ($results, $label) {
                foreach ($items as $item) {
                    $results->push([
                        'uuid' => $item->uuid,
                        'label' => $label,
                        'model_class' => get_class($item),
                        'display_name' => (string) $item,
                        'deleted_at' => $item->deleted_at,
                        'deleted_by' => $item->deleted_by ?? null,
                    ]);
                }
            });
        }

        return $results;
    }

    public function restore(string $modelClass, string $uuid): ?Model
    {
        $model = $modelClass::withTrashed()->where('uuid', $uuid)->first();

        if ($model && $model->trashed()) {
            $model->restore();

            return $model;
        }

        return null;
    }

    public function forceDelete(string $modelClass, string $uuid): bool
    {
        $model = $modelClass::withTrashed()->where('uuid', $uuid)->first();

        if ($model) {
            return $model->forceDelete();
        }

        return false;
    }

    public function bulkRestore(string $modelClass, array $uuids): bool
    {
        $models = $modelClass::withTrashed()->whereIn('uuid', $uuids)->get();

        foreach ($models as $model) {
            if ($model->trashed()) {
                $model->restore();
            }
        }

        return true;
    }

    public function bulkForceDelete(string $modelClass, array $uuids): bool
    {
        $models = $modelClass::withTrashed()->whereIn('uuid', $uuids)->get();

        foreach ($models as $model) {
            $model->forceDelete();
        }

        return true;
    }
}

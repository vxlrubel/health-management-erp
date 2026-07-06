<?php

namespace App\Services;

use App\Models\SystemConfiguration;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class SystemConfigurationService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = SystemConfiguration::query();

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function (Builder $q) use ($search) {
                $q->where('key', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('group', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['group'])) {
            $query->where('group', $filters['group']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?SystemConfiguration
    {
        return SystemConfiguration::find($id);
    }

    public function findByUuid(string $uuid): ?SystemConfiguration
    {
        return SystemConfiguration::where('uuid', $uuid)->first();
    }

    public function create(array $data): SystemConfiguration
    {
        return SystemConfiguration::create($data);
    }

    public function update(SystemConfiguration $config, array $data): SystemConfiguration
    {
        $config->update($data);

        return $config->fresh();
    }

    public function delete(SystemConfiguration $config): bool
    {
        return $config->delete();
    }

    public function getByKey(string $key): mixed
    {
        $config = SystemConfiguration::where('key', $key)->first();

        return $config?->value;
    }

    public function getByGroup(string $group): Collection
    {
        return SystemConfiguration::where('group', $group)->get();
    }

    public function getAllByGroup(string $group): array
    {
        return SystemConfiguration::where('group', $group)
            ->pluck('value', 'key')
            ->toArray();
    }
}

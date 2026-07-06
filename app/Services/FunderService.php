<?php

namespace App\Services;

use App\Models\Funder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class FunderService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Funder::query()->with(['clients']);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Funder
    {
        return Funder::with(['clients'])->where('uuid', $uuid)->first();
    }

    public function create(array $data): Funder
    {
        return DB::transaction(function () use ($data) {
            return Funder::create($data);
        });
    }

    public function update(Funder $funder, array $data): Funder
    {
        return DB::transaction(function () use ($funder, $data) {
            $funder->update($data);

            return $funder->fresh();
        });
    }

    public function delete(Funder $funder): bool
    {
        return DB::transaction(function () use ($funder) {
            return $funder->delete();
        });
    }

    public function restore(string $uuid): ?Funder
    {
        return DB::transaction(function () use ($uuid) {
            $funder = Funder::withTrashed()->where('uuid', $uuid)->first();
            if ($funder && $funder->trashed()) {
                $funder->restore();

                return $funder;
            }

            return null;
        });
    }

    public function forceDelete(string $uuid): bool
    {
        return DB::transaction(function () use ($uuid) {
            $funder = Funder::withTrashed()->where('uuid', $uuid)->first();
            if ($funder) {
                return $funder->forceDelete();
            }

            return false;
        });
    }

    public function bulkDelete(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            Funder::whereIn('uuid', $uuids)->delete();

            return true;
        });
    }

    public function bulkRestore(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            Funder::withTrashed()->whereIn('uuid', $uuids)->restore();

            return true;
        });
    }
}

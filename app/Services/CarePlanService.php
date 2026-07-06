<?php

namespace App\Services;

use App\Models\CarePlan;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CarePlanService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = CarePlan::query()->with(['client']);

        if (! empty($filters['client_id'])) {
            $query->where('client_id', $filters['client_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?CarePlan
    {
        return CarePlan::with(['client'])->where('uuid', $uuid)->first();
    }

    public function create(array $data): CarePlan
    {
        return DB::transaction(function () use ($data) {
            return CarePlan::create($data);
        });
    }

    public function update(CarePlan $carePlan, array $data): CarePlan
    {
        return DB::transaction(function () use ($carePlan, $data) {
            $carePlan->update($data);

            return $carePlan->fresh();
        });
    }

    public function delete(CarePlan $carePlan): bool
    {
        return DB::transaction(function () use ($carePlan) {
            return $carePlan->delete();
        });
    }

    public function restore(string $uuid): ?CarePlan
    {
        return DB::transaction(function () use ($uuid) {
            $carePlan = CarePlan::withTrashed()->where('uuid', $uuid)->first();
            if ($carePlan && $carePlan->trashed()) {
                $carePlan->restore();

                return $carePlan;
            }

            return null;
        });
    }

    public function forceDelete(string $uuid): bool
    {
        return DB::transaction(function () use ($uuid) {
            $carePlan = CarePlan::withTrashed()->where('uuid', $uuid)->first();
            if ($carePlan) {
                return $carePlan->forceDelete();
            }

            return false;
        });
    }

    public function bulkDelete(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            CarePlan::whereIn('uuid', $uuids)->delete();

            return true;
        });
    }

    public function bulkRestore(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            CarePlan::withTrashed()->whereIn('uuid', $uuids)->restore();

            return true;
        });
    }
}

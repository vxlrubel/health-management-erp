<?php

namespace App\Services;

use App\Models\Ratesheet;
use Illuminate\Pagination\LengthAwarePaginator;

class RatesheetService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Ratesheet::query();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('description', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Ratesheet
    {
        return Ratesheet::where('uuid', $uuid)->first();
    }

    public function create(array $data): Ratesheet
    {
        return Ratesheet::create($data);
    }

    public function update(Ratesheet $ratesheet, array $data): Ratesheet
    {
        $ratesheet->update($data);

        return $ratesheet->fresh();
    }

    public function delete(Ratesheet $ratesheet): bool
    {
        return $ratesheet->delete();
    }

    public function restore(string $uuid): ?Ratesheet
    {
        $ratesheet = Ratesheet::withTrashed()->where('uuid', $uuid)->first();
        if ($ratesheet && $ratesheet->trashed()) {
            $ratesheet->restore();

            return $ratesheet;
        }

        return null;
    }

    public function forceDelete(string $uuid): bool
    {
        $ratesheet = Ratesheet::withTrashed()->where('uuid', $uuid)->first();
        if ($ratesheet) {
            return $ratesheet->forceDelete();
        }

        return false;
    }

    public function bulkDelete(array $uuids): bool
    {
        $ratesheets = Ratesheet::whereIn('uuid', $uuids)->get();
        foreach ($ratesheets as $ratesheet) {
            $ratesheet->delete();
        }

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        $ratesheets = Ratesheet::withTrashed()->whereIn('uuid', $uuids)->get();
        foreach ($ratesheets as $ratesheet) {
            if ($ratesheet->trashed()) {
                $ratesheet->restore();
            }
        }

        return true;
    }

    public function paginateTrashed(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Ratesheet::onlyTrashed();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'deleted_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }
}

<?php

namespace App\Services;

use App\Models\Rota;
use Illuminate\Pagination\LengthAwarePaginator;

class RotaService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Rota::query();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (! empty($filters['ratesheet_id'])) {
            $query->where('ratesheet_id', $filters['ratesheet_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['date_from'])) {
            $query->where('start_date', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('end_date', '<=', $filters['date_to']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Rota
    {
        return Rota::where('uuid', $uuid)->first();
    }

    public function create(array $data): Rota
    {
        return Rota::create($data);
    }

    public function update(Rota $rota, array $data): Rota
    {
        $rota->update($data);

        return $rota->fresh();
    }

    public function delete(Rota $rota): bool
    {
        return $rota->delete();
    }

    public function restore(string $uuid): ?Rota
    {
        $rota = Rota::withTrashed()->where('uuid', $uuid)->first();
        if ($rota && $rota->trashed()) {
            $rota->restore();

            return $rota;
        }

        return null;
    }

    public function forceDelete(string $uuid): bool
    {
        $rota = Rota::withTrashed()->where('uuid', $uuid)->first();
        if ($rota) {
            return $rota->forceDelete();
        }

        return false;
    }

    public function bulkDelete(array $uuids): bool
    {
        $rotas = Rota::whereIn('uuid', $uuids)->get();
        foreach ($rotas as $rota) {
            $rota->delete();
        }

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        $rotas = Rota::withTrashed()->whereIn('uuid', $uuids)->get();
        foreach ($rotas as $rota) {
            if ($rota->trashed()) {
                $rota->restore();
            }
        }

        return true;
    }

    public function paginateTrashed(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Rota::onlyTrashed();

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

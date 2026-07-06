<?php

namespace App\Services;

use App\Models\ShiftTemplate;
use Illuminate\Pagination\LengthAwarePaginator;

class ShiftTemplateService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = ShiftTemplate::query();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%");
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

    public function findByUuid(string $uuid): ?ShiftTemplate
    {
        return ShiftTemplate::where('uuid', $uuid)->first();
    }

    public function create(array $data): ShiftTemplate
    {
        return ShiftTemplate::create($data);
    }

    public function update(ShiftTemplate $shiftTemplate, array $data): ShiftTemplate
    {
        $shiftTemplate->update($data);

        return $shiftTemplate->fresh();
    }

    public function delete(ShiftTemplate $shiftTemplate): bool
    {
        return $shiftTemplate->delete();
    }

    public function restore(string $uuid): ?ShiftTemplate
    {
        $shiftTemplate = ShiftTemplate::withTrashed()->where('uuid', $uuid)->first();
        if ($shiftTemplate && $shiftTemplate->trashed()) {
            $shiftTemplate->restore();

            return $shiftTemplate;
        }

        return null;
    }

    public function forceDelete(string $uuid): bool
    {
        $shiftTemplate = ShiftTemplate::withTrashed()->where('uuid', $uuid)->first();
        if ($shiftTemplate) {
            return $shiftTemplate->forceDelete();
        }

        return false;
    }

    public function bulkDelete(array $uuids): bool
    {
        $templates = ShiftTemplate::whereIn('uuid', $uuids)->get();
        foreach ($templates as $template) {
            $template->delete();
        }

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        $templates = ShiftTemplate::withTrashed()->whereIn('uuid', $uuids)->get();
        foreach ($templates as $template) {
            if ($template->trashed()) {
                $template->restore();
            }
        }

        return true;
    }

    public function paginateTrashed(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = ShiftTemplate::onlyTrashed();

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

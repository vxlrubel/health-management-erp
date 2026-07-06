<?php

namespace App\Services;

use App\Models\EmployeeDocument;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class EmployeeDocumentService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = EmployeeDocument::query()->with(['employee']);

        if (! empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['is_verified'])) {
            $query->where('is_verified', $filters['is_verified']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?EmployeeDocument
    {
        return EmployeeDocument::with(['employee'])->where('uuid', $uuid)->first();
    }

    public function create(array $data): EmployeeDocument
    {
        return DB::transaction(function () use ($data) {
            return EmployeeDocument::create($data);
        });
    }

    public function update(EmployeeDocument $document, array $data): EmployeeDocument
    {
        return DB::transaction(function () use ($document, $data) {
            $document->update($data);

            return $document->fresh();
        });
    }

    public function delete(EmployeeDocument $document): bool
    {
        return DB::transaction(function () use ($document) {
            return $document->delete();
        });
    }

    public function restore(string $uuid): ?EmployeeDocument
    {
        return DB::transaction(function () use ($uuid) {
            $document = EmployeeDocument::withTrashed()->where('uuid', $uuid)->first();
            if ($document && $document->trashed()) {
                $document->restore();

                return $document;
            }

            return null;
        });
    }

    public function forceDelete(string $uuid): bool
    {
        return DB::transaction(function () use ($uuid) {
            $document = EmployeeDocument::withTrashed()->where('uuid', $uuid)->first();
            if ($document) {
                return $document->forceDelete();
            }

            return false;
        });
    }

    public function bulkDelete(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            EmployeeDocument::whereIn('uuid', $uuids)->delete();

            return true;
        });
    }

    public function bulkRestore(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            EmployeeDocument::withTrashed()->whereIn('uuid', $uuids)->restore();

            return true;
        });
    }
}

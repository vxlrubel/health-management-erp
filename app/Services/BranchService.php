<?php

namespace App\Services;

use App\Models\Branch;
use App\Repositories\Contracts\BranchRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class BranchService
{
    public function __construct(
        protected BranchRepositoryInterface $branchRepository
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $options['with'] = ['manager'];

        return $this->branchRepository->paginate($filters, $options);
    }

    public function findByUuid(string $uuid): ?Branch
    {
        return Branch::with(['manager'])->where('uuid', $uuid)->first();
    }

    public function create(array $data): Branch
    {
        return Branch::create($data);
    }

    public function update(Branch $branch, array $data): Branch
    {
        $branch->update($data);

        return $branch->fresh(['manager']);
    }

    public function softDelete(Branch $branch): bool
    {
        return $branch->delete();
    }

    public function restore(string $uuid): ?Branch
    {
        $branch = Branch::withTrashed()->where('uuid', $uuid)->first();

        if ($branch && $branch->trashed()) {
            $branch->restore();

            return $branch->fresh(['manager']);
        }

        return null;
    }

    public function forceDelete(string $uuid): bool
    {
        $branch = Branch::withTrashed()->where('uuid', $uuid)->first();

        if ($branch) {
            return (bool) $branch->forceDelete();
        }

        return false;
    }

    public function trash(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Branch::onlyTrashed()->with(['manager']);

        $perPage = $options['per_page'] ?? 15;

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function bulkDelete(array $uuids): bool
    {
        Branch::whereIn('uuid', $uuids)->each(fn ($branch) => $branch->delete());

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        Branch::onlyTrashed()->whereIn('uuid', $uuids)->each(fn ($branch) => $branch->restore());

        return true;
    }

    public function export(array $filters = []): Collection
    {
        $query = Branch::query()->with(['manager']);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['city'])) {
            $query->where('city', $filters['city']);
        }

        return $query->get();
    }
}

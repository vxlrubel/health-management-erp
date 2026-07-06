<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = User::query()->with(['branch', 'role']);

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

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

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (! empty($filters['role_id'])) {
            $query->where('role_id', $filters['role_id']);
        }

        $query->orderBy($sortBy, $sortOrder);

        return $query->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?User
    {
        return User::with(['branch', 'role'])->where('uuid', $uuid)->first();
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);

        if (isset($data['role_id'])) {
            $role = Role::find($data['role_id']);
            if ($role) {
                $user->assignRole($role);
            }
        }

        return $user->fresh(['branch', 'role']);
    }

    public function update(User $user, array $data): User
    {
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        if (isset($data['role_id'])) {
            $role = Role::find($data['role_id']);
            if ($role) {
                $user->syncRoles($role);
            }
        }

        $user->update($data);

        return $user->fresh(['branch', 'role']);
    }

    public function softDelete(User $user): bool
    {
        return $user->delete();
    }

    public function restore(string $uuid): ?User
    {
        $user = User::withTrashed()->where('uuid', $uuid)->first();

        if ($user && $user->trashed()) {
            $user->restore();

            return $user->fresh(['branch', 'role']);
        }

        return null;
    }

    public function forceDelete(string $uuid): bool
    {
        $user = User::withTrashed()->where('uuid', $uuid)->first();

        if ($user) {
            return (bool) $user->forceDelete();
        }

        return false;
    }

    public function trash(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = User::onlyTrashed()->with(['branch', 'role']);

        $perPage = $options['per_page'] ?? 15;

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage);
    }

    public function bulkDelete(array $uuids): bool
    {
        User::whereIn('uuid', $uuids)->each(fn ($user) => $user->delete());

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        User::onlyTrashed()->whereIn('uuid', $uuids)->each(fn ($user) => $user->restore());

        return true;
    }

    public function export(array $filters = []): Collection
    {
        $query = User::query()->with(['branch', 'role']);

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        return $query->get();
    }
}

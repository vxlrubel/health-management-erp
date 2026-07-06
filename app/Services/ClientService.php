<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Employee;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ClientService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Client::query()->with(['branch', 'funder', 'employees']);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('client_no', 'like', "%{$search}%")
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

        if (! empty($filters['funder_id'])) {
            $query->where('funder_id', $filters['funder_id']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Client
    {
        return Client::with(['branch', 'funder', 'employees', 'carePlans'])->where('uuid', $uuid)->first();
    }

    public function create(array $data): Client
    {
        return DB::transaction(function () use ($data) {
            return Client::create($data);
        });
    }

    public function update(Client $client, array $data): Client
    {
        return DB::transaction(function () use ($client, $data) {
            $client->update($data);

            return $client->fresh();
        });
    }

    public function delete(Client $client): bool
    {
        return DB::transaction(function () use ($client) {
            return $client->delete();
        });
    }

    public function restore(string $uuid): ?Client
    {
        return DB::transaction(function () use ($uuid) {
            $client = Client::withTrashed()->where('uuid', $uuid)->first();
            if ($client && $client->trashed()) {
                $client->restore();

                return $client;
            }

            return null;
        });
    }

    public function forceDelete(string $uuid): bool
    {
        return DB::transaction(function () use ($uuid) {
            $client = Client::withTrashed()->where('uuid', $uuid)->first();
            if ($client) {
                return $client->forceDelete();
            }

            return false;
        });
    }

    public function bulkDelete(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            Client::whereIn('uuid', $uuids)->delete();

            return true;
        });
    }

    public function bulkRestore(array $uuids): bool
    {
        return DB::transaction(function () use ($uuids) {
            Client::withTrashed()->whereIn('uuid', $uuids)->restore();

            return true;
        });
    }

    public function assignEmployee(Client $client, Employee $employee, array $data = []): void
    {
        DB::transaction(function () use ($client, $employee, $data) {
            $client->employees()->syncWithoutDetaching([
                $employee->id => [
                    'assigned_from' => $data['assigned_from'] ?? now(),
                    'assigned_to' => $data['assigned_to'] ?? null,
                    'is_primary' => $data['is_primary'] ?? false,
                ],
            ]);
        });
    }

    public function removeEmployee(Client $client, Employee $employee): void
    {
        DB::transaction(function () use ($client, $employee) {
            $client->employees()->detach($employee->id);
        });
    }
}

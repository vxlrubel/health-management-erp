<?php

namespace App\Services;

use App\Enums\ScheduleStatus;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class ScheduleService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Schedule::query();

        if (! empty($filters['search'])) {
            $query->whereHas('employee', function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (! empty($filters['rota_id'])) {
            $query->where('rota_id', $filters['rota_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['date_from'])) {
            $query->where('start_datetime', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('end_datetime', '<=', $filters['date_to']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'start_datetime';
        $sortOrder = $options['sort_order'] ?? 'asc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Schedule
    {
        return Schedule::where('uuid', $uuid)->first();
    }

    public function create(array $data): Schedule
    {
        return Schedule::create($data);
    }

    public function update(Schedule $schedule, array $data): Schedule
    {
        $schedule->update($data);

        return $schedule->fresh();
    }

    public function delete(Schedule $schedule): bool
    {
        return $schedule->delete();
    }

    public function restore(string $uuid): ?Schedule
    {
        $schedule = Schedule::withTrashed()->where('uuid', $uuid)->first();
        if ($schedule && $schedule->trashed()) {
            $schedule->restore();

            return $schedule;
        }

        return null;
    }

    public function forceDelete(string $uuid): bool
    {
        $schedule = Schedule::withTrashed()->where('uuid', $uuid)->first();
        if ($schedule) {
            return $schedule->forceDelete();
        }

        return false;
    }

    public function bulkDelete(array $uuids): bool
    {
        $schedules = Schedule::whereIn('uuid', $uuids)->get();
        foreach ($schedules as $schedule) {
            $schedule->delete();
        }

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        $schedules = Schedule::withTrashed()->whereIn('uuid', $uuids)->get();
        foreach ($schedules as $schedule) {
            if ($schedule->trashed()) {
                $schedule->restore();
            }
        }

        return true;
    }

    public function paginateTrashed(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Schedule::onlyTrashed();

        if (! empty($filters['search'])) {
            $query->whereHas('employee', function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'deleted_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function approve(Schedule $schedule, User $user): Schedule
    {
        $schedule->update(['status' => ScheduleStatus::Pending]);

        return $schedule->fresh();
    }

    public function cancel(Schedule $schedule, User $user): Schedule
    {
        $schedule->update(['status' => ScheduleStatus::Cancelled]);

        return $schedule->fresh();
    }

    public function complete(Schedule $schedule, User $user): Schedule
    {
        $schedule->update(['status' => ScheduleStatus::Completed]);

        return $schedule->fresh();
    }
}

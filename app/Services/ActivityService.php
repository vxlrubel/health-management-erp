<?php

namespace App\Services;

use App\Enums\ActivityStatus;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class ActivityService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Activity::query();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('activity_type', 'like', "%{$filters['search']}%")
                    ->orWhere('notes', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (! empty($filters['schedule_id'])) {
            $query->where('schedule_id', $filters['schedule_id']);
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['activity_type'])) {
            $query->where('activity_type', $filters['activity_type']);
        }

        if (! empty($filters['date_from'])) {
            $query->where('start_datetime', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->where('end_datetime', '<=', $filters['date_to']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'start_datetime';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?Activity
    {
        return Activity::where('uuid', $uuid)->first();
    }

    public function create(array $data): Activity
    {
        return Activity::create($data);
    }

    public function update(Activity $activity, array $data): Activity
    {
        $activity->update($data);

        return $activity->fresh();
    }

    public function delete(Activity $activity): bool
    {
        return $activity->delete();
    }

    public function restore(string $uuid): ?Activity
    {
        $activity = Activity::withTrashed()->where('uuid', $uuid)->first();
        if ($activity && $activity->trashed()) {
            $activity->restore();

            return $activity;
        }

        return null;
    }

    public function forceDelete(string $uuid): bool
    {
        $activity = Activity::withTrashed()->where('uuid', $uuid)->first();
        if ($activity) {
            return $activity->forceDelete();
        }

        return false;
    }

    public function bulkDelete(array $uuids): bool
    {
        $activities = Activity::whereIn('uuid', $uuids)->get();
        foreach ($activities as $activity) {
            $activity->delete();
        }

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        $activities = Activity::withTrashed()->whereIn('uuid', $uuids)->get();
        foreach ($activities as $activity) {
            if ($activity->trashed()) {
                $activity->restore();
            }
        }

        return true;
    }

    public function paginateTrashed(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = Activity::onlyTrashed();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('activity_type', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['employee_id'])) {
            $query->where('employee_id', $filters['employee_id']);
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (! empty($filters['schedule_id'])) {
            $query->where('schedule_id', $filters['schedule_id']);
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'deleted_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function approve(Activity $activity, User $user): Activity
    {
        $activity->update(['status' => ActivityStatus::Approved]);

        return $activity->fresh();
    }

    public function cancel(Activity $activity, User $user): Activity
    {
        $activity->update(['status' => ActivityStatus::Cancelled]);

        return $activity->fresh();
    }

    public function complete(Activity $activity, User $user): Activity
    {
        $activity->update(['status' => ActivityStatus::Completed]);

        return $activity->fresh();
    }

    public function start(Activity $activity, User $user): Activity
    {
        $activity->update(['status' => ActivityStatus::InProgress]);

        return $activity->fresh();
    }

    public function stop(Activity $activity, User $user): Activity
    {
        if ($activity->start_datetime && $activity->end_datetime) {
            $start = $activity->start_datetime;
            $end = now();
            $hours = $start->diffInSeconds($end) / 3600;
            $activity->update([
                'end_datetime' => $end,
                'actual_hours' => round($hours, 2),
                'status' => ActivityStatus::Completed,
            ]);
        }

        return $activity->fresh();
    }
}

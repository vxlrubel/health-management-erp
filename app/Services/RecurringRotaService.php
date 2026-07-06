<?php

namespace App\Services;

use App\Models\RecurringRota;
use App\Models\Schedule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RecurringRotaService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = RecurringRota::query()->with(['rota', 'shiftTemplate']);

        if (! empty($filters['search'])) {
            $query->whereHas('rota', function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%");
            });
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

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'created_at';
        $sortOrder = $options['sort_order'] ?? 'desc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?RecurringRota
    {
        return RecurringRota::with(['rota', 'shiftTemplate'])->where('uuid', $uuid)->first();
    }

    public function create(array $data): RecurringRota
    {
        return RecurringRota::create($data);
    }

    public function update(RecurringRota $recurringRota, array $data): RecurringRota
    {
        $recurringRota->update($data);

        return $recurringRota->fresh();
    }

    public function delete(RecurringRota $recurringRota): bool
    {
        return $recurringRota->delete();
    }

    public function restore(string $uuid): ?RecurringRota
    {
        $recurringRota = RecurringRota::withTrashed()->where('uuid', $uuid)->first();
        if ($recurringRota && $recurringRota->trashed()) {
            $recurringRota->restore();

            return $recurringRota;
        }

        return null;
    }

    public function forceDelete(string $uuid): bool
    {
        $recurringRota = RecurringRota::withTrashed()->where('uuid', $uuid)->first();
        if ($recurringRota) {
            return $recurringRota->forceDelete();
        }

        return false;
    }

    public function bulkDelete(array $uuids): bool
    {
        $items = RecurringRota::whereIn('uuid', $uuids)->get();
        foreach ($items as $item) {
            $item->delete();
        }

        return true;
    }

    public function bulkRestore(array $uuids): bool
    {
        $items = RecurringRota::withTrashed()->whereIn('uuid', $uuids)->get();
        foreach ($items as $item) {
            if ($item->trashed()) {
                $item->restore();
            }
        }

        return true;
    }

    public function generate(string $uuid, User $user): Collection
    {
        $recurringRota = $this->findByUuid($uuid);
        if (! $recurringRota) {
            return new Collection;
        }

        $startDate = Carbon::parse($recurringRota->start_date);
        $endDate = Carbon::parse($recurringRota->end_date);
        $shiftTemplate = $recurringRota->shiftTemplate;
        $rota = $recurringRota->rota;
        $schedules = new Collection;

        $currentDate = $startDate->copy();
        while ($currentDate->lte($endDate)) {
            if ($this->shouldIncludeDate($currentDate, $recurringRota)) {
                $startDateTime = $currentDate->copy()->setTimeFromTimeString($shiftTemplate->start_time);
                $endDateTime = $currentDate->copy()->setTimeFromTimeString($shiftTemplate->end_time);

                if ($endDateTime->lte($startDateTime)) {
                    $endDateTime->addDay();
                }

                $schedule = Schedule::create([
                    'rota_id' => $rota->id,
                    'employee_id' => null,
                    'client_id' => null,
                    'branch_id' => $recurringRota->branch_id,
                    'start_datetime' => $startDateTime,
                    'end_datetime' => $endDateTime,
                    'planned_hours' => $shiftTemplate->planned_hours,
                    'status' => 'pending',
                ]);

                $schedules->push($schedule);
            }
            $currentDate->addDay();
        }

        return $schedules;
    }

    public function paginateTrashed(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = RecurringRota::onlyTrashed()->with(['rota', 'shiftTemplate']);

        if (! empty($filters['search'])) {
            $query->whereHas('rota', function ($q) use ($filters) {
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

    private function shouldIncludeDate(Carbon $date, RecurringRota $recurringRota): bool
    {
        return match ($recurringRota->frequency) {
            'daily' => true,
            'weekly' => $date->dayOfWeek === Carbon::MONDAY,
            'biweekly' => $date->dayOfWeek === Carbon::MONDAY && $date->weekOfYear % 2 === 0,
            'monthly' => $date->day === 1,
            default => false,
        };
    }
}

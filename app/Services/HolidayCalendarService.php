<?php

namespace App\Services;

use App\Models\HolidayCalendar;
use Illuminate\Pagination\LengthAwarePaginator;

class HolidayCalendarService
{
    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        $query = HolidayCalendar::query();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('type', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['branch_id'])) {
            $query->where('branch_id', $filters['branch_id']);
        }

        if (! empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (! empty($filters['year'])) {
            $query->whereYear('holiday_date', $filters['year']);
        }

        if (! empty($filters['month'])) {
            $query->whereMonth('holiday_date', $filters['month']);
        }

        if (isset($filters['is_paid'])) {
            $query->where('is_paid', filter_var($filters['is_paid'], FILTER_VALIDATE_BOOLEAN));
        }

        $perPage = $options['per_page'] ?? 15;
        $sortBy = $options['sort_by'] ?? 'holiday_date';
        $sortOrder = $options['sort_order'] ?? 'asc';

        return $query->orderBy($sortBy, $sortOrder)->paginate($perPage);
    }

    public function findByUuid(string $uuid): ?HolidayCalendar
    {
        return HolidayCalendar::where('uuid', $uuid)->first();
    }

    public function create(array $data): HolidayCalendar
    {
        return HolidayCalendar::create($data);
    }

    public function update(HolidayCalendar $holiday, array $data): HolidayCalendar
    {
        $holiday->update($data);

        return $holiday->fresh();
    }

    public function delete(HolidayCalendar $holiday): bool
    {
        return $holiday->delete();
    }
}

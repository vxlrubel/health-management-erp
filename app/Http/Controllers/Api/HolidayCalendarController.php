<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\HolidayCalendar\StoreHolidayCalendarRequest;
use App\Http\Requests\HolidayCalendar\UpdateHolidayCalendarRequest;
use App\Http\Resources\HolidayCalendarCollection;
use App\Http\Resources\HolidayCalendarResource;
use App\Services\HolidayCalendarService;
use Illuminate\Http\JsonResponse;

class HolidayCalendarController extends Controller
{
    public function __construct(
        private readonly HolidayCalendarService $holidayCalendarService
    ) {}

    /**
     * List all holidays.
     *
     * @queryParam search string Search by name or type. Example: Christmas
     * @queryParam branch_id int Filter by branch. Example: 1
     * @queryParam type string Filter by type. Example: public
     * @queryParam year int Filter by year. Example: 2024
     * @queryParam month int Filter by month. Example: 12
     * @queryParam is_paid bool Filter by paid status. Example: true
     * @queryParam per_page int Items per page. Example: 15
     * @queryParam sort_by string Field to sort by. Example: holiday_date
     * @queryParam sort_order string Sort direction. Example: asc
     */
    public function index(): JsonResponse
    {
        $holidays = $this->holidayCalendarService->paginate(
            request()->only(['search', 'branch_id', 'type', 'year', 'month', 'is_paid']),
            request()->only(['per_page', 'sort_by', 'sort_order'])
        );

        return $this->paginatedResponse(
            new HolidayCalendarCollection($holidays)
        );
    }

    /**
     * Store a newly created holiday.
     *
     * @bodyParam branch_id int optional Branch ID. Example: 1
     * @bodyParam name string required Holiday name. Example: Christmas
     * @bodyParam holiday_date date required Holiday date. Example: 2024-12-25
     * @bodyParam type string required Holiday type. Example: public
     * @bodyParam is_paid bool optional Is paid holiday. Example: true
     */
    public function store(StoreHolidayCalendarRequest $request): JsonResponse
    {
        $holiday = $this->holidayCalendarService->create($request->validated());

        return $this->createdResponse(
            new HolidayCalendarResource($holiday),
            'Holiday created successfully.'
        );
    }

    /**
     * Show the specified holiday.
     *
     * @urlParam uuid string required The UUID of the holiday. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function show(string $uuid): JsonResponse
    {
        $holiday = $this->holidayCalendarService->findByUuid($uuid);

        if (! $holiday) {
            return $this->notFoundResponse('Holiday not found.');
        }

        return $this->successResponse(
            new HolidayCalendarResource($holiday)
        );
    }

    /**
     * Update the specified holiday.
     *
     * @urlParam uuid string required The UUID of the holiday. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function update(UpdateHolidayCalendarRequest $request, string $uuid): JsonResponse
    {
        $holiday = $this->holidayCalendarService->findByUuid($uuid);

        if (! $holiday) {
            return $this->notFoundResponse('Holiday not found.');
        }

        $holiday = $this->holidayCalendarService->update($holiday, $request->validated());

        return $this->successResponse(
            new HolidayCalendarResource($holiday),
            'Holiday updated successfully.'
        );
    }

    /**
     * Delete the specified holiday.
     *
     * @urlParam uuid string required The UUID of the holiday. Example: 550e8400-e29b-41d4-a716-446655440000
     */
    public function destroy(string $uuid): JsonResponse
    {
        $holiday = $this->holidayCalendarService->findByUuid($uuid);

        if (! $holiday) {
            return $this->notFoundResponse('Holiday not found.');
        }

        $this->holidayCalendarService->delete($holiday);

        return $this->deletedResponse('Holiday deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    /**
     * Dashboard overview
     */
    public function index(): JsonResponse
    {
        $data = $this->dashboardService->overview();

        return $this->successResponse($data);
    }

    /**
     * Dashboard statistics
     */
    public function statistics(): JsonResponse
    {
        $data = $this->dashboardService->statistics();

        return $this->successResponse($data);
    }

    /**
     * Dashboard charts
     */
    public function charts(): JsonResponse
    {
        $data = $this->dashboardService->charts();

        return $this->successResponse($data);
    }

    /**
     * Recent activities
     */
    public function recentActivities(): JsonResponse
    {
        $data = $this->dashboardService->recentActivities();

        return $this->successResponse($data);
    }

    /**
     * Today schedule
     */
    public function todaySchedule(): JsonResponse
    {
        $data = $this->dashboardService->todaySchedule();

        return $this->successResponse($data);
    }

    /**
     * Revenue overview
     */
    public function revenue(): JsonResponse
    {
        $data = $this->dashboardService->revenue();

        return $this->successResponse($data);
    }

    /**
     * Salary overview
     */
    public function salary(): JsonResponse
    {
        $data = $this->dashboardService->salary();

        return $this->successResponse($data);
    }
}

<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function overview(): array
    {
        return [
            'total_clients' => DB::table('clients')->count(),
            'total_employees' => DB::table('employees')->count(),
            'total_medicines' => DB::table('medicines')->count(),
            'active_schedules' => DB::table('medicine_administrations')
                ->whereDate('administered_at', today())
                ->count(),
            'unread_notifications' => DB::table('notifications')
                ->whereNull('read_at')
                ->count(),
            'pending_reports' => DB::table('reports')
                ->where('status', 'pending')
                ->count(),
        ];
    }

    public function statistics(): array
    {
        return [
            'medicines_by_status' => DB::table('medicines')
                ->select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->pluck('total', 'status'),
            'administrations_today' => DB::table('medicine_administrations')
                ->whereDate('administered_at', today())
                ->count(),
            'administrations_this_week' => DB::table('medicine_administrations')
                ->whereBetween('administered_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
            'administrations_this_month' => DB::table('medicine_administrations')
                ->whereMonth('administered_at', now()->month)
                ->whereYear('administered_at', now()->year)
                ->count(),
        ];
    }

    public function charts(): array
    {
        $administrationsChart = DB::table('medicine_administrations')
            ->select(DB::raw('DATE(administered_at) as date'), DB::raw('count(*) as total'))
            ->whereBetween('administered_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $medicinesByRoute = DB::table('medicines')
            ->select('route', DB::raw('count(*) as total'))
            ->groupBy('route')
            ->pluck('total', 'route');

        return [
            'administrations_chart' => $administrationsChart,
            'medicines_by_route' => $medicinesByRoute,
        ];
    }

    public function recentActivities(): Collection
    {
        return DB::table('activity_logs')
            ->latest()
            ->limit(10)
            ->get();
    }

    public function todaySchedule(): Collection
    {
        return DB::table('medicine_administrations')
            ->whereDate('administered_at', today())
            ->orderBy('administered_at')
            ->get();
    }

    public function revenue(): array
    {
        $total = DB::table('invoices')
            ->where('status', 'paid')
            ->sum('amount');

        $thisMonth = DB::table('invoices')
            ->where('status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $chart = DB::table('invoices')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(amount) as total'))
            ->where('status', 'paid')
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'total_revenue' => $total,
            'this_month_revenue' => $thisMonth,
            'revenue_chart' => $chart,
        ];
    }

    public function salary(): array
    {
        $total = DB::table('salaries')->sum('amount');

        $thisMonth = DB::table('salaries')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $chart = DB::table('salaries')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(amount) as total'))
            ->whereBetween('created_at', [now()->subDays(30), now()])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return [
            'total_salary' => $total,
            'this_month_salary' => $thisMonth,
            'salary_chart' => $chart,
        ];
    }
}

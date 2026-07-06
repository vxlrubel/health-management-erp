<?php

namespace App\Services;

use App\Models\Report;
use App\Repositories\Eloquent\ReportRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function __construct(
        protected ReportRepository $repository
    ) {}

    public function paginate(array $filters = [], array $options = []): LengthAwarePaginator
    {
        return $this->repository->paginate($filters, $options);
    }

    public function findById(int $id): ?Report
    {
        return $this->repository->findById($id);
    }

    public function findByUuid(string $uuid): ?Report
    {
        return $this->repository->findByUuid($uuid);
    }

    public function create(array $data): Report
    {
        return $this->repository->create($data);
    }

    public function update(Report $report, array $data): Report
    {
        return $this->repository->update($report, $data);
    }

    public function delete(Report $report): bool
    {
        return $report->delete();
    }

    public function dashboard(): array
    {
        return [
            'total_reports' => Report::count(),
            'reports_by_type' => Report::select('type', DB::raw('count(*) as total'))
                ->groupBy('type')
                ->pluck('total', 'type'),
            'recent_reports' => Report::latest()->take(5)->get(),
        ];
    }

    public function activity(): Collection
    {
        return DB::table('activity_logs')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
    }

    public function schedule(): Collection
    {
        return DB::table('medicine_administrations')
            ->select(DB::raw('DATE(administered_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
    }

    public function employee(): Collection
    {
        return DB::table('employees')
            ->select('id', 'name', DB::raw('(SELECT count(*) FROM medicine_administrations WHERE employee_id = employees.id) as administration_count'))
            ->orderBy('administration_count', 'desc')
            ->limit(20)
            ->get();
    }

    public function client(): Collection
    {
        return DB::table('clients')
            ->select('id', 'name', DB::raw('(SELECT count(*) FROM medicines WHERE client_id = clients.id) as medicine_count'))
            ->orderBy('medicine_count', 'desc')
            ->limit(20)
            ->get();
    }

    public function invoice(): Collection
    {
        return DB::table('invoices')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
    }

    public function salary(): Collection
    {
        return DB::table('salaries')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(30)
            ->get();
    }

    public function leave(): Collection
    {
        return DB::table('leaves')
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
    }
}

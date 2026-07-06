<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReportRequest;
use App\Http\Resources\ReportCollection;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    /**
     * List reports
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'type', 'status']);
        $options = [
            'per_page' => $request->input('per_page', 15),
            'sort_by' => $request->input('sort_by', 'created_at'),
            'sort_order' => $request->input('sort_order', 'desc'),
        ];

        $reports = $this->reportService->paginate($filters, $options);

        return $this->paginatedResponse(
            new ReportCollection($reports)
        );
    }

    /**
     * Show report
     */
    public function show(string $uuid): JsonResponse
    {
        $report = $this->reportService->findByUuid($uuid);

        if (! $report) {
            return $this->notFoundResponse('Report not found.');
        }

        return $this->successResponse(
            new ReportResource($report)
        );
    }

    /**
     * Create report
     */
    public function store(StoreReportRequest $request): JsonResponse
    {
        $report = $this->reportService->create($request->validated());

        return $this->createdResponse(
            new ReportResource($report),
            'Report created successfully.'
        );
    }

    /**
     * Delete report
     */
    public function destroy(string $uuid): JsonResponse
    {
        $report = $this->reportService->findByUuid($uuid);

        if (! $report) {
            return $this->notFoundResponse('Report not found.');
        }

        $this->reportService->delete($report);

        return $this->deletedResponse('Report deleted successfully.');
    }

    /**
     * Dashboard report
     */
    public function dashboard(): JsonResponse
    {
        $data = $this->reportService->dashboard();

        return $this->successResponse($data);
    }

    /**
     * Activity report
     */
    public function activity(): JsonResponse
    {
        $data = $this->reportService->activity();

        return $this->successResponse($data);
    }

    /**
     * Schedule report
     */
    public function schedule(): JsonResponse
    {
        $data = $this->reportService->schedule();

        return $this->successResponse($data);
    }

    /**
     * Employee report
     */
    public function employee(): JsonResponse
    {
        $data = $this->reportService->employee();

        return $this->successResponse($data);
    }

    /**
     * Client report
     */
    public function client(): JsonResponse
    {
        $data = $this->reportService->client();

        return $this->successResponse($data);
    }

    /**
     * Invoice report
     */
    public function invoice(): JsonResponse
    {
        $data = $this->reportService->invoice();

        return $this->successResponse($data);
    }

    /**
     * Salary report
     */
    public function salary(): JsonResponse
    {
        $data = $this->reportService->salary();

        return $this->successResponse($data);
    }

    /**
     * Leave report
     */
    public function leave(): JsonResponse
    {
        $data = $this->reportService->leave();

        return $this->successResponse($data);
    }

    /**
     * Export report as PDF
     */
    public function exportPdf(string $uuid): JsonResponse
    {
        $report = $this->reportService->findByUuid($uuid);

        if (! $report) {
            return $this->notFoundResponse('Report not found.');
        }

        return $this->successResponse([
            'report' => new ReportResource($report),
            'format' => 'pdf',
        ], 'Report exported as PDF.');
    }

    /**
     * Export report as Excel
     */
    public function exportExcel(string $uuid): JsonResponse
    {
        $report = $this->reportService->findByUuid($uuid);

        if (! $report) {
            return $this->notFoundResponse('Report not found.');
        }

        return $this->successResponse([
            'report' => new ReportResource($report),
            'format' => 'excel',
        ], 'Report exported as Excel.');
    }
}

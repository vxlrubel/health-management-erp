<?php

namespace App\Http\Controllers\Utility;

use App\Http\Controllers\Controller;
use App\Services\ExportCenterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportCenterController extends Controller
{
    public function __construct(
        protected ExportCenterService $exportService,
    ) {}

    /**
     * List supported export formats.
     *
     * Returns a list of supported export file types.
     */
    public function index(): JsonResponse
    {
        return $this->successResponse([
            'formats' => $this->exportService->getSupportedTypes(),
        ]);
    }

    /**
     * Export data to CSV.
     *
     * Generate and download a CSV export for the given model query.
     *
     * @bodyParam model string required The fully qualified model class name. Example: App\Models\Employee
     * @bodyParam columns object required Key-value pairs of column => header. Example: {"first_name": "First Name", "last_name": "Last Name"}
     * @bodyParam filters object Optional filters to apply to the query. Example: {"status": "active"}
     * @bodyParam filename string Output filename. Example: employees.csv
     */
    public function exportCsv(Request $request): StreamedResponse|JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'columns' => ['required', 'array', 'min:1'],
            'filters' => ['nullable', 'array'],
            'filename' => ['nullable', 'string', 'max:255'],
        ]);

        $modelClass = $request->model;

        if (! class_exists($modelClass)) {
            return $this->errorResponse('Model class not found.', 400);
        }

        $query = $modelClass::query();

        if ($request->filled('filters')) {
            foreach ($request->filters as $field => $value) {
                $query->where($field, $value);
            }
        }

        $filename = $request->filename ?? 'export.csv';

        return $this->exportService->exportCsv($query, $request->columns, $filename);
    }

    /**
     * Export data to Excel (XLSX).
     *
     * Generate an Excel export file and return its storage path.
     *
     * @bodyParam model string required The fully qualified model class name. Example: App\Models\Employee
     * @bodyParam columns object required Key-value pairs of column => header. Example: {"first_name": "First Name", "last_name": "Last Name"}
     * @bodyParam filters object Optional filters to apply to the query. Example: {"status": "active"}
     * @bodyParam filename string Output filename. Example: employees.xlsx
     */
    public function exportExcel(Request $request): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'columns' => ['required', 'array', 'min:1'],
            'filters' => ['nullable', 'array'],
            'filename' => ['nullable', 'string', 'max:255'],
        ]);

        $modelClass = $request->model;

        if (! class_exists($modelClass)) {
            return $this->errorResponse('Model class not found.', 400);
        }

        $query = $modelClass::query();

        if ($request->filled('filters')) {
            foreach ($request->filters as $field => $value) {
                $query->where($field, $value);
            }
        }

        $filename = $request->filename ?? 'export.xlsx';
        $path = $this->exportService->exportExcel($query, $request->columns, $filename);

        return $this->successResponse([
            'path' => $path,
            'url' => Storage::url($path),
            'filename' => $filename,
        ], 'Excel export generated successfully.');
    }

    /**
     * Export data to PDF.
     *
     * Generate a PDF export from a Blade view and return its storage path.
     *
     * @bodyParam view string required The Blade view name. Example: exports.employees
     * @bodyParam data object required Data to pass to the view. Example: {"title": "Employees Report"}
     * @bodyParam filename string Output filename. Example: employees.pdf
     */
    public function exportPdf(Request $request): JsonResponse
    {
        $request->validate([
            'view' => ['required', 'string'],
            'data' => ['required', 'array'],
            'filename' => ['nullable', 'string', 'max:255'],
        ]);

        $filename = $request->filename ?? 'export.pdf';
        $path = $this->exportService->exportPdf($request->view, $request->data, $filename);

        return $this->successResponse([
            'path' => $path,
            'url' => Storage::url($path),
            'filename' => $filename,
        ], 'PDF export generated successfully.');
    }

    /**
     * Download an exported file.
     *
     * Download a previously generated export file by its storage path.
     *
     * @urlParam path string required The relative storage path of the file. Example: exports/employees.csv
     */
    public function download(string $path): StreamedResponse|JsonResponse
    {
        if (! Storage::exists($path)) {
            return $this->notFoundResponse('File not found.');
        }

        return Storage::download($path);
    }
}

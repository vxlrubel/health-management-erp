<?php

namespace App\Services;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportCenterService
{
    public function exportCsv(
        Builder $query,
        array $columns,
        string $filename = 'export.csv'
    ): StreamedResponse {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($query, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, array_values($columns));

            $query->chunk(200, function ($rows) use ($file, $columns) {
                foreach ($rows as $row) {
                    $data = [];
                    foreach (array_keys($columns) as $column) {
                        $data[] = data_get($row, $column, '');
                    }
                    fputcsv($file, $data);
                }
            });

            fclose($file);
        };

        return new StreamedResponse($callback, 200, $headers);
    }

    public function exportExcel(
        Builder $query,
        array $columns,
        string $filename = 'export.xlsx'
    ): string {
        $spreadsheet = new Spreadsheet;
        $sheet = $spreadsheet->getActiveSheet();

        $headerCol = 'A';
        foreach (array_values($columns) as $header) {
            $sheet->setCellValue($headerCol++.'1', $header);
        }

        $rowIndex = 2;
        $query->chunk(200, function ($rows) use ($sheet, $columns, &$rowIndex) {
            foreach ($rows as $row) {
                $colIndex = 'A';
                foreach (array_keys($columns) as $column) {
                    $sheet->setCellValue($colIndex++.$rowIndex, data_get($row, $column, ''));
                }
                $rowIndex++;
            }
        });

        $writer = new Xlsx($spreadsheet);
        $path = "exports/{$filename}";
        Storage::put($path, '');
        $writer->save(Storage::path($path));

        return $path;
    }

    public function exportPdf(
        string $view,
        array $data,
        string $filename = 'export.pdf'
    ): string {
        $pdf = Pdf::loadView($view, $data);
        $path = "exports/{$filename}";
        Storage::put($path, $pdf->output());

        return $path;
    }

    public function getSupportedTypes(): array
    {
        return ['csv', 'excel', 'pdf'];
    }
}

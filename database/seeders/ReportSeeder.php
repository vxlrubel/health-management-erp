<?php

namespace Database\Seeders;

use App\Models\Report;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ReportSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $reports = [
            ['name' => 'Monthly Care Summary', 'type' => 'care_summary'],
            ['name' => 'Employee Hours Report', 'type' => 'hours_report'],
            ['name' => 'Invoice Aging Report', 'type' => 'invoice_aging'],
            ['name' => 'Client Activity Log', 'type' => 'activity_log'],
            ['name' => 'Medication Compliance', 'type' => 'medication_compliance'],
            ['name' => 'Staff Performance Review', 'type' => 'performance'],
        ];

        foreach ($reports as $report) {
            Report::firstOrCreate(
                ['name' => $report['name']],
                [
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'type' => $report['type'],
                    'filters_json' => json_encode(['date_from' => now()->subMonth()->format('Y-m-d'), 'date_to' => now()->format('Y-m-d')]),
                    'generated_by' => 'System',
                    'file_path' => 'reports/' . $report['type'] . '_' . now()->format('Ymd') . '.pdf',
                    'status' => 'completed',
                ]
            );
        }

        $this->command->info('Reports seeded successfully.');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Form;
use Illuminate\Database\Seeder;

class FormSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();

        $forms = [
            [
                'name' => 'Care Assessment Form',
                'description' => 'Initial care needs assessment for new clients.',
                'schema_json' => json_encode([
                    'fields' => [
                        ['type' => 'text', 'label' => 'Client Name', 'required' => true],
                        ['type' => 'textarea', 'label' => 'Care Requirements', 'required' => true],
                        ['type' => 'select', 'label' => 'Care Level', 'options' => ['low', 'medium', 'high', 'specialist']],
                    ],
                ]),
            ],
            [
                'name' => 'Medication Record',
                'description' => 'Daily medication administration record.',
                'schema_json' => json_encode([
                    'fields' => [
                        ['type' => 'text', 'label' => 'Medicine Name', 'required' => true],
                        ['type' => 'text', 'label' => 'Dosage', 'required' => true],
                        ['type' => 'time', 'label' => 'Time Administered', 'required' => true],
                        ['type' => 'textarea', 'label' => 'Notes'],
                    ],
                ]),
            ],
            [
                'name' => 'Incident Report',
                'description' => 'Report any incidents or accidents.',
                'schema_json' => json_encode([
                    'fields' => [
                        ['type' => 'text', 'label' => 'Incident Type', 'required' => true],
                        ['type' => 'datetime', 'label' => 'Date/Time', 'required' => true],
                        ['type' => 'textarea', 'label' => 'Description', 'required' => true],
                        ['type' => 'select', 'label' => 'Severity', 'options' => ['low', 'medium', 'high', 'critical']],
                    ],
                ]),
            ],
            [
                'name' => 'Staff Evaluation',
                'description' => 'Periodic staff performance evaluation.',
                'schema_json' => json_encode([
                    'fields' => [
                        ['type' => 'text', 'label' => 'Employee Name', 'required' => true],
                        ['type' => 'rating', 'label' => 'Performance Rating', 'max' => 5],
                        ['type' => 'textarea', 'label' => 'Comments', 'required' => true],
                    ],
                ]),
            ],
        ];

        foreach ($branches as $branch) {
            foreach ($forms as $formData) {
                Form::firstOrCreate(
                    ['name' => $formData['name'], 'branch_id' => $branch->id],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'description' => $formData['description'],
                        'schema_json' => $formData['schema_json'],
                        'status' => 'published',
                    ]
                );
            }
        }

        $this->command->info('Forms seeded successfully.');
    }
}

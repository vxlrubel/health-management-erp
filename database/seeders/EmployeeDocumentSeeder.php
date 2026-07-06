<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeDocument;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EmployeeDocumentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $employees = Employee::all();

        $docTypes = [
            ['type' => 'contract', 'title' => 'Employment Contract'],
            ['type' => 'id', 'title' => 'ID / Passport Copy'],
            ['type' => 'certification', 'title' => 'Care Certificate'],
            ['type' => 'training', 'title' => 'Training Certificate'],
            ['type' => 'dbs', 'title' => 'DBS Check'],
        ];

        foreach ($employees as $employee) {
            foreach ($docTypes as $doc) {
                EmployeeDocument::firstOrCreate(
                    ['employee_id' => $employee->id, 'type' => $doc['type']],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'title' => $doc['title'],
                        'file_path' => 'documents/' . $employee->id . '/' . $doc['type'] . '.pdf',
                        'expiry_date' => $doc['type'] === 'dbs' ? $faker->date('Y-m-d', '+2 years') : null,
                        'is_verified' => $faker->boolean(80),
                    ]
                );
            }
        }

        $this->command->info('Employee documents seeded successfully.');
    }
}

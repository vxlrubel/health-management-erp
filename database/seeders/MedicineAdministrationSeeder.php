<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Medicine;
use App\Models\MedicineAdministration;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MedicineAdministrationSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $medicines = Medicine::all();
        $employees = Employee::all();

        foreach ($medicines as $medicine) {
            $numAdmins = rand(1, 5);
            $employee = $employees->random();

            for ($i = 0; $i < $numAdmins; $i++) {
                $adminTime = \Carbon\Carbon::now()->subDays(rand(0, 14))->addHours(rand(7, 21));

                MedicineAdministration::firstOrCreate(
                    [
                        'medicine_id' => $medicine->id,
                        'administered_at' => $adminTime->format('Y-m-d H:i:s'),
                    ],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'client_id' => $medicine->client_id,
                        'employee_id' => $employee->id,
                        'administered_at' => $adminTime->format('Y-m-d H:i:s'),
                        'dose_given' => $medicine->dosage,
                        'status' => 'completed',
                        'notes' => $faker->optional(0.5)->sentence(),
                    ]
                );
            }
        }

        $this->command->info('Medicine administrations seeded successfully.');
    }
}

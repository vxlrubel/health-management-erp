<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Leave;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class LeaveSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $employees = Employee::all();
        $leaveTypes = ['annual', 'sick', 'personal', 'maternity', 'paternity', 'bereavement', 'other'];

        foreach ($employees as $employee) {
            $numLeaves = rand(1, 3);
            for ($i = 0; $i < $numLeaves; $i++) {
                $startDate = \Carbon\Carbon::now()->addMonths(rand(-2, 2))->startOfMonth()->addDays(rand(0, 20));
                $endDate = $startDate->copy()->addDays(rand(0, 5));

                Leave::firstOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'start_date' => $startDate->format('Y-m-d'),
                        'leave_type' => $faker->randomElement($leaveTypes),
                    ],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'leave_type' => $faker->randomElement($leaveTypes),
                        'reason' => $faker->sentence(),
                        'start_date' => $startDate->format('Y-m-d'),
                        'end_date' => $endDate->format('Y-m-d'),
                        'status' => $faker->randomElement(['pending', 'approved', 'rejected']),
                    ]
                );
            }
        }

        $this->command->info('Leaves seeded successfully.');
    }
}

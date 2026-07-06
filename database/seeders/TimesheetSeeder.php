<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Timesheet;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class TimesheetSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();

        foreach ($branches as $branch) {
            $employees = Employee::where('branch_id', $branch->id)->get();

            foreach ($employees as $employee) {
                for ($week = 0; $week < 4; $week++) {
                    $periodStart = \Carbon\Carbon::now()->startOfWeek()->subWeeks($week);
                    $periodEnd = $periodStart->copy()->addDays(6);

                    Timesheet::firstOrCreate(
                        [
                            'employee_id' => $employee->id,
                            'period_start' => $periodStart->format('Y-m-d'),
                        ],
                        [
                            'uuid' => \Illuminate\Support\Str::uuid(),
                            'branch_id' => $branch->id,
                            'period_start' => $periodStart->format('Y-m-d'),
                            'period_end' => $periodEnd->format('Y-m-d'),
                            'regular_hours' => $faker->randomFloat(2, 30, 40),
                            'overtime_hours' => $faker->randomFloat(2, 0, 10),
                            'holiday_hours' => $faker->randomFloat(2, 0, 8),
                            'status' => $week === 0 ? 'pending' : 'approved',
                        ]
                    );
                }
            }
        }

        $this->command->info('Timesheets seeded successfully.');
    }
}

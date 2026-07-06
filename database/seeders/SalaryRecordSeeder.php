<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\SalaryRecord;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class SalaryRecordSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();

        foreach ($branches as $branch) {
            $employees = Employee::where('branch_id', $branch->id)->get();

            foreach ($employees as $employee) {
                for ($monthOffset = 0; $monthOffset < 3; $monthOffset++) {
                    $month = \Carbon\Carbon::now()->subMonths($monthOffset)->format('Y-m');
                    $hours = $faker->randomFloat(2, 120, 180);
                    $rate = $employee->hourly_rate ?? $faker->randomFloat(2, 11, 25);
                    $overtime = $faker->randomFloat(2, 0, 500);
                    $bonus = $faker->randomFloat(2, 0, 200);
                    $deduction = $faker->randomFloat(2, 0, 150);
                    $netSalary = ($hours * $rate) + $overtime + $bonus - $deduction;

                    SalaryRecord::firstOrCreate(
                        ['employee_id' => $employee->id, 'month' => $month],
                        [
                            'uuid' => \Illuminate\Support\Str::uuid(),
                            'branch_id' => $branch->id,
                            'working_hours' => $hours,
                            'hourly_rate' => $rate,
                            'overtime' => $overtime,
                            'bonus' => $bonus,
                            'deduction' => $deduction,
                            'net_salary' => $netSalary,
                            'status' => $monthOffset === 0 ? 'pending' : 'paid',
                        ]
                    );
                }
            }
        }

        $this->command->info('Salary records seeded successfully.');
    }
}

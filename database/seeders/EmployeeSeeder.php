<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();
        $employeeRole = \App\Models\Role::where('name', 'Employee')->first();
        $users = User::whereHas('roles', fn($q) => $q->where('roles.id', $employeeRole->id))->get();

        foreach ($users as $user) {
            $branch = $branches->random();
            $gender = $faker->randomElement(['male', 'female']);

            Employee::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'branch_id' => $user->branch_id ?? $branch->id,
                    'employee_no' => 'EMP' . str_pad((string) $user->id, 5, '0', STR_PAD_LEFT),
                    'first_name' => explode(' ', $user->name)[0],
                    'last_name' => explode(' ', $user->name)[1] ?? 'Staff',
                    'email' => $user->email,
                    'phone' => $user->phone ?? '07' . rand(100000000, 999999999),
                    'dob' => $faker->date('Y-m-d', '-25 years'),
                    'gender' => $gender,
                    'address' => $faker->address(),
                    'joining_date' => $faker->date('Y-m-d', '-1 years'),
                    'employment_type' => $faker->randomElement(['full_time', 'part_time', 'casual', 'contract']),
                    'hourly_rate' => $faker->randomFloat(2, 11, 25),
                    'salary_type' => $faker->randomElement(['hourly', 'salary', 'contract']),
                    'status' => 'active',
                    'emergency_contact_name' => $faker->name(),
                    'emergency_contact_phone' => '07' . rand(100000000, 999999999),
                ]
            );
        }

        foreach ($branches as $branch) {
            for ($i = 0; $i < 3; $i++) {
                $email = "extra.{$branch->code}.{$i}@example.com";
                if (!User::where('email', $email)->exists()) {
                    $gender = $faker->randomElement(['male', 'female']);
                    Employee::firstOrCreate(
                        ['employee_no' => "EMP-EXT-{$branch->id}-{$i}"],
                        [
                            'uuid' => \Illuminate\Support\Str::uuid(),
                            'branch_id' => $branch->id,
                            'first_name' => $faker->firstName($gender),
                            'last_name' => $faker->lastName(),
                            'email' => $email,
                            'phone' => '07' . rand(100000000, 999999999),
                            'dob' => $faker->date('Y-m-d', '-30 years'),
                            'gender' => $gender,
                            'address' => $faker->address(),
                            'joining_date' => $faker->date('Y-m-d', '-2 years'),
                            'employment_type' => $faker->randomElement(['full_time', 'part_time']),
                            'hourly_rate' => $faker->randomFloat(2, 12, 22),
                            'salary_type' => 'hourly',
                            'status' => 'active',
                            'emergency_contact_name' => $faker->name(),
                            'emergency_contact_phone' => '07' . rand(100000000, 999999999),
                        ]
                    );
                }
            }
        }

        $this->command->info('Employees seeded successfully.');
    }
}

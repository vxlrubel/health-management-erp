<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Employee;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();
        $employees = Employee::all();

        foreach ($branches as $branch) {
            for ($i = 0; $i < 5; $i++) {
                $gender = $faker->randomElement(['male', 'female']);
                $client = Client::firstOrCreate(
                    ['client_no' => "CLI-{$branch->code}-" . str_pad((string) ($i + 1), 3, '0', STR_PAD_LEFT)],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'branch_id' => $branch->id,
                        'first_name' => $faker->firstName($gender),
                        'last_name' => $faker->lastName(),
                        'dob' => $faker->date('Y-m-d', '-70 years'),
                        'email' => "client.{$branch->code}.{$i}@example.com",
                        'phone' => '07' . rand(100000000, 999999999),
                        'address' => $faker->address(),
                        'care_level' => $faker->randomElement(['low', 'medium', 'high', 'specialist']),
                        'status' => 'active',
                        'next_of_kin_name' => $faker->name(),
                        'next_of_kin_phone' => '07' . rand(100000000, 999999999),
                    ]
                );

                $branchEmployees = $employees->where('branch_id', $branch->id);
                if ($branchEmployees->count() > 0) {
                    $assignedEmployee = $branchEmployees->random();
                    $client->employees()->syncWithoutDetaching([
                        $assignedEmployee->id => [
                            'assigned_from' => now()->subMonths(rand(1, 6)),
                            'is_primary' => true,
                        ],
                    ]);
                }
            }
        }

        $this->command->info('Clients seeded successfully.');
    }
}

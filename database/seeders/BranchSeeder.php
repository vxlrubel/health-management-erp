<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['name' => 'Head Office', 'code' => 'HQ', 'city' => 'London', 'status' => 'active'],
            ['name' => 'Manchester Branch', 'code' => 'MAN', 'city' => 'Manchester', 'status' => 'active'],
            ['name' => 'Birmingham Branch', 'code' => 'BIR', 'city' => 'Birmingham', 'status' => 'active'],
            ['name' => 'Leeds Branch', 'code' => 'LDS', 'city' => 'Leeds', 'status' => 'active'],
        ];

        foreach ($branches as $data) {
            Branch::firstOrCreate(
                ['code' => $data['code']],
                [
                    'name' => $data['name'],
                    'description' => "{$data['name']} location",
                    'address' => "123 {$data['name']} Street",
                    'city' => $data['city'],
                    'postcode' => strtoupper(substr($data['city'], 0, 2)) . '1 1AA',
                    'phone' => '0' . rand(7000000000, 7999999999),
                    'email' => strtolower(str_replace(' ', '', $data['name'])) . '@example.com',
                    'status' => $data['status'],
                ]
            );
        }

        $this->command->info('Branches seeded successfully.');
    }
}

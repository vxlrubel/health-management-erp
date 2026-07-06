<?php

namespace Database\Seeders;

use App\Models\Funder;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class FunderSeeder extends Seeder
{
    public function run(): void
    {
        $funders = [
            ['name' => 'NHS England', 'email' => 'nhs.england@nhs.uk'],
            ['name' => 'Local Authority Social Care', 'email' => 'social.care@gov.uk'],
            ['name' => 'Private Health Insurance Co', 'email' => 'claims@phi.co.uk'],
            ['name' => 'Age Care Trust', 'email' => 'info@agecaretrust.org'],
            ['name' => 'Community Care Fund', 'email' => 'admin@communitycarefund.org'],
        ];

        foreach ($funders as $data) {
            Funder::firstOrCreate(
                ['email' => $data['email']],
                [
                    'uuid' => \Illuminate\Support\Str::uuid(),
                    'name' => $data['name'],
                    'phone' => '02' . rand(70000000, 79999999),
                    'address' => "{$data['name']} Office, London",
                    'status' => 'active',
                ]
            );
        }

        $this->command->info('Funders seeded successfully.');
    }
}

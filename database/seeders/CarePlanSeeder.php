<?php

namespace Database\Seeders;

use App\Models\CarePlan;
use App\Models\Client;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class CarePlanSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $clients = Client::all();

        foreach ($clients as $client) {
            if (rand(0, 1)) {
                CarePlan::firstOrCreate(
                    ['client_id' => $client->id, 'title' => "Care Plan for {$client->first_name} {$client->last_name}"],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'summary' => "Personalised care plan for {$client->first_name} covering daily support needs.",
                        'goals' => "1. Maintain independence\n2. Ensure medication compliance\n3. Monitor health condition",
                        'risks' => "1. Fall risk\n2. Medication side effects\n3. Mobility limitations",
                        'effective_from' => now()->subMonths(rand(1, 6)),
                        'effective_to' => now()->addMonths(rand(3, 12)),
                        'status' => 'active',
                    ]
                );
            }
        }

        $this->command->info('Care Plans seeded successfully.');
    }
}

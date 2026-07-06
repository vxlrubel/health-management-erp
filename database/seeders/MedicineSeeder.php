<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Medicine;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $clients = Client::all();

        $medications = [
            ['name' => 'Paracetamol', 'dosage' => '500mg', 'frequency' => 'As needed', 'route' => 'Oral'],
            ['name' => 'Ibuprofen', 'dosage' => '400mg', 'frequency' => 'Three times daily', 'route' => 'Oral'],
            ['name' => 'Omeprazole', 'dosage' => '20mg', 'frequency' => 'Once daily', 'route' => 'Oral'],
            ['name' => 'Aspirin', 'dosage' => '75mg', 'frequency' => 'Once daily', 'route' => 'Oral'],
            ['name' => 'Salbutamol', 'dosage' => '100mcg', 'frequency' => 'As needed', 'route' => 'Inhalation'],
            ['name' => 'Amlodipine', 'dosage' => '5mg', 'frequency' => 'Once daily', 'route' => 'Oral'],
            ['name' => 'Metformin', 'dosage' => '500mg', 'frequency' => 'Twice daily', 'route' => 'Oral'],
            ['name' => 'Warfarin', 'dosage' => '3mg', 'frequency' => 'Once daily', 'route' => 'Oral'],
        ];

        foreach ($clients as $client) {
            $numMeds = rand(1, 4);
            $selectedMeds = $faker->randomElements($medications, $numMeds);

            foreach ($selectedMeds as $med) {
                Medicine::firstOrCreate(
                    ['client_id' => $client->id, 'name' => $med['name']],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'dosage' => $med['dosage'],
                        'frequency' => $med['frequency'],
                        'route' => $med['route'],
                        'start_date' => $faker->date('Y-m-d', '-6 months'),
                        'end_date' => $faker->optional(0.3)->date('Y-m-d', '+6 months'),
                        'prescribed_by' => 'Dr. ' . $faker->lastName(),
                        'status' => 'active',
                    ]
                );
            }
        }

        $this->command->info('Medicines seeded successfully.');
    }
}

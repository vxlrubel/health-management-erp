<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Ratesheet;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RatesheetSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();

        foreach ($branches as $branch) {
            for ($i = 0; $i < 2; $i++) {
                $name = $faker->randomElement(['Standard Weekday', 'Weekend Premium', 'Night Shift', 'Holiday Premium', 'Bank Holiday']);
                Ratesheet::firstOrCreate(
                    ['name' => $name . ' - ' . $branch->code, 'branch_id' => $branch->id],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'description' => $faker->sentence(),
                        'hourly_rate' => $faker->randomFloat(2, 12, 35),
                        'weekend_rate' => $faker->randomFloat(2, 15, 45),
                        'holiday_rate' => $faker->randomFloat(2, 20, 55),
                        'night_rate' => $faker->randomFloat(2, 18, 50),
                        'status' => 'active',
                    ]
                );
            }
        }

        $this->command->info('Ratesheets seeded successfully.');
    }
}

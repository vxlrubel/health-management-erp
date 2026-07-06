<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Ratesheet;
use App\Models\Rota;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RotaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();
        $ratesheets = Ratesheet::all();

        foreach ($branches as $branch) {
            $branchRatesheets = $ratesheets->where('branch_id', $branch->id);
            $ratesheetId = $branchRatesheets->isNotEmpty() ? $branchRatesheets->random()->id : null;

            for ($i = 0; $i < 3; $i++) {
                $startDate = \Carbon\Carbon::now()->startOfWeek()->addWeeks($i);
                Rota::firstOrCreate(
                    ['name' => "Week {$i} - {$branch->code}", 'branch_id' => $branch->id, 'start_date' => $startDate->format('Y-m-d')],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'ratesheet_id' => $ratesheetId,
                        'start_date' => $startDate->format('Y-m-d'),
                        'end_date' => $startDate->copy()->addDays(6)->format('Y-m-d'),
                        'start_time' => $faker->randomElement(['07:00:00', '08:00:00', '09:00:00']),
                        'end_time' => $faker->randomElement(['19:00:00', '20:00:00', '21:00:00']),
                        'status' => $i === 0 ? 'active' : 'active',
                    ]
                );
            }
        }

        $this->command->info('Rotas seeded successfully.');
    }
}

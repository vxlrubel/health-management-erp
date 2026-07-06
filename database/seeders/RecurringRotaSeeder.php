<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\RecurringRota;
use App\Models\Rota;
use App\Models\ShiftTemplate;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class RecurringRotaSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();

        foreach ($branches as $branch) {
            $rotas = Rota::where('branch_id', $branch->id)->get();
            $templates = ShiftTemplate::where('branch_id', $branch->id)->get();

            if ($rotas->isEmpty() || $templates->isEmpty()) {
                continue;
            }

            for ($i = 0; $i < 2; $i++) {
                $startDate = \Carbon\Carbon::now()->startOfMonth();
                $endDate = $startDate->copy()->addMonths(3);

                RecurringRota::firstOrCreate(
                    [
                        'branch_id' => $branch->id,
                        'rota_id' => $rotas->random()->id,
                        'shift_template_id' => $templates->random()->id,
                        'frequency' => $faker->randomElement(['daily', 'weekly', 'biweekly']),
                    ],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'branch_id' => $branch->id,
                        'rota_id' => $rotas->random()->id,
                        'shift_template_id' => $templates->random()->id,
                        'frequency' => $faker->randomElement(['daily', 'weekly', 'biweekly']),
                        'days_of_week' => json_encode([1, 2, 3, 4, 5]),
                        'start_date' => $startDate->format('Y-m-d'),
                        'end_date' => $endDate->format('Y-m-d'),
                        'status' => 'active',
                    ]
                );
            }
        }

        $this->command->info('Recurring rotas seeded successfully.');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\ShiftTemplate;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ShiftTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();

        $shifts = [
            ['name' => 'Morning Shift', 'start_time' => '07:00:00', 'end_time' => '14:00:00', 'hours' => 7, 'break' => 30],
            ['name' => 'Afternoon Shift', 'start_time' => '14:00:00', 'end_time' => '21:00:00', 'hours' => 7, 'break' => 30],
            ['name' => 'Night Shift', 'start_time' => '21:00:00', 'end_time' => '07:00:00', 'hours' => 10, 'break' => 60],
            ['name' => 'Day Shift', 'start_time' => '08:00:00', 'end_time' => '18:00:00', 'hours' => 10, 'break' => 60],
            ['name' => 'Twilight Shift', 'start_time' => '17:00:00', 'end_time' => '22:00:00', 'hours' => 5, 'break' => 0],
        ];

        foreach ($branches as $branch) {
            foreach ($shifts as $shift) {
                ShiftTemplate::firstOrCreate(
                    ['name' => $shift['name'], 'branch_id' => $branch->id],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'start_time' => $shift['start_time'],
                        'end_time' => $shift['end_time'],
                        'planned_hours' => $shift['hours'],
                        'break_minutes' => $shift['break'],
                        'status' => 'active',
                    ]
                );
            }
        }

        $this->command->info('Shift templates seeded successfully.');
    }
}

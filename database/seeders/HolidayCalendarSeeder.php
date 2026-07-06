<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\HolidayCalendar;
use Illuminate\Database\Seeder;

class HolidayCalendarSeeder extends Seeder
{
    public function run(): void
    {
        $branches = Branch::all();

        $holidays = [
            ['name' => 'New Year\'s Day', 'date' => '2026-01-01', 'type' => 'public', 'paid' => true],
            ['name' => 'Good Friday', 'date' => '2026-04-03', 'type' => 'public', 'paid' => true],
            ['name' => 'Easter Monday', 'date' => '2026-04-06', 'type' => 'public', 'paid' => true],
            ['name' => 'Early May Bank Holiday', 'date' => '2026-05-04', 'type' => 'public', 'paid' => true],
            ['name' => 'Spring Bank Holiday', 'date' => '2026-05-25', 'type' => 'public', 'paid' => true],
            ['name' => 'Summer Bank Holiday', 'date' => '2026-08-31', 'type' => 'public', 'paid' => true],
            ['name' => 'Christmas Day', 'date' => '2026-12-25', 'type' => 'public', 'paid' => true],
            ['name' => 'Boxing Day', 'date' => '2026-12-26', 'type' => 'public', 'paid' => true],
        ];

        foreach ($branches as $branch) {
            foreach ($holidays as $holiday) {
                HolidayCalendar::firstOrCreate(
                    ['branch_id' => $branch->id, 'holiday_date' => $holiday['date'], 'type' => $holiday['type']],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'name' => $holiday['name'],
                        'is_paid' => $holiday['paid'],
                    ]
                );
            }
        }

        $this->command->info('Holiday calendar seeded successfully.');
    }
}

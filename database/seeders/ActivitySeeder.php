<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Branch;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Schedule;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();
        $schedules = Schedule::all();
        $activityTypes = ['personal_care', 'medication', 'meal_prep', 'companionship', 'domestic', 'transport', 'therapy', 'other'];

        foreach ($branches as $branch) {
            $employees = Employee::where('branch_id', $branch->id)->get();
            $clients = Client::where('branch_id', $branch->id)->get();
            $branchSchedules = $schedules->where('branch_id', $branch->id);

            foreach ($employees->take(5) as $employee) {
                $schedule = $branchSchedules->where('employee_id', $employee->id)->first();
                $client = $clients->isNotEmpty() ? $clients->random() : null;

                $startDate = \Carbon\Carbon::now()->startOfWeek()->addDays(rand(0, 6));
                $startDateTime = $startDate->copy()->setHour(rand(8, 16))->setMinute(0)->setSecond(0);
                $endDateTime = $startDateTime->copy()->addHours(rand(1, 4));

                Activity::firstOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'start_datetime' => $startDateTime->format('Y-m-d H:i:s'),
                        'activity_type' => $faker->randomElement($activityTypes),
                    ],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'schedule_id' => $schedule?->id,
                        'client_id' => $client?->id,
                        'branch_id' => $branch->id,
                        'activity_type' => $faker->randomElement($activityTypes),
                        'notes' => $faker->sentence(),
                        'start_datetime' => $startDateTime->format('Y-m-d H:i:s'),
                        'end_datetime' => $endDateTime->format('Y-m-d H:i:s'),
                        'actual_hours' => $startDateTime->diffInHours($endDateTime),
                        'status' => $faker->randomElement(['pending', 'approved', 'in_progress', 'completed']),
                    ]
                );
            }
        }

        $this->command->info('Activities seeded successfully.');
    }
}

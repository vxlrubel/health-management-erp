<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Rota;
use App\Models\Schedule;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $branches = Branch::all();
        $rotas = Rota::all();

        foreach ($branches as $branch) {
            $employees = Employee::where('branch_id', $branch->id)->get();
            $clients = Client::where('branch_id', $branch->id)->get();
            $branchRotas = $rotas->where('branch_id', $branch->id);

            foreach ($employees as $employee) {
                $rota = $branchRotas->isNotEmpty() ? $branchRotas->random() : null;
                $client = $clients->isNotEmpty() ? $clients->random() : null;

                $startDate = \Carbon\Carbon::now()->startOfWeek()->addDays(rand(0, 6));
                $startHour = $faker->randomElement([7, 8, 9, 14, 21]);
                $startDateTime = $startDate->copy()->setHour($startHour)->setMinute(0)->setSecond(0);
                $endDateTime = $startDateTime->copy()->addHours($faker->randomElement([6, 8, 10, 12]));

                Schedule::firstOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'start_datetime' => $startDateTime->format('Y-m-d H:i:s'),
                    ],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'rota_id' => $rota?->id,
                        'client_id' => $client?->id,
                        'branch_id' => $branch->id,
                        'start_datetime' => $startDateTime->format('Y-m-d H:i:s'),
                        'end_datetime' => $endDateTime->format('Y-m-d H:i:s'),
                        'planned_hours' => $startDateTime->diffInHours($endDateTime),
                        'status' => $faker->randomElement(['pending', 'running', 'completed']),
                    ]
                );
            }
        }

        $this->command->info('Schedules seeded successfully.');
    }
}

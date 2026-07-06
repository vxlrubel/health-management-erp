<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class FormSubmissionSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();
        $forms = Form::all();
        $employees = Employee::all();
        $users = User::all();

        foreach ($forms as $form) {
            $numSubmissions = rand(1, 3);
            for ($i = 0; $i < $numSubmissions; $i++) {
                $employee = $employees->random();
                $user = $users->random();

                FormSubmission::firstOrCreate(
                    [
                        'form_id' => $form->id,
                        'submitted_by' => $user->id,
                        'subject_type' => 'employee',
                        'subject_id' => $employee->id,
                    ],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'answers_json' => json_encode([
                            'field_1' => $faker->sentence(),
                            'field_2' => $faker->paragraph(),
                            'submitted_at' => now()->toDateTimeString(),
                        ]),
                        'status' => $faker->randomElement(['submitted', 'reviewed', 'approved']),
                        'submitted_at' => now()->subDays(rand(1, 30)),
                    ]
                );
            }
        }

        $this->command->info('Form submissions seeded successfully.');
    }
}

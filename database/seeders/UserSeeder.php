<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('name', 'Super Admin')->first();
        $branchManagerRole = Role::where('name', 'Branch Manager')->first();
        $employeeRole = Role::where('name', 'Employee')->first();

        $branches = Branch::all();

        $superAdmin = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'uuid' => \Illuminate\Support\Str::uuid(),
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'phone' => '07123456789',
                'status' => 'active',
                'email_verified_at' => now(),
            ]
        );
        $superAdmin->assignRole('Super Admin');
        $superAdmin->syncPermissions(\App\Models\Permission::all());

        $managerData = [
            ['name' => 'Alice Manager', 'email' => 'alice@example.com'],
            ['name' => 'Bob Manager', 'email' => 'bob@example.com'],
            ['name' => 'Carol Manager', 'email' => 'carol@example.com'],
        ];

        foreach ($branches as $i => $branch) {
            if (isset($managerData[$i])) {
                $manager = User::firstOrCreate(
                    ['email' => $managerData[$i]['email']],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'name' => $managerData[$i]['name'],
                        'branch_id' => $branch->id,
                        'password' => Hash::make('password'),
                        'phone' => '07' . rand(100000000, 999999999),
                        'status' => 'active',
                        'email_verified_at' => now(),
                    ]
                );
                $manager->assignRole('Branch Manager');
            }
        }

        $staffNames = [
            'David Worker', 'Eva Staff', 'Frank Carer', 'Grace Nurse',
            'Henry Aide', 'Irene Support', 'Jack Assistant', 'Katie Helper',
        ];

        foreach ($branches as $branch) {
            foreach ($staffNames as $name) {
                $email = strtolower(str_replace(' ', '.', $name)) . '.' . $branch->code . '@example.com';
                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'uuid' => \Illuminate\Support\Str::uuid(),
                        'name' => $name,
                        'branch_id' => $branch->id,
                        'password' => Hash::make('password'),
                        'phone' => '07' . rand(100000000, 999999999),
                        'status' => 'active',
                        'email_verified_at' => now(),
                    ]
                );
                $user->assignRole('Employee');
            }
        }

        $this->command->info('Users seeded successfully.');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        $branchManager = Role::firstOrCreate(['name' => 'Branch Manager', 'guard_name' => 'web']);
        $hrManager = Role::firstOrCreate(['name' => 'HR Manager', 'guard_name' => 'web']);
        $employee = Role::firstOrCreate(['name' => 'Employee', 'guard_name' => 'web']);
        $client = Role::firstOrCreate(['name' => 'Client', 'guard_name' => 'web']);
        $funder = Role::firstOrCreate(['name' => 'Funder', 'guard_name' => 'web']);

        $superAdmin->syncPermissions(Permission::all());

        $branchManager->syncPermissions(Permission::whereIn('name', [
            'dashboard.view',
            'employees.list', 'employees.create', 'employees.view', 'employees.update', 'employees.assign',
            'clients.list', 'clients.create', 'clients.view', 'clients.update',
            'schedules.list', 'schedules.create', 'schedules.view', 'schedules.update', 'schedules.approve',
            'activities.list', 'activities.create', 'activities.view', 'activities.update', 'activities.approve',
            'leaves.list', 'leaves.view', 'leaves.approve',
            'reports.list', 'reports.view',
            'funders.list', 'funders.view',
            'care-plans.list', 'care-plans.view',
        ])->get());

        $hrManager->syncPermissions(Permission::whereIn('name', [
            'dashboard.view',
            'employees.list', 'employees.create', 'employees.view', 'employees.update', 'employees.delete', 'employees.restore',
            'employee-documents.list', 'employee-documents.create', 'employee-documents.view', 'employee-documents.update',
            'timesheets.list', 'timesheets.view',
            'leaves.list', 'leaves.view', 'leaves.approve',
            'reports.list', 'reports.view',
        ])->get());

        $employeeRole = Permission::whereIn('name', [
            'employees.view',
            'schedules.list', 'schedules.view',
            'activities.list', 'activities.create', 'activities.view', 'activities.update',
            'timesheets.list', 'timesheets.view',
            'leaves.list', 'leaves.create', 'leaves.view',
            'messages.list', 'messages.create', 'messages.view',
        ])->get();

        $employee->syncPermissions($employeeRole);

        $this->command->info('Roles seeded successfully.');
    }
}

<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    private array $modulePermissions = [
        'dashboard' => ['view'],
        'users' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'roles' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'permissions' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'branches' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'employees' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export', 'assign'],
        'employee-documents' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'clients' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'care-plans' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'funders' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'ratesheets' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'rotas' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'shift-templates' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'recurring-rotas' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'holiday-calendar' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'schedules' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export', 'approve'],
        'activities' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export', 'approve'],
        'timesheets' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'leaves' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export', 'approve'],
        'forms' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export', 'assign'],
        'media' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'medicines' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'invoices' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'invoice-payments' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'salary' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'reports' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'export-center' => ['list', 'create', 'view', 'update', 'delete', 'export'],
        'messages' => ['list', 'create', 'view', 'update', 'delete', 'export'],
        'notifications' => ['list', 'create', 'view', 'update', 'delete'],
        'activity-logs' => ['list', 'create', 'view', 'update', 'delete', 'export'],
        'settings' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'system-configuration' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'trash' => ['list', 'create', 'view', 'update', 'delete', 'restore', 'force-delete', 'export'],
        'search' => ['list', 'view'],
        'bulk-actions' => ['list', 'create'],
    ];

    public function run(): void
    {
        foreach ($this->modulePermissions as $module => $actions) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}",
                    'guard_name' => 'web',
                ]);
            }
        }

        $this->command->info('Permissions seeded successfully.');
    }
}

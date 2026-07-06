<?php

namespace Database\Seeders;

use App\Enums\ActivityStatus;
use App\Enums\EmploymentType;
use App\Enums\FormStatus;
use App\Enums\GeneralStatus;
use App\Enums\InvoiceStatus;
use App\Enums\LeaveStatus;
use App\Enums\LeaveType;
use App\Enums\PaymentMethod;
use App\Enums\SalaryType;
use App\Enums\ScheduleStatus;
use App\Models\Activity;
use App\Models\Branch;
use App\Models\CarePlan;
use App\Models\Client;
use App\Models\Conversation;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\Form;
use App\Models\Funder;
use App\Models\HolidayCalendar;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Leave;
use App\Models\Medicine;
use App\Models\MedicineAdministration;
use App\Models\Message;
use App\Models\Permission;
use App\Models\Ratesheet;
use App\Models\RecurringRota;
use App\Models\Report;
use App\Models\Role;
use App\Models\Rota;
use App\Models\SalaryRecord;
use App\Models\Schedule;
use App\Models\Setting;
use App\Models\ShiftTemplate;
use App\Models\SystemConfiguration;
use App\Models\Timesheet;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
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
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        }

        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            EmployeeSeeder::class,
            ClientSeeder::class,
            FunderSeeder::class,
            CarePlanSeeder::class,

            // Payroll & Finance
            RatesheetSeeder::class,
            ShiftTemplateSeeder::class,
            RotaSeeder::class,
            RecurringRotaSeeder::class,
            HolidayCalendarSeeder::class,

            // Scheduling
            ScheduleSeeder::class,
            ActivitySeeder::class,
            TimesheetSeeder::class,
            LeaveSeeder::class,

            // Forms
            FormSeeder::class,
            FormSubmissionSeeder::class,

            // Invoicing
            InvoiceSeeder::class,
            InvoicePaymentSeeder::class,

            // HR
            EmployeeDocumentSeeder::class,
            SalaryRecordSeeder::class,

            // Medical
            MedicineSeeder::class,
            MedicineAdministrationSeeder::class,

            // Communication
            ConversationSeeder::class,

            // Reports & Settings
            ReportSeeder::class,
            SettingSeeder::class,
            SystemConfigurationSeeder::class,
        ]);

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}

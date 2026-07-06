# Service Layer

Services are the main location for business logic. They orchestrate validation results, repositories, policies, events, jobs and transactions.

## Rules

- One service per major module/model.
- Use transactions for all multi-table writes.
- Return models, DTOs or arrays; controllers transform results using resources.
- Services must not know about HTTP response formatting.
- Services may dispatch events and jobs.

## Example service shape

```php
final class EmployeeService
{
    public function __construct(
        private EmployeeRepositoryInterface $employees,
        private BranchRepositoryInterface $branches,
    ) {}

    public function create(array $data, User $actor): Employee
    {
        return DB::transaction(function () use ($data, $actor) {
            $employee = $this->employees->create([
                ...$data,
                'created_by' => $actor->id,
            ]);

            event(new EmployeeCreated($employee, $actor));

            return $employee;
        });
    }
}
```

## Required services

- `AuthService` for Authentication & Profile
- `DashboardService` for Dashboard
- `UsersService` for Users
- `RolesService` for Roles
- `PermissionsService` for Permissions
- `BranchesService` for Branches
- `EmployeesService` for Employees
- `EmployeeDocumentsService` for Employee Documents
- `ClientsService` for Clients
- `CarePlansService` for Care Plans
- `FundersService` for Funders
- `RatesheetsService` for Ratesheets
- `RotasService` for Rotas
- `ShiftTemplatesService` for Shift Templates
- `RecurringRotasService` for Recurring Rotas
- `HolidayCalendarService` for Holiday Calendar
- `SchedulesService` for Schedules
- `ActivitiesService` for Activities
- `TimesheetsService` for Timesheets
- `LeavesService` for Leaves
- `FormsService` for Forms
- `MediaService` for Media Manager
- `MedicinesService` for Medicine Management
- `InvoicesService` for Invoices
- `InvoicePaymentsService` for Invoice Payments
- `SalaryService` for Salary Management
- `ReportsService` for Reports
- `ExportCenterService` for Export Center
- `MessagesService` for Messages
- `NotificationsService` for Notifications
- `ActivityLogsService` for Activity Logs
- `SettingsService` for Settings
- `SystemConfigurationService` for System Configuration
- `TrashService` for Trash & Restore
- `SearchService` for Global Search
- `BulkActionsService` for Bulk Actions

## Transaction examples

| Operation | Transaction needed | Reason |
|---|---|---|
| Create employee with user account | Yes | Creates records in users/employees/roles. |
| Assign employee to client | Yes | Updates pivot, logs audit event and may notify staff. |
| Generate schedule from rota | Yes | Creates many schedules and activity placeholders. |
| Approve activity | Yes | Updates activity, may generate timesheet item. |
| Generate salary | Yes | Creates salary record and salary items. |
| Create invoice | Yes | Creates invoice and invoice items. |
| Record invoice payment | Yes | Updates payment and invoice status/balance. |

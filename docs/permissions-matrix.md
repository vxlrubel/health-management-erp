# Permissions Matrix

Authorization uses Laravel Policies plus Spatie Permission. Every endpoint must be protected by a permission and/or policy.

## Permission naming convention

Use this format:

```text
{module}.{action}
```

Examples:

```text
employees.view
employees.create
employees.update
employees.delete
employees.restore
employees.force-delete
employees.export
leaves.approve
clients.assign
```

## Common permission actions

- `view`
- `list`
- `create`
- `update`
- `delete`
- `restore`
- `force-delete`
- `export`
- `approve`
- `assign`

## Permission catalogue

| Module | Permissions |
|---|---|
| Authentication & Profile | `auth.view`, `auth.list`, `auth.create`, `auth.update`, `auth.delete`, `auth.restore`, `auth.force-delete`, `auth.export`, `auth.approve`, `auth.assign` |
| Dashboard | `dashboard.view`, `dashboard.list`, `dashboard.create`, `dashboard.update`, `dashboard.delete`, `dashboard.restore`, `dashboard.force-delete`, `dashboard.export`, `dashboard.approve`, `dashboard.assign` |
| Users | `users.view`, `users.list`, `users.create`, `users.update`, `users.delete`, `users.restore`, `users.force-delete`, `users.export`, `users.approve`, `users.assign` |
| Roles | `roles.view`, `roles.list`, `roles.create`, `roles.update`, `roles.delete`, `roles.restore`, `roles.force-delete`, `roles.export`, `roles.approve`, `roles.assign` |
| Permissions | `permissions.view`, `permissions.list`, `permissions.create`, `permissions.update`, `permissions.delete`, `permissions.restore`, `permissions.force-delete`, `permissions.export`, `permissions.approve`, `permissions.assign` |
| Branches | `branches.view`, `branches.list`, `branches.create`, `branches.update`, `branches.delete`, `branches.restore`, `branches.force-delete`, `branches.export`, `branches.approve`, `branches.assign` |
| Employees | `employees.view`, `employees.list`, `employees.create`, `employees.update`, `employees.delete`, `employees.restore`, `employees.force-delete`, `employees.export`, `employees.approve`, `employees.assign` |
| Employee Documents | `employee-documents.view`, `employee-documents.list`, `employee-documents.create`, `employee-documents.update`, `employee-documents.delete`, `employee-documents.restore`, `employee-documents.force-delete`, `employee-documents.export`, `employee-documents.approve`, `employee-documents.assign` |
| Clients | `clients.view`, `clients.list`, `clients.create`, `clients.update`, `clients.delete`, `clients.restore`, `clients.force-delete`, `clients.export`, `clients.approve`, `clients.assign` |
| Care Plans | `care-plans.view`, `care-plans.list`, `care-plans.create`, `care-plans.update`, `care-plans.delete`, `care-plans.restore`, `care-plans.force-delete`, `care-plans.export`, `care-plans.approve`, `care-plans.assign` |
| Funders | `funders.view`, `funders.list`, `funders.create`, `funders.update`, `funders.delete`, `funders.restore`, `funders.force-delete`, `funders.export`, `funders.approve`, `funders.assign` |
| Ratesheets | `ratesheets.view`, `ratesheets.list`, `ratesheets.create`, `ratesheets.update`, `ratesheets.delete`, `ratesheets.restore`, `ratesheets.force-delete`, `ratesheets.export`, `ratesheets.approve`, `ratesheets.assign` |
| Rotas | `rotas.view`, `rotas.list`, `rotas.create`, `rotas.update`, `rotas.delete`, `rotas.restore`, `rotas.force-delete`, `rotas.export`, `rotas.approve`, `rotas.assign` |
| Shift Templates | `shift-templates.view`, `shift-templates.list`, `shift-templates.create`, `shift-templates.update`, `shift-templates.delete`, `shift-templates.restore`, `shift-templates.force-delete`, `shift-templates.export`, `shift-templates.approve`, `shift-templates.assign` |
| Recurring Rotas | `recurring-rotas.view`, `recurring-rotas.list`, `recurring-rotas.create`, `recurring-rotas.update`, `recurring-rotas.delete`, `recurring-rotas.restore`, `recurring-rotas.force-delete`, `recurring-rotas.export`, `recurring-rotas.approve`, `recurring-rotas.assign` |
| Holiday Calendar | `holiday-calendar.view`, `holiday-calendar.list`, `holiday-calendar.create`, `holiday-calendar.update`, `holiday-calendar.delete`, `holiday-calendar.restore`, `holiday-calendar.force-delete`, `holiday-calendar.export`, `holiday-calendar.approve`, `holiday-calendar.assign` |
| Schedules | `schedules.view`, `schedules.list`, `schedules.create`, `schedules.update`, `schedules.delete`, `schedules.restore`, `schedules.force-delete`, `schedules.export`, `schedules.approve`, `schedules.assign` |
| Activities | `activities.view`, `activities.list`, `activities.create`, `activities.update`, `activities.delete`, `activities.restore`, `activities.force-delete`, `activities.export`, `activities.approve`, `activities.assign` |
| Timesheets | `timesheets.view`, `timesheets.list`, `timesheets.create`, `timesheets.update`, `timesheets.delete`, `timesheets.restore`, `timesheets.force-delete`, `timesheets.export`, `timesheets.approve`, `timesheets.assign` |
| Leaves | `leaves.view`, `leaves.list`, `leaves.create`, `leaves.update`, `leaves.delete`, `leaves.restore`, `leaves.force-delete`, `leaves.export`, `leaves.approve`, `leaves.assign` |
| Forms | `forms.view`, `forms.list`, `forms.create`, `forms.update`, `forms.delete`, `forms.restore`, `forms.force-delete`, `forms.export`, `forms.approve`, `forms.assign` |
| Media Manager | `media.view`, `media.list`, `media.create`, `media.update`, `media.delete`, `media.restore`, `media.force-delete`, `media.export`, `media.approve`, `media.assign` |
| Medicine Management | `medicines.view`, `medicines.list`, `medicines.create`, `medicines.update`, `medicines.delete`, `medicines.restore`, `medicines.force-delete`, `medicines.export`, `medicines.approve`, `medicines.assign` |
| Invoices | `invoices.view`, `invoices.list`, `invoices.create`, `invoices.update`, `invoices.delete`, `invoices.restore`, `invoices.force-delete`, `invoices.export`, `invoices.approve`, `invoices.assign` |
| Invoice Payments | `invoice-payments.view`, `invoice-payments.list`, `invoice-payments.create`, `invoice-payments.update`, `invoice-payments.delete`, `invoice-payments.restore`, `invoice-payments.force-delete`, `invoice-payments.export`, `invoice-payments.approve`, `invoice-payments.assign` |
| Salary Management | `salary.view`, `salary.list`, `salary.create`, `salary.update`, `salary.delete`, `salary.restore`, `salary.force-delete`, `salary.export`, `salary.approve`, `salary.assign` |
| Reports | `reports.view`, `reports.list`, `reports.create`, `reports.update`, `reports.delete`, `reports.restore`, `reports.force-delete`, `reports.export`, `reports.approve`, `reports.assign` |
| Export Center | `export-center.view`, `export-center.list`, `export-center.create`, `export-center.update`, `export-center.delete`, `export-center.restore`, `export-center.force-delete`, `export-center.export`, `export-center.approve`, `export-center.assign` |
| Messages | `messages.view`, `messages.list`, `messages.create`, `messages.update`, `messages.delete`, `messages.restore`, `messages.force-delete`, `messages.export`, `messages.approve`, `messages.assign` |
| Notifications | `notifications.view`, `notifications.list`, `notifications.create`, `notifications.update`, `notifications.delete`, `notifications.restore`, `notifications.force-delete`, `notifications.export`, `notifications.approve`, `notifications.assign` |
| Activity Logs | `activity-logs.view`, `activity-logs.list`, `activity-logs.create`, `activity-logs.update`, `activity-logs.delete`, `activity-logs.restore`, `activity-logs.force-delete`, `activity-logs.export`, `activity-logs.approve`, `activity-logs.assign` |
| Settings | `settings.view`, `settings.list`, `settings.create`, `settings.update`, `settings.delete`, `settings.restore`, `settings.force-delete`, `settings.export`, `settings.approve`, `settings.assign` |
| System Configuration | `system-configuration.view`, `system-configuration.list`, `system-configuration.create`, `system-configuration.update`, `system-configuration.delete`, `system-configuration.restore`, `system-configuration.force-delete`, `system-configuration.export`, `system-configuration.approve`, `system-configuration.assign` |
| Trash & Restore | `trash.view`, `trash.list`, `trash.create`, `trash.update`, `trash.delete`, `trash.restore`, `trash.force-delete`, `trash.export`, `trash.approve`, `trash.assign` |
| Global Search | `search.view`, `search.list`, `search.create`, `search.update`, `search.delete`, `search.restore`, `search.force-delete`, `search.export`, `search.approve`, `search.assign` |
| Bulk Actions | `bulk-actions.view`, `bulk-actions.list`, `bulk-actions.create`, `bulk-actions.update`, `bulk-actions.delete`, `bulk-actions.restore`, `bulk-actions.force-delete`, `bulk-actions.export`, `bulk-actions.approve`, `bulk-actions.assign` |

## Role matrix

| Module | Super Admin | Admin | Branch Manager | HR | Employee | Client | Funder |
|---|---|---|---|---|---|---|---|
| Authentication & Profile | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Dashboard | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Users | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Roles | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Permissions | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Branches | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Employees | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Employee Documents | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Clients | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Care Plans | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Funders | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Ratesheets | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Rotas | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Shift Templates | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Recurring Rotas | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Holiday Calendar | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Schedules | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Activities | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Timesheets | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Leaves | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Forms | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Media Manager | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Medicine Management | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Invoices | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Invoice Payments | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Salary Management | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Reports | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Export Center | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Messages | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Notifications | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Activity Logs | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Settings | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| System Configuration | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Trash & Restore | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Global Search | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |
| Bulk Actions | All | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, delete, restore, export, approve, assign | view, list, create, update, export, approve, assign | view, list, create | view, list | view, list, export |

## Branch isolation in policies

Policies must combine permission and ownership checks.

Example rules:

- User must have the relevant permission.
- If the user is not Super Admin, the model `branch_id` must be in the user's accessible branch IDs.
- Employees may view their own employee-linked data even without broad branch permissions.
- Clients may view their own client-linked data only.
- Funders may view funded client and invoice data only.

## Policy methods required

Every resource policy should implement:

- `viewAny(User $user)`
- `view(User $user, Model $model)`
- `create(User $user)`
- `update(User $user, Model $model)`
- `delete(User $user, Model $model)`
- `restore(User $user, Model $model)`
- `forceDelete(User $user, Model $model)`
- `export(User $user)`
- Custom methods such as `approve`, `assign`, `generate`, `publish` where applicable.

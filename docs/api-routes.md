# API Routes

Base URL: `/api/v1`

All secured routes require a Sanctum bearer token and the relevant permission/policy. Routes should be grouped by module in `routes/api_v1.php` or split into module route files loaded from `routes/api.php`.

## Authentication

| Method | Endpoint | Auth | Description |
|---|---|---|---|
| POST | `/api/v1/login` | Public | Login and create token. |
| POST | `/api/v1/logout` | Auth | Revoke current token. |
| POST | `/api/v1/forgot-password` | Public | Send reset link/OTP. |
| POST | `/api/v1/reset-password` | Public | Reset password. |
| GET | `/api/v1/profile` | Auth | View current user profile. |
| PUT | `/api/v1/profile` | Auth | Update current user profile. |
| PUT | `/api/v1/change-password` | Auth | Change current user password. |
| POST | `/api/v1/refresh-token` | Auth | Refresh/reissue API token if enabled. |

## Dashboard

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/dashboard` | `dashboard.view` | Dashboard overview. |
| GET | `/api/v1/dashboard/statistics` | `dashboard.view` | KPI statistics. |
| GET | `/api/v1/dashboard/charts` | `dashboard.view` | Chart data. |
| GET | `/api/v1/dashboard/recent-activities` | `dashboard.view` | Recent activity feed. |
| GET | `/api/v1/dashboard/today-schedule` | `dashboard.view` | Today's schedules. |
| GET | `/api/v1/dashboard/revenue` | `dashboard.view` | Revenue summary. |
| GET | `/api/v1/dashboard/salary` | `dashboard.view` | Salary/payroll summary. |


## Users

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/users` | `users.list` | List users with pagination, search, filters and sorting. |
| POST | `/api/v1/users` | `users.create` | Create users. |
| GET | `/api/v1/users/{uuid}` | `users.view` | View one users. |
| PUT/PATCH | `/api/v1/users/{uuid}` | `users.update` | Update one users. |
| DELETE | `/api/v1/users/{uuid}` | `users.delete` | Soft delete one users. |
| GET | `/api/v1/users/trash` | `users.list` | List soft-deleted users. |
| POST | `/api/v1/users/{uuid}/restore` | `users.restore` | Restore soft-deleted users. |
| DELETE | `/api/v1/users/{uuid}/force` | `users.force-delete` | Permanently delete users. |
| POST | `/api/v1/users/bulk-delete` | `users.delete` | Bulk soft delete users. |
| POST | `/api/v1/users/bulk-restore` | `users.restore` | Bulk restore users. |
| GET | `/api/v1/users/export` | `users.export` | Export users to CSV/Excel/PDF where supported. |

## Roles

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/roles` | `roles.list` | List roles with pagination, search, filters and sorting. |
| POST | `/api/v1/roles` | `roles.create` | Create roles. |
| GET | `/api/v1/roles/{uuid}` | `roles.view` | View one roles. |
| PUT/PATCH | `/api/v1/roles/{uuid}` | `roles.update` | Update one roles. |
| DELETE | `/api/v1/roles/{uuid}` | `roles.delete` | Soft delete one roles. |
| GET | `/api/v1/roles/trash` | `roles.list` | List soft-deleted roles. |
| POST | `/api/v1/roles/{uuid}/restore` | `roles.restore` | Restore soft-deleted roles. |
| DELETE | `/api/v1/roles/{uuid}/force` | `roles.force-delete` | Permanently delete roles. |
| POST | `/api/v1/roles/bulk-delete` | `roles.delete` | Bulk soft delete roles. |
| POST | `/api/v1/roles/bulk-restore` | `roles.restore` | Bulk restore roles. |
| GET | `/api/v1/roles/export` | `roles.export` | Export roles to CSV/Excel/PDF where supported. |

## Permissions

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/permissions` | `permissions.list` | List permissions with pagination, search, filters and sorting. |
| POST | `/api/v1/permissions` | `permissions.create` | Create permissions. |
| GET | `/api/v1/permissions/{uuid}` | `permissions.view` | View one permissions. |
| PUT/PATCH | `/api/v1/permissions/{uuid}` | `permissions.update` | Update one permissions. |
| DELETE | `/api/v1/permissions/{uuid}` | `permissions.delete` | Soft delete one permissions. |
| GET | `/api/v1/permissions/trash` | `permissions.list` | List soft-deleted permissions. |
| POST | `/api/v1/permissions/{uuid}/restore` | `permissions.restore` | Restore soft-deleted permissions. |
| DELETE | `/api/v1/permissions/{uuid}/force` | `permissions.force-delete` | Permanently delete permissions. |
| POST | `/api/v1/permissions/bulk-delete` | `permissions.delete` | Bulk soft delete permissions. |
| POST | `/api/v1/permissions/bulk-restore` | `permissions.restore` | Bulk restore permissions. |
| GET | `/api/v1/permissions/export` | `permissions.export` | Export permissions to CSV/Excel/PDF where supported. |

## Branches

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/branches` | `branches.list` | List branches with pagination, search, filters and sorting. |
| POST | `/api/v1/branches` | `branches.create` | Create branches. |
| GET | `/api/v1/branches/{uuid}` | `branches.view` | View one branches. |
| PUT/PATCH | `/api/v1/branches/{uuid}` | `branches.update` | Update one branches. |
| DELETE | `/api/v1/branches/{uuid}` | `branches.delete` | Soft delete one branches. |
| GET | `/api/v1/branches/trash` | `branches.list` | List soft-deleted branches. |
| POST | `/api/v1/branches/{uuid}/restore` | `branches.restore` | Restore soft-deleted branches. |
| DELETE | `/api/v1/branches/{uuid}/force` | `branches.force-delete` | Permanently delete branches. |
| POST | `/api/v1/branches/bulk-delete` | `branches.delete` | Bulk soft delete branches. |
| POST | `/api/v1/branches/bulk-restore` | `branches.restore` | Bulk restore branches. |
| GET | `/api/v1/branches/export` | `branches.export` | Export branches to CSV/Excel/PDF where supported. |

## Employees

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/employees` | `employees.list` | List employees with pagination, search, filters and sorting. |
| POST | `/api/v1/employees` | `employees.create` | Create employees. |
| GET | `/api/v1/employees/{uuid}` | `employees.view` | View one employees. |
| PUT/PATCH | `/api/v1/employees/{uuid}` | `employees.update` | Update one employees. |
| DELETE | `/api/v1/employees/{uuid}` | `employees.delete` | Soft delete one employees. |
| GET | `/api/v1/employees/trash` | `employees.list` | List soft-deleted employees. |
| POST | `/api/v1/employees/{uuid}/restore` | `employees.restore` | Restore soft-deleted employees. |
| DELETE | `/api/v1/employees/{uuid}/force` | `employees.force-delete` | Permanently delete employees. |
| POST | `/api/v1/employees/bulk-delete` | `employees.delete` | Bulk soft delete employees. |
| POST | `/api/v1/employees/bulk-restore` | `employees.restore` | Bulk restore employees. |
| GET | `/api/v1/employees/export` | `employees.export` | Export employees to CSV/Excel/PDF where supported. |

## Employee Documents

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/employee-documents` | `employee-documents.list` | List employee documents with pagination, search, filters and sorting. |
| POST | `/api/v1/employee-documents` | `employee-documents.create` | Create employee documents. |
| GET | `/api/v1/employee-documents/{uuid}` | `employee-documents.view` | View one employee documents. |
| PUT/PATCH | `/api/v1/employee-documents/{uuid}` | `employee-documents.update` | Update one employee documents. |
| DELETE | `/api/v1/employee-documents/{uuid}` | `employee-documents.delete` | Soft delete one employee documents. |
| GET | `/api/v1/employee-documents/trash` | `employee-documents.list` | List soft-deleted employee documents. |
| POST | `/api/v1/employee-documents/{uuid}/restore` | `employee-documents.restore` | Restore soft-deleted employee documents. |
| DELETE | `/api/v1/employee-documents/{uuid}/force` | `employee-documents.force-delete` | Permanently delete employee documents. |
| POST | `/api/v1/employee-documents/bulk-delete` | `employee-documents.delete` | Bulk soft delete employee documents. |
| POST | `/api/v1/employee-documents/bulk-restore` | `employee-documents.restore` | Bulk restore employee documents. |
| GET | `/api/v1/employee-documents/export` | `employee-documents.export` | Export employee documents to CSV/Excel/PDF where supported. |

## Clients

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/clients` | `clients.list` | List clients with pagination, search, filters and sorting. |
| POST | `/api/v1/clients` | `clients.create` | Create clients. |
| GET | `/api/v1/clients/{uuid}` | `clients.view` | View one clients. |
| PUT/PATCH | `/api/v1/clients/{uuid}` | `clients.update` | Update one clients. |
| DELETE | `/api/v1/clients/{uuid}` | `clients.delete` | Soft delete one clients. |
| GET | `/api/v1/clients/trash` | `clients.list` | List soft-deleted clients. |
| POST | `/api/v1/clients/{uuid}/restore` | `clients.restore` | Restore soft-deleted clients. |
| DELETE | `/api/v1/clients/{uuid}/force` | `clients.force-delete` | Permanently delete clients. |
| POST | `/api/v1/clients/bulk-delete` | `clients.delete` | Bulk soft delete clients. |
| POST | `/api/v1/clients/bulk-restore` | `clients.restore` | Bulk restore clients. |
| GET | `/api/v1/clients/export` | `clients.export` | Export clients to CSV/Excel/PDF where supported. |

## Care Plans

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/care-plans` | `care-plans.list` | List care plans with pagination, search, filters and sorting. |
| POST | `/api/v1/care-plans` | `care-plans.create` | Create care plans. |
| GET | `/api/v1/care-plans/{uuid}` | `care-plans.view` | View one care plans. |
| PUT/PATCH | `/api/v1/care-plans/{uuid}` | `care-plans.update` | Update one care plans. |
| DELETE | `/api/v1/care-plans/{uuid}` | `care-plans.delete` | Soft delete one care plans. |
| GET | `/api/v1/care-plans/trash` | `care-plans.list` | List soft-deleted care plans. |
| POST | `/api/v1/care-plans/{uuid}/restore` | `care-plans.restore` | Restore soft-deleted care plans. |
| DELETE | `/api/v1/care-plans/{uuid}/force` | `care-plans.force-delete` | Permanently delete care plans. |
| POST | `/api/v1/care-plans/bulk-delete` | `care-plans.delete` | Bulk soft delete care plans. |
| POST | `/api/v1/care-plans/bulk-restore` | `care-plans.restore` | Bulk restore care plans. |
| GET | `/api/v1/care-plans/export` | `care-plans.export` | Export care plans to CSV/Excel/PDF where supported. |

## Funders

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/funders` | `funders.list` | List funders with pagination, search, filters and sorting. |
| POST | `/api/v1/funders` | `funders.create` | Create funders. |
| GET | `/api/v1/funders/{uuid}` | `funders.view` | View one funders. |
| PUT/PATCH | `/api/v1/funders/{uuid}` | `funders.update` | Update one funders. |
| DELETE | `/api/v1/funders/{uuid}` | `funders.delete` | Soft delete one funders. |
| GET | `/api/v1/funders/trash` | `funders.list` | List soft-deleted funders. |
| POST | `/api/v1/funders/{uuid}/restore` | `funders.restore` | Restore soft-deleted funders. |
| DELETE | `/api/v1/funders/{uuid}/force` | `funders.force-delete` | Permanently delete funders. |
| POST | `/api/v1/funders/bulk-delete` | `funders.delete` | Bulk soft delete funders. |
| POST | `/api/v1/funders/bulk-restore` | `funders.restore` | Bulk restore funders. |
| GET | `/api/v1/funders/export` | `funders.export` | Export funders to CSV/Excel/PDF where supported. |

## Ratesheets

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/ratesheets` | `ratesheets.list` | List ratesheets with pagination, search, filters and sorting. |
| POST | `/api/v1/ratesheets` | `ratesheets.create` | Create ratesheets. |
| GET | `/api/v1/ratesheets/{uuid}` | `ratesheets.view` | View one ratesheets. |
| PUT/PATCH | `/api/v1/ratesheets/{uuid}` | `ratesheets.update` | Update one ratesheets. |
| DELETE | `/api/v1/ratesheets/{uuid}` | `ratesheets.delete` | Soft delete one ratesheets. |
| GET | `/api/v1/ratesheets/trash` | `ratesheets.list` | List soft-deleted ratesheets. |
| POST | `/api/v1/ratesheets/{uuid}/restore` | `ratesheets.restore` | Restore soft-deleted ratesheets. |
| DELETE | `/api/v1/ratesheets/{uuid}/force` | `ratesheets.force-delete` | Permanently delete ratesheets. |
| POST | `/api/v1/ratesheets/bulk-delete` | `ratesheets.delete` | Bulk soft delete ratesheets. |
| POST | `/api/v1/ratesheets/bulk-restore` | `ratesheets.restore` | Bulk restore ratesheets. |
| GET | `/api/v1/ratesheets/export` | `ratesheets.export` | Export ratesheets to CSV/Excel/PDF where supported. |

## Rotas

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/rotas` | `rotas.list` | List rotas with pagination, search, filters and sorting. |
| POST | `/api/v1/rotas` | `rotas.create` | Create rotas. |
| GET | `/api/v1/rotas/{uuid}` | `rotas.view` | View one rotas. |
| PUT/PATCH | `/api/v1/rotas/{uuid}` | `rotas.update` | Update one rotas. |
| DELETE | `/api/v1/rotas/{uuid}` | `rotas.delete` | Soft delete one rotas. |
| GET | `/api/v1/rotas/trash` | `rotas.list` | List soft-deleted rotas. |
| POST | `/api/v1/rotas/{uuid}/restore` | `rotas.restore` | Restore soft-deleted rotas. |
| DELETE | `/api/v1/rotas/{uuid}/force` | `rotas.force-delete` | Permanently delete rotas. |
| POST | `/api/v1/rotas/bulk-delete` | `rotas.delete` | Bulk soft delete rotas. |
| POST | `/api/v1/rotas/bulk-restore` | `rotas.restore` | Bulk restore rotas. |
| GET | `/api/v1/rotas/export` | `rotas.export` | Export rotas to CSV/Excel/PDF where supported. |

## Shift Templates

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/shift-templates` | `shift-templates.list` | List shift templates with pagination, search, filters and sorting. |
| POST | `/api/v1/shift-templates` | `shift-templates.create` | Create shift templates. |
| GET | `/api/v1/shift-templates/{uuid}` | `shift-templates.view` | View one shift templates. |
| PUT/PATCH | `/api/v1/shift-templates/{uuid}` | `shift-templates.update` | Update one shift templates. |
| DELETE | `/api/v1/shift-templates/{uuid}` | `shift-templates.delete` | Soft delete one shift templates. |
| GET | `/api/v1/shift-templates/trash` | `shift-templates.list` | List soft-deleted shift templates. |
| POST | `/api/v1/shift-templates/{uuid}/restore` | `shift-templates.restore` | Restore soft-deleted shift templates. |
| DELETE | `/api/v1/shift-templates/{uuid}/force` | `shift-templates.force-delete` | Permanently delete shift templates. |
| POST | `/api/v1/shift-templates/bulk-delete` | `shift-templates.delete` | Bulk soft delete shift templates. |
| POST | `/api/v1/shift-templates/bulk-restore` | `shift-templates.restore` | Bulk restore shift templates. |
| GET | `/api/v1/shift-templates/export` | `shift-templates.export` | Export shift templates to CSV/Excel/PDF where supported. |

## Recurring Rotas

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/recurring-rotas` | `recurring-rotas.list` | List recurring rotas with pagination, search, filters and sorting. |
| POST | `/api/v1/recurring-rotas` | `recurring-rotas.create` | Create recurring rotas. |
| GET | `/api/v1/recurring-rotas/{uuid}` | `recurring-rotas.view` | View one recurring rotas. |
| PUT/PATCH | `/api/v1/recurring-rotas/{uuid}` | `recurring-rotas.update` | Update one recurring rotas. |
| DELETE | `/api/v1/recurring-rotas/{uuid}` | `recurring-rotas.delete` | Soft delete one recurring rotas. |
| GET | `/api/v1/recurring-rotas/trash` | `recurring-rotas.list` | List soft-deleted recurring rotas. |
| POST | `/api/v1/recurring-rotas/{uuid}/restore` | `recurring-rotas.restore` | Restore soft-deleted recurring rotas. |
| DELETE | `/api/v1/recurring-rotas/{uuid}/force` | `recurring-rotas.force-delete` | Permanently delete recurring rotas. |
| POST | `/api/v1/recurring-rotas/bulk-delete` | `recurring-rotas.delete` | Bulk soft delete recurring rotas. |
| POST | `/api/v1/recurring-rotas/bulk-restore` | `recurring-rotas.restore` | Bulk restore recurring rotas. |
| GET | `/api/v1/recurring-rotas/export` | `recurring-rotas.export` | Export recurring rotas to CSV/Excel/PDF where supported. |

## Holiday Calendar

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/holiday-calendar` | `holiday-calendar.list` | List holiday calendar with pagination, search, filters and sorting. |
| POST | `/api/v1/holiday-calendar` | `holiday-calendar.create` | Create holiday calendar. |
| GET | `/api/v1/holiday-calendar/{uuid}` | `holiday-calendar.view` | View one holiday calendar. |
| PUT/PATCH | `/api/v1/holiday-calendar/{uuid}` | `holiday-calendar.update` | Update one holiday calendar. |
| DELETE | `/api/v1/holiday-calendar/{uuid}` | `holiday-calendar.delete` | Soft delete one holiday calendar. |
| GET | `/api/v1/holiday-calendar/trash` | `holiday-calendar.list` | List soft-deleted holiday calendar. |
| POST | `/api/v1/holiday-calendar/{uuid}/restore` | `holiday-calendar.restore` | Restore soft-deleted holiday calendar. |
| DELETE | `/api/v1/holiday-calendar/{uuid}/force` | `holiday-calendar.force-delete` | Permanently delete holiday calendar. |
| POST | `/api/v1/holiday-calendar/bulk-delete` | `holiday-calendar.delete` | Bulk soft delete holiday calendar. |
| POST | `/api/v1/holiday-calendar/bulk-restore` | `holiday-calendar.restore` | Bulk restore holiday calendar. |
| GET | `/api/v1/holiday-calendar/export` | `holiday-calendar.export` | Export holiday calendar to CSV/Excel/PDF where supported. |

## Schedules

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/schedules` | `schedules.list` | List schedules with pagination, search, filters and sorting. |
| POST | `/api/v1/schedules` | `schedules.create` | Create schedules. |
| GET | `/api/v1/schedules/{uuid}` | `schedules.view` | View one schedules. |
| PUT/PATCH | `/api/v1/schedules/{uuid}` | `schedules.update` | Update one schedules. |
| DELETE | `/api/v1/schedules/{uuid}` | `schedules.delete` | Soft delete one schedules. |
| GET | `/api/v1/schedules/trash` | `schedules.list` | List soft-deleted schedules. |
| POST | `/api/v1/schedules/{uuid}/restore` | `schedules.restore` | Restore soft-deleted schedules. |
| DELETE | `/api/v1/schedules/{uuid}/force` | `schedules.force-delete` | Permanently delete schedules. |
| POST | `/api/v1/schedules/bulk-delete` | `schedules.delete` | Bulk soft delete schedules. |
| POST | `/api/v1/schedules/bulk-restore` | `schedules.restore` | Bulk restore schedules. |
| GET | `/api/v1/schedules/export` | `schedules.export` | Export schedules to CSV/Excel/PDF where supported. |

## Activities

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/activities` | `activities.list` | List activities with pagination, search, filters and sorting. |
| POST | `/api/v1/activities` | `activities.create` | Create activities. |
| GET | `/api/v1/activities/{uuid}` | `activities.view` | View one activities. |
| PUT/PATCH | `/api/v1/activities/{uuid}` | `activities.update` | Update one activities. |
| DELETE | `/api/v1/activities/{uuid}` | `activities.delete` | Soft delete one activities. |
| GET | `/api/v1/activities/trash` | `activities.list` | List soft-deleted activities. |
| POST | `/api/v1/activities/{uuid}/restore` | `activities.restore` | Restore soft-deleted activities. |
| DELETE | `/api/v1/activities/{uuid}/force` | `activities.force-delete` | Permanently delete activities. |
| POST | `/api/v1/activities/bulk-delete` | `activities.delete` | Bulk soft delete activities. |
| POST | `/api/v1/activities/bulk-restore` | `activities.restore` | Bulk restore activities. |
| GET | `/api/v1/activities/export` | `activities.export` | Export activities to CSV/Excel/PDF where supported. |

## Timesheets

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/timesheets` | `timesheets.list` | List timesheets with pagination, search, filters and sorting. |
| POST | `/api/v1/timesheets` | `timesheets.create` | Create timesheets. |
| GET | `/api/v1/timesheets/{uuid}` | `timesheets.view` | View one timesheets. |
| PUT/PATCH | `/api/v1/timesheets/{uuid}` | `timesheets.update` | Update one timesheets. |
| DELETE | `/api/v1/timesheets/{uuid}` | `timesheets.delete` | Soft delete one timesheets. |
| GET | `/api/v1/timesheets/trash` | `timesheets.list` | List soft-deleted timesheets. |
| POST | `/api/v1/timesheets/{uuid}/restore` | `timesheets.restore` | Restore soft-deleted timesheets. |
| DELETE | `/api/v1/timesheets/{uuid}/force` | `timesheets.force-delete` | Permanently delete timesheets. |
| POST | `/api/v1/timesheets/bulk-delete` | `timesheets.delete` | Bulk soft delete timesheets. |
| POST | `/api/v1/timesheets/bulk-restore` | `timesheets.restore` | Bulk restore timesheets. |
| GET | `/api/v1/timesheets/export` | `timesheets.export` | Export timesheets to CSV/Excel/PDF where supported. |

## Leaves

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/leaves` | `leaves.list` | List leaves with pagination, search, filters and sorting. |
| POST | `/api/v1/leaves` | `leaves.create` | Create leaves. |
| GET | `/api/v1/leaves/{uuid}` | `leaves.view` | View one leaves. |
| PUT/PATCH | `/api/v1/leaves/{uuid}` | `leaves.update` | Update one leaves. |
| DELETE | `/api/v1/leaves/{uuid}` | `leaves.delete` | Soft delete one leaves. |
| GET | `/api/v1/leaves/trash` | `leaves.list` | List soft-deleted leaves. |
| POST | `/api/v1/leaves/{uuid}/restore` | `leaves.restore` | Restore soft-deleted leaves. |
| DELETE | `/api/v1/leaves/{uuid}/force` | `leaves.force-delete` | Permanently delete leaves. |
| POST | `/api/v1/leaves/bulk-delete` | `leaves.delete` | Bulk soft delete leaves. |
| POST | `/api/v1/leaves/bulk-restore` | `leaves.restore` | Bulk restore leaves. |
| GET | `/api/v1/leaves/export` | `leaves.export` | Export leaves to CSV/Excel/PDF where supported. |

## Forms

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/forms` | `forms.list` | List forms with pagination, search, filters and sorting. |
| POST | `/api/v1/forms` | `forms.create` | Create forms. |
| GET | `/api/v1/forms/{uuid}` | `forms.view` | View one forms. |
| PUT/PATCH | `/api/v1/forms/{uuid}` | `forms.update` | Update one forms. |
| DELETE | `/api/v1/forms/{uuid}` | `forms.delete` | Soft delete one forms. |
| GET | `/api/v1/forms/trash` | `forms.list` | List soft-deleted forms. |
| POST | `/api/v1/forms/{uuid}/restore` | `forms.restore` | Restore soft-deleted forms. |
| DELETE | `/api/v1/forms/{uuid}/force` | `forms.force-delete` | Permanently delete forms. |
| POST | `/api/v1/forms/bulk-delete` | `forms.delete` | Bulk soft delete forms. |
| POST | `/api/v1/forms/bulk-restore` | `forms.restore` | Bulk restore forms. |
| GET | `/api/v1/forms/export` | `forms.export` | Export forms to CSV/Excel/PDF where supported. |

## Media Manager

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/media` | `media.list` | List media manager with pagination, search, filters and sorting. |
| POST | `/api/v1/media` | `media.create` | Create media manager. |
| GET | `/api/v1/media/{uuid}` | `media.view` | View one media manager. |
| PUT/PATCH | `/api/v1/media/{uuid}` | `media.update` | Update one media manager. |
| DELETE | `/api/v1/media/{uuid}` | `media.delete` | Soft delete one media manager. |
| GET | `/api/v1/media/trash` | `media.list` | List soft-deleted media manager. |
| POST | `/api/v1/media/{uuid}/restore` | `media.restore` | Restore soft-deleted media manager. |
| DELETE | `/api/v1/media/{uuid}/force` | `media.force-delete` | Permanently delete media manager. |
| POST | `/api/v1/media/bulk-delete` | `media.delete` | Bulk soft delete media manager. |
| POST | `/api/v1/media/bulk-restore` | `media.restore` | Bulk restore media manager. |
| GET | `/api/v1/media/export` | `media.export` | Export media manager to CSV/Excel/PDF where supported. |

## Medicine Management

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/medicines` | `medicines.list` | List medicine management with pagination, search, filters and sorting. |
| POST | `/api/v1/medicines` | `medicines.create` | Create medicine management. |
| GET | `/api/v1/medicines/{uuid}` | `medicines.view` | View one medicine management. |
| PUT/PATCH | `/api/v1/medicines/{uuid}` | `medicines.update` | Update one medicine management. |
| DELETE | `/api/v1/medicines/{uuid}` | `medicines.delete` | Soft delete one medicine management. |
| GET | `/api/v1/medicines/trash` | `medicines.list` | List soft-deleted medicine management. |
| POST | `/api/v1/medicines/{uuid}/restore` | `medicines.restore` | Restore soft-deleted medicine management. |
| DELETE | `/api/v1/medicines/{uuid}/force` | `medicines.force-delete` | Permanently delete medicine management. |
| POST | `/api/v1/medicines/bulk-delete` | `medicines.delete` | Bulk soft delete medicine management. |
| POST | `/api/v1/medicines/bulk-restore` | `medicines.restore` | Bulk restore medicine management. |
| GET | `/api/v1/medicines/export` | `medicines.export` | Export medicine management to CSV/Excel/PDF where supported. |

## Invoices

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/invoices` | `invoices.list` | List invoices with pagination, search, filters and sorting. |
| POST | `/api/v1/invoices` | `invoices.create` | Create invoices. |
| GET | `/api/v1/invoices/{uuid}` | `invoices.view` | View one invoices. |
| PUT/PATCH | `/api/v1/invoices/{uuid}` | `invoices.update` | Update one invoices. |
| DELETE | `/api/v1/invoices/{uuid}` | `invoices.delete` | Soft delete one invoices. |
| GET | `/api/v1/invoices/trash` | `invoices.list` | List soft-deleted invoices. |
| POST | `/api/v1/invoices/{uuid}/restore` | `invoices.restore` | Restore soft-deleted invoices. |
| DELETE | `/api/v1/invoices/{uuid}/force` | `invoices.force-delete` | Permanently delete invoices. |
| POST | `/api/v1/invoices/bulk-delete` | `invoices.delete` | Bulk soft delete invoices. |
| POST | `/api/v1/invoices/bulk-restore` | `invoices.restore` | Bulk restore invoices. |
| GET | `/api/v1/invoices/export` | `invoices.export` | Export invoices to CSV/Excel/PDF where supported. |

## Invoice Payments

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/invoice-payments` | `invoice-payments.list` | List invoice payments with pagination, search, filters and sorting. |
| POST | `/api/v1/invoice-payments` | `invoice-payments.create` | Create invoice payments. |
| GET | `/api/v1/invoice-payments/{uuid}` | `invoice-payments.view` | View one invoice payments. |
| PUT/PATCH | `/api/v1/invoice-payments/{uuid}` | `invoice-payments.update` | Update one invoice payments. |
| DELETE | `/api/v1/invoice-payments/{uuid}` | `invoice-payments.delete` | Soft delete one invoice payments. |
| GET | `/api/v1/invoice-payments/trash` | `invoice-payments.list` | List soft-deleted invoice payments. |
| POST | `/api/v1/invoice-payments/{uuid}/restore` | `invoice-payments.restore` | Restore soft-deleted invoice payments. |
| DELETE | `/api/v1/invoice-payments/{uuid}/force` | `invoice-payments.force-delete` | Permanently delete invoice payments. |
| POST | `/api/v1/invoice-payments/bulk-delete` | `invoice-payments.delete` | Bulk soft delete invoice payments. |
| POST | `/api/v1/invoice-payments/bulk-restore` | `invoice-payments.restore` | Bulk restore invoice payments. |
| GET | `/api/v1/invoice-payments/export` | `invoice-payments.export` | Export invoice payments to CSV/Excel/PDF where supported. |

## Salary Management

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/salary` | `salary.list` | List salary management with pagination, search, filters and sorting. |
| POST | `/api/v1/salary` | `salary.create` | Create salary management. |
| GET | `/api/v1/salary/{uuid}` | `salary.view` | View one salary management. |
| PUT/PATCH | `/api/v1/salary/{uuid}` | `salary.update` | Update one salary management. |
| DELETE | `/api/v1/salary/{uuid}` | `salary.delete` | Soft delete one salary management. |
| GET | `/api/v1/salary/trash` | `salary.list` | List soft-deleted salary management. |
| POST | `/api/v1/salary/{uuid}/restore` | `salary.restore` | Restore soft-deleted salary management. |
| DELETE | `/api/v1/salary/{uuid}/force` | `salary.force-delete` | Permanently delete salary management. |
| POST | `/api/v1/salary/bulk-delete` | `salary.delete` | Bulk soft delete salary management. |
| POST | `/api/v1/salary/bulk-restore` | `salary.restore` | Bulk restore salary management. |
| GET | `/api/v1/salary/export` | `salary.export` | Export salary management to CSV/Excel/PDF where supported. |

## Reports

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/reports` | `reports.list` | List reports with pagination, search, filters and sorting. |
| POST | `/api/v1/reports` | `reports.create` | Create reports. |
| GET | `/api/v1/reports/{uuid}` | `reports.view` | View one reports. |
| PUT/PATCH | `/api/v1/reports/{uuid}` | `reports.update` | Update one reports. |
| DELETE | `/api/v1/reports/{uuid}` | `reports.delete` | Soft delete one reports. |
| GET | `/api/v1/reports/trash` | `reports.list` | List soft-deleted reports. |
| POST | `/api/v1/reports/{uuid}/restore` | `reports.restore` | Restore soft-deleted reports. |
| DELETE | `/api/v1/reports/{uuid}/force` | `reports.force-delete` | Permanently delete reports. |
| POST | `/api/v1/reports/bulk-delete` | `reports.delete` | Bulk soft delete reports. |
| POST | `/api/v1/reports/bulk-restore` | `reports.restore` | Bulk restore reports. |
| GET | `/api/v1/reports/export` | `reports.export` | Export reports to CSV/Excel/PDF where supported. |

## Export Center

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/export-center` | `export-center.list` | List export center with pagination, search, filters and sorting. |
| POST | `/api/v1/export-center` | `export-center.create` | Create export center. |
| GET | `/api/v1/export-center/{uuid}` | `export-center.view` | View one export center. |
| PUT/PATCH | `/api/v1/export-center/{uuid}` | `export-center.update` | Update one export center. |
| DELETE | `/api/v1/export-center/{uuid}` | `export-center.delete` | Soft delete one export center. |
| GET | `/api/v1/export-center/trash` | `export-center.list` | List soft-deleted export center. |
| POST | `/api/v1/export-center/{uuid}/restore` | `export-center.restore` | Restore soft-deleted export center. |
| DELETE | `/api/v1/export-center/{uuid}/force` | `export-center.force-delete` | Permanently delete export center. |
| POST | `/api/v1/export-center/bulk-delete` | `export-center.delete` | Bulk soft delete export center. |
| POST | `/api/v1/export-center/bulk-restore` | `export-center.restore` | Bulk restore export center. |
| GET | `/api/v1/export-center/export` | `export-center.export` | Export export center to CSV/Excel/PDF where supported. |

## Messages

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/messages` | `messages.list` | List messages with pagination, search, filters and sorting. |
| POST | `/api/v1/messages` | `messages.create` | Create messages. |
| GET | `/api/v1/messages/{uuid}` | `messages.view` | View one messages. |
| PUT/PATCH | `/api/v1/messages/{uuid}` | `messages.update` | Update one messages. |
| DELETE | `/api/v1/messages/{uuid}` | `messages.delete` | Soft delete one messages. |
| GET | `/api/v1/messages/trash` | `messages.list` | List soft-deleted messages. |
| POST | `/api/v1/messages/{uuid}/restore` | `messages.restore` | Restore soft-deleted messages. |
| DELETE | `/api/v1/messages/{uuid}/force` | `messages.force-delete` | Permanently delete messages. |
| POST | `/api/v1/messages/bulk-delete` | `messages.delete` | Bulk soft delete messages. |
| POST | `/api/v1/messages/bulk-restore` | `messages.restore` | Bulk restore messages. |
| GET | `/api/v1/messages/export` | `messages.export` | Export messages to CSV/Excel/PDF where supported. |

## Notifications

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/notifications` | `notifications.list` | List notifications with pagination, search, filters and sorting. |
| POST | `/api/v1/notifications` | `notifications.create` | Create notifications. |
| GET | `/api/v1/notifications/{uuid}` | `notifications.view` | View one notifications. |
| PUT/PATCH | `/api/v1/notifications/{uuid}` | `notifications.update` | Update one notifications. |
| DELETE | `/api/v1/notifications/{uuid}` | `notifications.delete` | Soft delete one notifications. |
| GET | `/api/v1/notifications/trash` | `notifications.list` | List soft-deleted notifications. |
| POST | `/api/v1/notifications/{uuid}/restore` | `notifications.restore` | Restore soft-deleted notifications. |
| DELETE | `/api/v1/notifications/{uuid}/force` | `notifications.force-delete` | Permanently delete notifications. |
| POST | `/api/v1/notifications/bulk-delete` | `notifications.delete` | Bulk soft delete notifications. |
| POST | `/api/v1/notifications/bulk-restore` | `notifications.restore` | Bulk restore notifications. |
| GET | `/api/v1/notifications/export` | `notifications.export` | Export notifications to CSV/Excel/PDF where supported. |

## Activity Logs

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/activity-logs` | `activity-logs.list` | List activity logs with pagination, search, filters and sorting. |
| POST | `/api/v1/activity-logs` | `activity-logs.create` | Create activity logs. |
| GET | `/api/v1/activity-logs/{uuid}` | `activity-logs.view` | View one activity logs. |
| PUT/PATCH | `/api/v1/activity-logs/{uuid}` | `activity-logs.update` | Update one activity logs. |
| DELETE | `/api/v1/activity-logs/{uuid}` | `activity-logs.delete` | Soft delete one activity logs. |
| GET | `/api/v1/activity-logs/trash` | `activity-logs.list` | List soft-deleted activity logs. |
| POST | `/api/v1/activity-logs/{uuid}/restore` | `activity-logs.restore` | Restore soft-deleted activity logs. |
| DELETE | `/api/v1/activity-logs/{uuid}/force` | `activity-logs.force-delete` | Permanently delete activity logs. |
| POST | `/api/v1/activity-logs/bulk-delete` | `activity-logs.delete` | Bulk soft delete activity logs. |
| POST | `/api/v1/activity-logs/bulk-restore` | `activity-logs.restore` | Bulk restore activity logs. |
| GET | `/api/v1/activity-logs/export` | `activity-logs.export` | Export activity logs to CSV/Excel/PDF where supported. |

## Settings

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/settings` | `settings.list` | List settings with pagination, search, filters and sorting. |
| POST | `/api/v1/settings` | `settings.create` | Create settings. |
| GET | `/api/v1/settings/{uuid}` | `settings.view` | View one settings. |
| PUT/PATCH | `/api/v1/settings/{uuid}` | `settings.update` | Update one settings. |
| DELETE | `/api/v1/settings/{uuid}` | `settings.delete` | Soft delete one settings. |
| GET | `/api/v1/settings/trash` | `settings.list` | List soft-deleted settings. |
| POST | `/api/v1/settings/{uuid}/restore` | `settings.restore` | Restore soft-deleted settings. |
| DELETE | `/api/v1/settings/{uuid}/force` | `settings.force-delete` | Permanently delete settings. |
| POST | `/api/v1/settings/bulk-delete` | `settings.delete` | Bulk soft delete settings. |
| POST | `/api/v1/settings/bulk-restore` | `settings.restore` | Bulk restore settings. |
| GET | `/api/v1/settings/export` | `settings.export` | Export settings to CSV/Excel/PDF where supported. |

## System Configuration

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/system-configuration` | `system-configuration.list` | List system configuration with pagination, search, filters and sorting. |
| POST | `/api/v1/system-configuration` | `system-configuration.create` | Create system configuration. |
| GET | `/api/v1/system-configuration/{uuid}` | `system-configuration.view` | View one system configuration. |
| PUT/PATCH | `/api/v1/system-configuration/{uuid}` | `system-configuration.update` | Update one system configuration. |
| DELETE | `/api/v1/system-configuration/{uuid}` | `system-configuration.delete` | Soft delete one system configuration. |
| GET | `/api/v1/system-configuration/trash` | `system-configuration.list` | List soft-deleted system configuration. |
| POST | `/api/v1/system-configuration/{uuid}/restore` | `system-configuration.restore` | Restore soft-deleted system configuration. |
| DELETE | `/api/v1/system-configuration/{uuid}/force` | `system-configuration.force-delete` | Permanently delete system configuration. |
| POST | `/api/v1/system-configuration/bulk-delete` | `system-configuration.delete` | Bulk soft delete system configuration. |
| POST | `/api/v1/system-configuration/bulk-restore` | `system-configuration.restore` | Bulk restore system configuration. |
| GET | `/api/v1/system-configuration/export` | `system-configuration.export` | Export system configuration to CSV/Excel/PDF where supported. |

## Trash & Restore

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/trash` | `trash.list` | List trash & restore with pagination, search, filters and sorting. |
| POST | `/api/v1/trash` | `trash.create` | Create trash & restore. |
| GET | `/api/v1/trash/{uuid}` | `trash.view` | View one trash & restore. |
| PUT/PATCH | `/api/v1/trash/{uuid}` | `trash.update` | Update one trash & restore. |
| DELETE | `/api/v1/trash/{uuid}` | `trash.delete` | Soft delete one trash & restore. |
| GET | `/api/v1/trash/trash` | `trash.list` | List soft-deleted trash & restore. |
| POST | `/api/v1/trash/{uuid}/restore` | `trash.restore` | Restore soft-deleted trash & restore. |
| DELETE | `/api/v1/trash/{uuid}/force` | `trash.force-delete` | Permanently delete trash & restore. |
| POST | `/api/v1/trash/bulk-delete` | `trash.delete` | Bulk soft delete trash & restore. |
| POST | `/api/v1/trash/bulk-restore` | `trash.restore` | Bulk restore trash & restore. |
| GET | `/api/v1/trash/export` | `trash.export` | Export trash & restore to CSV/Excel/PDF where supported. |

## Global Search

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/search` | `search.list` | List global search with pagination, search, filters and sorting. |
| POST | `/api/v1/search` | `search.create` | Create global search. |
| GET | `/api/v1/search/{uuid}` | `search.view` | View one global search. |
| PUT/PATCH | `/api/v1/search/{uuid}` | `search.update` | Update one global search. |
| DELETE | `/api/v1/search/{uuid}` | `search.delete` | Soft delete one global search. |
| GET | `/api/v1/search/trash` | `search.list` | List soft-deleted global search. |
| POST | `/api/v1/search/{uuid}/restore` | `search.restore` | Restore soft-deleted global search. |
| DELETE | `/api/v1/search/{uuid}/force` | `search.force-delete` | Permanently delete global search. |
| POST | `/api/v1/search/bulk-delete` | `search.delete` | Bulk soft delete global search. |
| POST | `/api/v1/search/bulk-restore` | `search.restore` | Bulk restore global search. |
| GET | `/api/v1/search/export` | `search.export` | Export global search to CSV/Excel/PDF where supported. |

## Bulk Actions

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| GET | `/api/v1/bulk-actions` | `bulk-actions.list` | List bulk actions with pagination, search, filters and sorting. |
| POST | `/api/v1/bulk-actions` | `bulk-actions.create` | Create bulk actions. |
| GET | `/api/v1/bulk-actions/{uuid}` | `bulk-actions.view` | View one bulk actions. |
| PUT/PATCH | `/api/v1/bulk-actions/{uuid}` | `bulk-actions.update` | Update one bulk actions. |
| DELETE | `/api/v1/bulk-actions/{uuid}` | `bulk-actions.delete` | Soft delete one bulk actions. |
| GET | `/api/v1/bulk-actions/trash` | `bulk-actions.list` | List soft-deleted bulk actions. |
| POST | `/api/v1/bulk-actions/{uuid}/restore` | `bulk-actions.restore` | Restore soft-deleted bulk actions. |
| DELETE | `/api/v1/bulk-actions/{uuid}/force` | `bulk-actions.force-delete` | Permanently delete bulk actions. |
| POST | `/api/v1/bulk-actions/bulk-delete` | `bulk-actions.delete` | Bulk soft delete bulk actions. |
| POST | `/api/v1/bulk-actions/bulk-restore` | `bulk-actions.restore` | Bulk restore bulk actions. |
| GET | `/api/v1/bulk-actions/export` | `bulk-actions.export` | Export bulk actions to CSV/Excel/PDF where supported. |


## Custom workflow routes

| Method | Endpoint | Permission | Description |
|---|---|---|---|
| POST | `/api/v1/employees/{uuid}/assign-client` | `employees.assign` | Assign employee to client. |
| DELETE | `/api/v1/employees/{uuid}/remove-client/{client_uuid}` | `employees.assign` | Remove employee-client assignment. |
| GET | `/api/v1/employees/{uuid}/activities` | `employees.view` | Employee activities. |
| GET | `/api/v1/employees/{uuid}/schedules` | `employees.view` | Employee schedules. |
| GET | `/api/v1/employees/{uuid}/salary` | `salary.view` | Employee salary history. |
| GET | `/api/v1/employees/{uuid}/reports` | `reports.view` | Employee reports. |
| GET | `/api/v1/clients/{uuid}/activities` | `clients.view` | Client activities. |
| GET | `/api/v1/clients/{uuid}/employees` | `clients.view` | Client assigned employees. |
| GET | `/api/v1/clients/{uuid}/reports` | `reports.view` | Client reports. |
| PATCH | `/api/v1/activities/{uuid}/approve` | `activities.approve` | Approve activity. |
| PATCH | `/api/v1/activities/{uuid}/cancel` | `activities.update` | Cancel activity. |
| PATCH | `/api/v1/activities/{uuid}/complete` | `activities.update` | Complete activity. |
| PATCH | `/api/v1/activities/{uuid}/start` | `activities.update` | Start activity. |
| PATCH | `/api/v1/activities/{uuid}/stop` | `activities.update` | Stop activity. |
| PATCH | `/api/v1/schedules/{uuid}/approve` | `schedules.approve` | Approve schedule. |
| PATCH | `/api/v1/schedules/{uuid}/cancel` | `schedules.update` | Cancel schedule. |
| PATCH | `/api/v1/schedules/{uuid}/complete` | `schedules.update` | Complete schedule. |
| POST | `/api/v1/recurring-rotas/{uuid}/generate` | `recurring-rotas.create` | Generate schedules from recurring rota. |
| PATCH | `/api/v1/leaves/{uuid}/approve` | `leaves.approve` | Approve leave. |
| PATCH | `/api/v1/leaves/{uuid}/reject` | `leaves.approve` | Reject leave. |
| POST | `/api/v1/forms/{uuid}/publish` | `forms.update` | Publish form. |
| POST | `/api/v1/forms/{uuid}/archive` | `forms.update` | Archive form. |
| POST | `/api/v1/forms/{uuid}/assign` | `forms.assign` | Assign form. |
| POST | `/api/v1/salary/generate` | `salary.create` | Generate salary. |
| GET | `/api/v1/salary/{employee_uuid}` | `salary.view` | Employee salary by employee. |
| GET | `/api/v1/salary/export` | `salary.export` | Export salary records. |
| POST | `/api/v1/invoices/{uuid}/pay` | `invoice-payments.create` | Record invoice payment. |
| POST | `/api/v1/invoices/{uuid}/cancel` | `invoices.update` | Cancel invoice. |
| GET | `/api/v1/invoices/export` | `invoices.export` | Export invoices. |
| GET | `/api/v1/reports/dashboard` | `reports.view` | Report dashboard. |
| GET | `/api/v1/reports/activity` | `reports.view` | Activity report. |
| GET | `/api/v1/reports/schedule` | `reports.view` | Schedule report. |
| GET | `/api/v1/reports/employee` | `reports.view` | Employee report. |
| GET | `/api/v1/reports/client` | `reports.view` | Client report. |
| GET | `/api/v1/reports/invoice` | `reports.view` | Invoice report. |
| GET | `/api/v1/reports/salary` | `reports.view` | Salary report. |
| GET | `/api/v1/reports/leave` | `reports.view` | Leave report. |
| GET | `/api/v1/reports/export/pdf` | `reports.export` | Export report as PDF. |
| GET | `/api/v1/reports/export/excel` | `reports.export` | Export report as Excel. |
| GET | `/api/v1/messages/conversations` | `messages.view` | Conversation list. |
| GET | `/api/v1/messages/{conversation_uuid}` | `messages.view` | Conversation messages. |
| POST | `/api/v1/messages/{conversation_uuid}` | `messages.create` | Send message. |
| PUT | `/api/v1/messages/read` | `messages.update` | Mark messages read. |
| GET | `/api/v1/notifications` | `notifications.view` | Notification list. |
| PUT | `/api/v1/notifications/read` | `notifications.update` | Mark one/many as read. |
| PUT | `/api/v1/notifications/read-all` | `notifications.update` | Mark all notifications as read. |
| GET | `/api/v1/health` | Public/Internal | Health check. |
| GET | `/api/v1/docs/api` | Internal | OpenAPI documentation UI, if enabled. |

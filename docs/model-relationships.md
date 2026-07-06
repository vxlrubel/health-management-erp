# Model Relationships

Use Eloquent relationships consistently. Relationships should be defined on both sides where they are used by resources, policies, queries, filters, reports or tests.

## User

- belongsTo Branch
- belongsTo Role
- hasOne Employee
- morphMany ActivityLog as causer
- morphMany Notifications

## Branch

- hasMany Users
- hasMany Employees
- hasMany Clients
- hasMany Schedules
- hasMany Activities
- hasMany Ratesheets
- hasMany Rotas

## Employee

- belongsTo Branch
- belongsTo User
- belongsToMany Clients
- hasMany Activities
- hasMany Schedules
- hasMany Leaves
- hasMany Timesheets
- hasMany SalaryRecords
- hasMany EmployeeDocuments

## Client

- belongsTo Branch
- belongsTo Funder
- belongsToMany Employees
- hasMany CarePlans
- hasMany Activities
- hasMany Schedules
- hasMany Invoices
- hasMany Medicines

## Funder

- hasMany Clients
- hasMany Invoices

## CarePlan

- belongsTo Client

## Ratesheet

- belongsTo Branch
- hasMany Rotas

## Rota

- belongsTo Branch
- belongsTo Ratesheet
- hasMany Schedules
- hasMany RecurringRotas

## ShiftTemplate

- belongsTo Branch
- hasMany RecurringRotas

## Schedule

- belongsTo Branch
- belongsTo Employee
- belongsTo Client
- belongsTo Rota
- hasMany Activities

## Activity

- belongsTo Schedule
- belongsTo Employee
- belongsTo Client
- belongsTo Branch

## Timesheet

- belongsTo Employee
- belongsTo Branch
- hasMany Activities through period matching

## Leave

- belongsTo Employee
- belongsTo approver User

## Invoice

- belongsTo Client
- belongsTo Employee
- belongsTo Funder
- hasMany InvoiceItems
- hasMany InvoicePayments

## SalaryRecord

- belongsTo Employee
- belongsTo Branch

## Medicine

- belongsTo Client
- hasMany MedicineAdministrations

## MedicineAdministration

- belongsTo Medicine
- belongsTo Client
- belongsTo Employee

## Form

- hasMany FormSubmissions
- morphMany Media


## Pivot tables

### `client_employee`

Links clients and employees.

Fields:

- `client_id`
- `employee_id`
- `assigned_from`
- `assigned_to`
- `is_primary`

Rules:

- A client may have multiple employees.
- An employee may serve multiple clients.
- Only one active primary employee per client should exist unless the business explicitly allows multiple primary carers.

## Relationship implementation tips

- Use `withDefault()` only when a missing relationship is expected.
- Avoid loading all relationships by default; eager-load only per endpoint needs.
- Use API Resources to conditionally include relationships with `whenLoaded()`.
- Branch restrictions should be applied before eager loading sensitive relationships.

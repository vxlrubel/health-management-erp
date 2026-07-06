# Architecture

## Overview

Health Management ERP API is a Laravel 12 API-only application. It exposes REST endpoints under `/api/v1` and returns JSON only. The frontend may be web, mobile or third-party integration, but the Laravel application remains backend-only.

## Architecture style

The project uses layered architecture:

1. **Routes** define public API paths and middleware.
2. **Controllers** handle HTTP input and delegate work only.
3. **Form Requests** validate and authorize request payloads.
4. **Services** contain business rules and transactions.
5. **Repositories** handle query construction and persistence.
6. **Models** define Eloquent relationships, casts and scopes.
7. **Resources** transform models into stable API responses.
8. **Policies** enforce authorization.
9. **Events and Listeners** decouple side effects.
10. **Jobs and Queues** run slow work asynchronously.
11. **Notifications** deliver database/email/push messages.
12. **Activity Logs** record audit events.

Controllers must not contain payroll calculations, scheduling rules, invoice totals, branch access logic, report aggregation or file processing. Those belong in services and domain helpers.

## API standards

- Base URL: `/api/v1`
- API versioning: `v1` route prefix.
- Authentication: Laravel Sanctum bearer tokens.
- Authorization: Laravel Policies + Spatie roles/permissions.
- Response format: see `response-format.md`.
- Validation: FormRequest classes only.
- Pagination: Laravel paginator with standard `meta` and `links`.
- Filtering/search/sort: Spatie Query Builder where possible.
- Soft deletes: enabled for every master/resource table unless explicitly excluded.
- Audit columns: `created_by`, `updated_by`, `deleted_by` where applicable.
- Public identity: `uuid` field should be exposed to API clients; numeric `id` can remain internal.

## Multi-branch data isolation

The ERP must support branch-level ownership.

- Every operational record belongs to a `branch_id` where applicable.
- Branch Manager users may only access records within assigned branches.
- HR users may access employees and operational records within allowed branches.
- Employees may access only their own employee profile, schedules, activities, leave and timesheets unless granted extra permission.
- Clients may access only their own profile, care plans, schedules, invoices and messages.
- Funders may access only funded clients and invoices.
- Super Admin bypasses branch restrictions.

## Core modules

- **Authentication & Profile**: Login, logout, password reset, MFA-ready profile management.
- **Dashboard**: Statistics, charts, recent activity, revenue and payroll summaries.
- **Users**: System user accounts connected to employees, clients and funders.
- **Roles**: Role management using Spatie Permission.
- **Permissions**: Fine-grained module permissions.
- **Branches**: Branch/company location data and branch-level isolation.
- **Employees**: Staff records, branch assignment, employment profile and status.
- **Employee Documents**: Staff documents such as passport, certificate, contracts and CV.
- **Clients**: Client profiles, care plan links, staff assignment and funder data.
- **Care Plans**: Client care plan summaries, goals, risk notes and review cycle.
- **Funders**: Funding organisations and payment responsibility.
- **Ratesheets**: Hourly, weekend, holiday and night rate definitions.
- **Rotas**: Named rota templates and effective schedule ranges.
- **Shift Templates**: Reusable shift definitions for recurring scheduling.
- **Recurring Rotas**: Pattern based rota generation.
- **Holiday Calendar**: Public/company holidays used in payroll and scheduling.
- **Schedules**: Planned visits/shifts linking employee, client, branch and rota.
- **Activities**: Actual work activities and visit records.
- **Timesheets**: Approved worked hours generated from activities/schedules.
- **Leaves**: Employee leave requests and approvals.
- **Forms**: Dynamic form builder, submissions, publishing and assignment.
- **Media Manager**: Media upload, attachment, file library and document tagging.
- **Medicine Management**: Client medicines, dosage, administration logs and review dates.
- **Invoices**: Client/funder invoices, status tracking and invoice items.
- **Invoice Payments**: Invoice payments, refunds, credit notes and outstanding balances.
- **Salary Management**: Employee salary generation, overtime and deductions.
- **Reports**: Operational, payroll, branch, client and finance reports.
- **Export Center**: PDF, Excel and CSV exports.
- **Messages**: Private staff/client conversations and read receipts.
- **Notifications**: Database, email and push notifications.
- **Activity Logs**: Audit trail for create, update, delete, restore and auth events.
- **Settings**: Company, invoice, SMS/email, timezone, currency and default rates.
- **System Configuration**: Maintenance, cache, queues, jobs and application runtime settings.
- **Trash & Restore**: Central soft-delete restore and permanent delete workflow.
- **Global Search**: Cross-module search with saved filters.
- **Bulk Actions**: Bulk delete, restore, export, assign and status changes.
- **Health Check**: Operational health endpoints for deployment monitoring.
- **OpenAPI / Scramble**: API documentation generation using Scramble.

## Common resource features

Every major module should support:

- Create
- Update
- View
- Detail
- List
- Pagination
- Search
- Filter
- Sort
- Export
- Soft delete
- Restore
- Permanent delete
- Activity log
- Policy authorization
- Form request validation

## Transaction rules

Use database transactions for operations that touch more than one table, including:

- Assigning employees to clients.
- Generating schedules from recurring rotas.
- Converting activities into timesheets.
- Generating salary records.
- Generating invoice records and invoice items.
- Accepting invoice payments.
- Publishing forms and assigning them to users.
- Uploading files and attaching media to records.

## Enterprise readiness checklist

- All APIs are authenticated unless explicitly public.
- All write APIs are authorized by policy and permission.
- Sensitive operations are activity logged.
- Jobs are queued for exports, notifications, payroll generation and invoice generation.
- Reports use optimized queries and indexes.
- API docs are generated through Scramble.
- Tests exist for success, validation, authorization and branch isolation.

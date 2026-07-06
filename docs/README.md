# Health Management ERP API

Version: **1.0**  
Type: **Laravel 12 REST API only**  
API prefix: **`/api/v1`**

This documentation folder is an AI-ready blueprint for building a production Health Management ERP backend. It is designed so an AI coding assistant, Laravel developer, or API team can generate the application module by module without guessing business logic, route naming, permissions, validation, response formats, folder structure, or implementation order.

## Goals

- Build an API-only Health Management ERP backend.
- Keep frontend concerns outside the Laravel project; Vue, React, mobile apps, or other clients consume the REST API.
- Use consistent JSON responses for success, validation errors and server errors.
- Implement branch-based data isolation with Super Admin override.
- Use UUIDs for public identifiers and numeric IDs internally.
- Support soft deletes and central restore/permanent delete flows.
- Keep business logic out of controllers using Service and Repository layers.
- Use policies, roles and permissions for every secured action.
- Provide export, audit, notification, queue and OpenAPI documentation standards from the start.

## Recommended stack

| Purpose | Package / Tool |
|---|---|
| Framework | Laravel 12 |
| API Authentication | Laravel Sanctum |
| Roles & Permissions | Spatie Laravel Permission |
| Activity Logs | Spatie Activitylog |
| Query Filtering | Spatie Laravel Query Builder |
| OpenAPI Documentation | Scramble |
| Excel Export/Import | Laravel Excel |
| PDF Generation | DomPDF or Browsershot |
| Media Management | Spatie Media Library |
| Queues | Laravel Queue + Horizon |
| Debugging | Laravel Telescope |
| Backups | Spatie Backup |
| Testing | Pest + PHPUnit |

## Documentation map

| File | Purpose |
|---|---|
| `architecture.md` | Project architecture, layers, API standards and core modules. |
| `api-routes.md` | All API route groups and route naming conventions. |
| `database-schema.md` | Database tables, fields, indexes and table ownership. |
| `model-relationships.md` | Eloquent relationship map. |
| `business-rules.md` | Domain/business constraints that APIs must enforce. |
| `features.md` | Feature catalogue by module. |
| `permissions-matrix.md` | Role and permission matrix. |
| `workflow.md` | Operational workflows such as scheduling, payroll and invoicing. |
| `validation-rules.md` | FormRequest validation standards. |
| `response-format.md` | Standard JSON response and error format. |
| `folder-structure.md` | Laravel directory structure for this API. |
| `coding-standards.md` | Laravel/PHP coding rules. |
| `service-layer.md` | Service class standards and examples. |
| `repository-pattern.md` | Repository layer standards and examples. |
| `events-listeners.md` | Domain events and listeners. |
| `queues-jobs.md` | Queue, job and scheduler standards. |
| `notifications.md` | Database, mail and push notification rules. |
| `activity-log.md` | Audit logging requirements. |
| `reports.md` | Report catalogue and export rules. |
| `salary-management.md` | Salary and payroll calculation rules. |
| `invoice-management.md` | Invoice, payment, refund and credit note rules. |
| `media-manager.md` | Upload and attachment rules. |
| `care-plan.md` | Care plan module specification. |
| `medicine-management.md` | Medicine and administration records. |
| `timesheets.md` | Timesheet and attendance rules. |
| `client-management.md` | Client management module specification. |
| `employee-management.md` | Employee management module specification. |
| `settings.md` | System/company settings. |
| `openapi-scramble.md` | Scramble/OpenAPI documentation setup. |
| `deployment.md` | Deployment checklist. |
| `testing.md` | Test strategy and example cases. |
| `development-order.md` | Suggested development sequence. |

## Development principle

Build the project in small, testable modules. Every module should include migration, model, factory, policy, request validation, resource, controller, service, repository, routes, tests, API docs and activity logging before moving to the next module.

# Suggested Development Order

Build the API in phases to reduce risk and keep AI-generated code consistent.

## Phase 1 — Foundation

1. Laravel project setup.
2. API response helper.
3. Auth with Sanctum.
4. Users, roles and permissions.
5. Branches.
6. Settings.
7. Folder structure.
8. Service and repository base classes.
9. Policies and seeders.
10. OpenAPI/Scramble setup.

## Phase 2 — People and clients

1. Employees.
2. Employee documents.
3. Clients.
4. Funders.
5. Care plans.
6. Employee-client assignments.

## Phase 3 — Scheduling

1. Ratesheets.
2. Rotas.
3. Shift templates.
4. Recurring rotas.
5. Holiday calendar.
6. Schedules.
7. Activities.
8. Leaves.
9. Timesheets.

## Phase 4 — Forms and media

1. Dynamic forms.
2. Form submissions.
3. Media manager.
4. Document verification.

## Phase 5 — Finance

1. Salary generation.
2. Invoices.
3. Invoice payments.
4. Refunds/credit notes.
5. Tax management.

## Phase 6 — Communication and reports

1. Notifications.
2. Messages.
3. Activity logs.
4. Reports.
5. Export center.
6. Dashboard analytics.

## Phase 7 — Operations

1. Queues and jobs.
2. Scheduled commands.
3. Backup management.
4. Deployment automation.
5. Monitoring and health checks.
6. Performance optimization.

## Final rule

Do not start a new phase until the previous phase has migrations, models, policies, requests, resources, controllers, routes, services, repositories, tests and API documentation.

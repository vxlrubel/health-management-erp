# Queues, Jobs and Scheduled Commands

Queue long-running tasks to keep API responses fast.

## Recommended queue driver

- Development: `database` or `redis`.
- Production: `redis` with Horizon.

## Queue names

| Queue | Use |
|---|---|
| `default` | Normal async tasks. |
| `notifications` | Email and push notifications. |
| `exports` | PDF/Excel/CSV generation. |
| `reports` | Large report generation. |
| `payroll` | Salary and timesheet processing. |
| `invoices` | Invoice generation and payment processing. |

## Required jobs

- `SendNotificationJob`
- `GenerateReportJob`
- `ExportResourceJob`
- `GenerateSchedulesFromRecurringRotaJob`
- `GenerateTimesheetJob`
- `GenerateSalaryJob`
- `GenerateInvoiceJob`
- `ProcessMediaUploadJob`
- `DocumentExpiryReminderJob`
- `BackupDatabaseJob`

## Scheduled commands

| Command | Frequency | Purpose |
|---|---|---|
| `documents:expiry-reminders` | Daily | Notify about expiring employee/client documents. |
| `rotas:generate-upcoming` | Daily | Generate schedules from recurring rotas. |
| `reports:cleanup` | Daily | Remove expired report files. |
| `notifications:cleanup` | Weekly | Archive old notifications. |
| `system:backup` | Daily | Run database/files backup. |
| `activity-log:prune` | Monthly | Prune old logs according to retention policy. |

## Failure handling

- Failed jobs must be visible in Horizon.
- Failed report/export jobs should update report status to `failed`.
- Failed notification jobs should be retried with exponential backoff.
- Sensitive jobs must never log private document contents.

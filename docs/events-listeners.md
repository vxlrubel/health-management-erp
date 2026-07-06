# Events and Listeners

Use events for domain actions that trigger side effects. Controllers and services should dispatch events; listeners should send notifications, write logs, trigger jobs and update derived records.

## Event naming convention

```text
{Model}{Action}
```

Examples:

- `EmployeeCreated`
- `ClientAssignedToEmployee`
- `ScheduleGenerated`
- `ActivityCompleted`
- `LeaveApproved`
- `InvoicePaid`
- `SalaryGenerated`
- `FormPublished`

## Required events

| Event | Trigger | Suggested listeners |
|---|---|---|
| `EmployeeCreated` | Employee created | Log activity, notify HR. |
| `ClientCreated` | Client created | Log activity, notify branch manager. |
| `ClientAssignedToEmployee` | Employee-client assignment created | Notify employee, log activity. |
| `ScheduleCreated` | Schedule created | Notify employee, log activity. |
| `ScheduleCancelled` | Schedule cancelled | Notify employee/client, log activity. |
| `RecurringRotaGenerated` | Schedules generated | Queue summary notification. |
| `ActivityCompleted` | Activity completed | Update timesheet candidate, notify manager. |
| `LeaveRequested` | Leave request submitted | Notify approver. |
| `LeaveApproved` | Leave approved | Notify employee, block scheduling. |
| `LeaveRejected` | Leave rejected | Notify employee. |
| `InvoiceGenerated` | Invoice created | Notify admin/funder/client. |
| `InvoicePaid` | Payment recorded | Update invoice status, notify finance. |
| `SalaryGenerated` | Salary draft generated | Notify HR/finance. |
| `FormPublished` | Form published | Notify target users. |
| `DocumentExpiringSoon` | Scheduled check | Notify employee/HR. |

## Listener rules

- Slow listeners should implement `ShouldQueue`.
- Listeners should be idempotent.
- Listeners must not bypass authorization for user-triggered actions.
- All domain events should be logged or produce an activity log where useful.

# Timesheets

Timesheets summarize approved work hours for employee payroll and operational reporting.

## Inputs

- Activities
- Schedules
- Leave records
- Holiday calendar
- Ratesheets

## Fields

- Employee
- Branch
- Period start/end
- Regular hours
- Overtime hours
- Holiday hours
- Status
- Approved by/at

## Statuses

- `draft`
- `pending`
- `approved`
- `rejected`
- `locked`

## Rules

- Only completed/approved activities count toward payable hours.
- Cancelled schedules and activities do not count.
- Approved timesheets should be locked from casual edits.
- Timesheet approval must be activity logged.
- Salary generation should use approved timesheets only.

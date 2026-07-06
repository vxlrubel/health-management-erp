# Salary Management

Salary management calculates employee payroll from approved timesheets and activities.

## Inputs

- Employee
- Branch
- Month or custom date range
- Approved timesheets
- Approved activities
- Hourly rate or salary profile
- Overtime rules
- Bonus and deduction entries

## Calculation rules

1. Load employee and branch.
2. Verify permission and branch access.
3. Load approved timesheets/activities only.
4. Calculate regular hours.
5. Calculate overtime hours.
6. Apply hourly rate and overtime multiplier.
7. Add bonuses.
8. Subtract deductions.
9. Produce net salary.
10. Save salary record and salary items inside a transaction.

## Statuses

- `draft`
- `pending`
- `paid`
- `cancelled`

## Endpoints

- `GET /salary`
- `POST /salary/generate`
- `GET /salary/{{employee_uuid}}`
- `GET /salary/export`

## Business rules

- Do not include cancelled activities.
- Do not include unapproved timesheets.
- Prevent duplicate salary generation for the same employee and month unless revision mode is enabled.
- Payment status changes must be activity logged.

# Business Rules

## Global rules

- Branch Manager users can only manage employees, clients and operational records inside their own branch.
- Super Admin users bypass branch restrictions.
- All create/update/delete/restore/force-delete actions must be activity logged.
- UUIDs must be exposed to API clients for resource identification.
- Soft-deleted records must not appear in normal list APIs.
- Force delete is restricted to Super Admin or explicitly granted admin users.
- Import/export must respect the same permissions and branch scope as normal API lists.
- All monetary totals must be calculated server-side.
- Client, employee and funder relationships must be verified before schedule, salary or invoice generation.

## Branch rules

- A branch code must be unique.
- A branch can have many employees and clients.
- A user may have one primary branch and optionally multiple accessible branches.
- Branch Manager must not gain access to all branches by choosing an “All Branches” filter.

## Employee rules

- Employee number and email must be unique.
- Inactive or suspended employees cannot be assigned to new schedules.
- Employee hourly rate must be available before salary generation.
- Employee documents can have expiry dates and verification status.
- Employee profile may link to a user account, but employee record and user account should remain separate concepts.

## Client rules

- Client number must be unique.
- Client must belong to one branch.
- Client may belong to one funder.
- Client assignment to employees must be branch-consistent.
- Inactive clients cannot receive new schedules unless explicitly allowed by an admin override.

## Schedule and rota rules

- Schedule start datetime must be before end datetime.
- Employee and client branch must match the schedule branch.
- Detect conflicts before schedule creation: employee overlapping shifts, leave dates and suspended status.
- Recurring rota generation must be idempotent for the same period.
- Schedules can be approved, cancelled or completed depending on workflow.

## Activity rules

- Activity may be linked to a schedule or created independently when allowed.
- Actual hours are calculated from actual start/end datetime.
- Completed activities can be used for timesheets and payroll.
- Cancelled activities should not be included in salary or invoice totals.

## Leave rules

- Leave start date must be before or equal to end date.
- Approved leave blocks schedule assignment for the employee.
- Leave approval requires permission `leaves.approve`.

## Salary rules

- Salary must be generated from approved activities/timesheets only.
- Duplicate salary generation for the same employee/month should be prevented unless regenerating with a revision.
- Overtime, bonus and deduction rules must be auditable.
- Salary payment status must move through draft, pending, paid and cancelled states.

## Invoice rules

- Invoice number must be unique and generated server-side.
- Invoice totals are calculated from invoice items.
- Payment cannot exceed outstanding balance unless overpayment handling is explicitly enabled.
- Paid invoices should be locked from destructive changes.
- Cancelled invoices should not appear in revenue reports unless requested.

## Forms rules

- Draft forms can be edited.
- Published forms should not be structurally changed without creating a new version.
- Form submissions must preserve the form schema version used at submission time.

## Media rules

- File uploads must be validated by type, size and allowed collection.
- Sensitive documents must respect module permission and branch ownership.
- Media should be attached through Spatie Media Library collections.

## Notifications rules

- Important workflow events should create database notifications.
- Email/push delivery should be queued.
- Users should be able to mark notifications as read.

## Reports rules

- Reports must be filtered by branch for non-Super Admin users.
- Large report exports must be queued.
- Reports should use indexed date ranges and statuses.

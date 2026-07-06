# Workflows

## Employee onboarding

1. Admin creates a user account or employee record.
2. Employee is assigned to a branch and role.
3. Required employee documents are uploaded.
4. HR verifies documents where required.
5. Employee becomes active.
6. Active employee becomes available for scheduling.

## Client onboarding

1. Admin creates client profile.
2. Client is assigned to branch and optional funder.
3. Care plan is created.
4. Employees are assigned to client.
5. Initial schedules/rotas are created.
6. Client becomes active for visits, activities and invoices.

## Rota and scheduling

1. Create ratesheet.
2. Create shift templates.
3. Create rota.
4. Create recurring rota pattern.
5. Generate schedules for date range.
6. Run conflict detection.
7. Notify assigned employees.
8. Employees complete activities/visits.
9. Completed activities flow into timesheets and payroll.

## Activity to timesheet

1. Employee starts/records activity.
2. Activity is completed with actual start/end time.
3. Manager or system validates activity.
4. Approved activity contributes to timesheet hours.
5. Timesheet is reviewed and approved.
6. Approved timesheet contributes to salary generation.

## Leave approval

1. Employee submits leave request.
2. System validates date range and overlap.
3. Manager/HR approves or rejects.
4. Approved leave blocks scheduling.
5. Employee receives notification.

## Salary generation

1. Select employee/month/branch.
2. Load approved timesheets and approved activities.
3. Apply ratesheet/default hourly rate.
4. Calculate regular hours, overtime, bonuses and deductions.
5. Generate salary draft.
6. Approve salary.
7. Mark as paid.
8. Salary appears in payroll reports.

## Invoice generation

1. Select client/funder/date range.
2. Load billable schedules/activities.
3. Apply ratesheets, tax and discounts.
4. Generate invoice draft and invoice items.
5. Approve/send invoice.
6. Record payments.
7. Update status to partially paid/paid/cancelled.
8. Invoice appears in revenue reports.

## Form publishing

1. Admin creates draft form using dynamic schema.
2. Admin previews and validates schema.
3. Admin publishes form.
4. Form is assigned to employees/clients/branches.
5. Users submit form responses.
6. Submissions are reviewed and exported where needed.

## Restore workflow

1. User deletes resource.
2. Resource is soft deleted and activity logged.
3. Trash endpoint lists deleted resources.
4. Authorized user restores or permanently deletes.
5. Permanent delete is restricted and logged.

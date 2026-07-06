# Testing

# Testing Strategy

Use Pest and PHPUnit for automated tests.

## Test types

- Feature tests for endpoints.
- Unit tests for services.
- Policy tests for authorization.
- Repository tests for scoped queries.
- Job tests for queued workflows.
- Export tests for report generation.

## Required test coverage per module

- Unauthenticated request returns 401.
- Unauthorized user returns 403.
- Validation failure returns 422.
- List endpoint returns only accessible branch data.
- Create endpoint stores valid record.
- Update endpoint updates allowed fields only.
- Delete endpoint soft deletes record.
- Restore endpoint restores record.
- Force delete requires permission.
- Activity log is written for write actions.

## Business workflow tests

- Schedule conflict detection.
- Recurring rota schedule generation.
- Leave approval blocks schedules.
- Activity completion creates payable hours.
- Salary generation totals hours correctly.
- Invoice payment updates invoice status.
- Form publishing locks schema.
- Media upload respects permissions.

## Example test name format

```text
it_allows_admin_to_create_employee()
it_blocks_branch_manager_from_viewing_other_branch_client()
it_generates_salary_from_approved_timesheets_only()
```

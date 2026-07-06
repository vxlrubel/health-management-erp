# Coding Standards

## PHP and Laravel standards

- Follow PSR-12.
- Use strict, descriptive class names.
- Use typed method arguments and return types where practical.
- Do not write business logic in controllers.
- Do not run raw queries unless there is a measurable performance reason.
- Prefer Eloquent scopes for reusable filters.
- Prefer FormRequest validation for all create/update/filter endpoints.
- Prefer policies for authorization.
- Prefer API Resources for every response.

## Controller rules

Controllers may only:

1. Accept FormRequest instances.
2. Call a service method.
3. Return an API response/resource.

Controllers must not:

- Calculate payroll.
- Calculate invoice totals.
- Generate schedules.
- Check branch restrictions manually when a policy/scope should handle it.
- Upload files directly without a media service.
- Send notifications directly when a domain event/listener is better.

## Naming rules

| Item | Format | Example |
|---|---|---|
| Route URI | plural kebab-case | `/care-plans` |
| Permission | module.action | `employees.create` |
| Policy method | Laravel standard | `viewAny`, `view`, `create`, `update`, `delete` |
| Service method | verb phrase | `generateSalary`, `approveLeave` |
| Repository method | query/persistence phrase | `findByUuid`, `paginateForBranch` |
| Enum case | PascalCase | `Approved` |
| DB column | snake_case | `branch_id` |

## Validation rules

- Validation belongs in FormRequest classes.
- Use `Rule::unique()` and `Rule::exists()` with branch constraints when needed.
- Use enums for statuses and types.
- Do not trust frontend totals; calculate totals server-side.
- Validate ownership: IDs supplied in payload must belong to the user's accessible branch.

## Error handling

- Throw domain-specific exceptions for business rule failures.
- Convert exceptions to standard API response format.
- Never expose stack traces in production.
- Log unexpected exceptions with user ID, route, request ID and sanitized payload.

## Testing requirements

Every module should include tests for:

- List endpoint.
- Detail endpoint.
- Create validation.
- Update validation.
- Delete and restore.
- Unauthorized access.
- Branch isolation.
- Role permission checks.
- Export where applicable.

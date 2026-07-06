# Validation Rules

Use FormRequest classes for every write endpoint and any complex list/filter endpoint.

## Common rules

- Never trust IDs coming from the frontend without verifying branch ownership.
- Use enum validation for statuses and types.
- Use `exists` validation with scoped queries when the related record must belong to the same branch.
- Use `unique` validation with ignore rule for updates.
- Validate date order: start must be before end.
- Validate money as numeric decimal values with minimum 0 unless negative values are valid for credits/refunds.
- Validate uploaded files by MIME type, extension and size.
- Validate arrays with `array` plus nested `*.field` rules.

## Example StoreEmployeeRequest

```php
public function rules(): array
{
    return [
        'branch_id' => ['required', 'integer', Rule::exists('branches', 'id')],
        'first_name' => ['required', 'string', 'max:100'],
        'last_name' => ['required', 'string', 'max:100'],
        'email' => ['required', 'email', Rule::unique('employees', 'email')],
        'phone' => ['nullable', 'string', 'max:30'],
        'joining_date' => ['required', 'date'],
        'hourly_rate' => ['nullable', 'numeric', 'min:0'],
        'status' => ['required', Rule::enum(EmployeeStatus::class)],
    ];
}
```

## Authentication & Profile

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Dashboard

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Users

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Roles

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Permissions

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Branches

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Employees

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Employee Documents

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Clients

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Care Plans

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Funders

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Ratesheets

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Rotas

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Shift Templates

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Recurring Rotas

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Holiday Calendar

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Schedules

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Activities

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Timesheets

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Leaves

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Forms

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Media Manager

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Medicine Management

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Invoices

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Invoice Payments

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Salary Management

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Reports

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Export Center

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Messages

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Notifications

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Activity Logs

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Settings

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## System Configuration

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Trash & Restore

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Global Search

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.

## Bulk Actions

Common validation:

- `uuid`: must exist for detail/update/delete routes.
- `branch_id`: required where the module is branch-owned and must be accessible to the authenticated user.
- `status`: must be a valid enum value.
- Date/time fields must be valid and in chronological order.
- Foreign keys must exist and belong to the same branch where applicable.


## Status enum examples

### Activity

- `pending`
- `approved`
- `in_progress`
- `completed`
- `cancelled`
- `rejected`

### Schedule

- `pending`
- `running`
- `completed`
- `cancelled`

### Leave

- `pending`
- `approved`
- `rejected`

### Invoice

- `draft`
- `pending`
- `paid`
- `partially_paid`
- `cancelled`

### Form

- `draft`
- `published`
- `archived`

### Employee/Client

- `active`
- `inactive`
- `suspended`
- `archived`

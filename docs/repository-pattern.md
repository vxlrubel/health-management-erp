# Repository Pattern

Repositories isolate query and persistence logic from services. Use them to keep services focused on business workflows and to make repeated queries consistent.

## Rules

- Every main model has a repository interface and Eloquent implementation.
- Repositories may return `Builder`, `Model`, `Collection`, `LengthAwarePaginator` or typed DTOs.
- Repositories should expose branch-aware queries.
- Repositories should not contain business decisions; use services for rules.

## Example interface

```php
interface EmployeeRepositoryInterface
{
    public function queryForUser(User $user): Builder;
    public function paginate(array $filters, User $user): LengthAwarePaginator;
    public function findByUuid(string $uuid, User $user): Employee;
    public function create(array $data): Employee;
    public function update(Employee $employee, array $data): Employee;
}
```

## Common repository methods

- `query()`
- `queryForUser(User $user)`
- `paginate(array $filters, User $user)`
- `findById(int $id)`
- `findByUuid(string $uuid, User $user)`
- `create(array $data)`
- `update(Model $model, array $data)`
- `softDelete(Model $model, User $actor)`
- `restore(string $uuid, User $actor)`
- `forceDelete(string $uuid, User $actor)`
- `exportQuery(array $filters, User $user)`

## Branch scope pattern

```php
public function queryForUser(User $user): Builder
{
    $query = Employee::query();

    if (! $user->hasRole('Super Admin')) {
        $query->whereIn('branch_id', $user->accessibleBranchIds());
    }

    return $query;
}
```

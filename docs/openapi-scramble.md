# OpenAPI / Scramble

Use Scramble to generate API documentation for the Laravel API.

## Goals

- Keep API docs generated from real route/controller/request/resource code.
- Document every endpoint, query parameter, request body and response.
- Show authentication requirements.
- Show validation errors and business-rule errors.
- Group endpoints by module.

## Installation

```bash
composer require dedoc/scramble
```

## Configuration

- Base path: `/api/v1`
- Auth scheme: Bearer token for Laravel Sanctum.
- Group endpoints by controller/module.
- Hide internal-only routes in production if required.

## Controller documentation rules

Each controller method should include:

- Summary.
- Description.
- Permission required.
- Query parameters.
- Request body schema.
- Success response schema.
- Validation error response.
- Authorization error response.

## Example docblock

```php
/**
 * Create employee
 *
 * Creates a new employee inside the authenticated user's accessible branch.
 * Requires permission: employees.create
 */
public function store(StoreEmployeeRequest $request): JsonResponse
{
    $employee = $this->employeeService->create($request->validated(), $request->user());

    return $this->successResponse(new EmployeeResource($employee), 'Employee created successfully.', 201);
}
```

## Documentation completeness checklist

- Auth endpoints documented.
- Every module endpoint documented.
- Every custom workflow endpoint documented.
- Request examples included.
- Response examples included.
- Error examples included.
- Enum values documented.
- Pagination/filter/sort parameters documented.
- File upload endpoints documented.
- Export endpoints documented.

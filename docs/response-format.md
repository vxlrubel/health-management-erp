# API Response Format

All endpoints return JSON. The response shape must remain stable across modules.

## Success response

```json
{
  "success": true,
  "message": "Employee created successfully.",
  "data": {}
}
```

## List response

```json
{
  "success": true,
  "message": "Employees retrieved successfully.",
  "data": [],
  "meta": {
    "current_page": 1,
    "from": 1,
    "last_page": 5,
    "per_page": 15,
    "to": 15,
    "total": 75
  },
  "links": {
    "first": "...",
    "last": "...",
    "prev": null,
    "next": "..."
  }
}
```

## Validation error

HTTP status: `422`

```json
{
  "success": false,
  "message": "Validation failed.",
  "errors": {
    "email": ["The email field is required."]
  }
}
```

## Authorization error

HTTP status: `403`

```json
{
  "success": false,
  "message": "You are not authorized to perform this action."
}
```

## Not found error

HTTP status: `404`

```json
{
  "success": false,
  "message": "Resource not found."
}
```

## Server error

HTTP status: `500`

```json
{
  "success": false,
  "message": "Something went wrong."
}
```

## Status code rules

| Action | Status |
|---|---:|
| List/detail success | 200 |
| Create success | 201 |
| Update success | 200 |
| Delete success | 200 |
| Restore success | 200 |
| Permanent delete success | 200 |
| Validation failed | 422 |
| Unauthenticated | 401 |
| Unauthorized | 403 |
| Not found | 404 |
| Conflict/business rule failure | 409 |
| Server error | 500 |

## Response implementation helper

Create a reusable trait or helper such as `ApiResponse` with:

- `successResponse($data = null, string $message = 'Success', int $status = 200)`
- `errorResponse(string $message, int $status = 400, array $errors = [])`
- `paginatedResponse($resourceCollection, string $message = 'Success')`

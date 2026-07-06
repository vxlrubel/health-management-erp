# Folder Structure

The project should use a clear Laravel structure that separates HTTP, domain logic, persistence, events, jobs and documentation.

```text
app/
├── Actions/
├── Console/
│   └── Commands/
├── Enums/
├── Events/
├── Exceptions/
├── Helpers/
├── Http/
│   ├── Controllers/
│   │   └── Api/
│   │       └── V1/
│   ├── Middleware/
│   ├── Requests/
│   └── Resources/
├── Jobs/
├── Listeners/
├── Mail/
├── Models/
├── Notifications/
├── Observers/
├── Policies/
├── Providers/
├── Repositories/
│   ├── Contracts/
│   └── Eloquent/
├── Services/
├── Support/
└── Traits/
bootstrap/
config/
database/
├── factories/
├── migrations/
└── seeders/
routes/
├── api.php
└── api_v1.php
storage/
tests/
├── Feature/
└── Unit/
docs/
```

## Controller location

Controllers belong in:

```text
app/Http/Controllers/Api/V1
```

Example:

```text
app/Http/Controllers/Api/V1/EmployeeController.php
app/Http/Controllers/Api/V1/ScheduleController.php
app/Http/Controllers/Api/V1/InvoiceController.php
```

## Request validation location

```text
app/Http/Requests/V1/{Module}/Store{Model}Request.php
app/Http/Requests/V1/{Module}/Update{Model}Request.php
app/Http/Requests/V1/{Module}/Index{Model}Request.php
```

## Resource location

```text
app/Http/Resources/V1/{Model}Resource.php
app/Http/Resources/V1/{Model}Collection.php
```

## Service location

```text
app/Services/{Module}/{Model}Service.php
```

## Repository location

```text
app/Repositories/Contracts/{Model}RepositoryInterface.php
app/Repositories/Eloquent/{Model}Repository.php
```

## Policy location

```text
app/Policies/{Model}Policy.php
```

## Module naming rules

- Controllers are singular model names: `EmployeeController`.
- Services are singular model names: `EmployeeService`.
- Repositories are singular model names: `EmployeeRepository`.
- API routes are plural kebab-case: `/employees`, `/care-plans`.
- Permission names are `{module}.{action}` such as `employees.create`.
- FormRequest classes use action prefixes: `StoreEmployeeRequest`, `UpdateEmployeeRequest`, `GenerateSalaryRequest`.

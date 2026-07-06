# Settings

Settings store company and application configuration.

## Groups

- Items per page
- Default hourly rate
- Company information
- Invoice settings
- Email settings
- SMS settings
- Timezone
- Currency
- Logo
- Notification settings
- Backup settings
- Payroll settings

## Field rules

- `key` must be unique.
- `group` controls admin UI grouping.
- `type` controls validation and casting.
- `is_public` controls whether a setting can be exposed through API to frontend apps.

## Endpoints

- `GET /settings`
- `PUT /settings`

## Rules

- Sensitive settings must not be exposed through public APIs.
- Settings updates must be activity logged.
- Configuration that impacts payroll/invoices should be versioned or logged clearly.

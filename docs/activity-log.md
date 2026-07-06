# Activity Log

Use Spatie Activitylog for audit history.

## Loggable actions

- Login
- Logout
- Password change
- Create
- Update
- Delete
- Restore
- Force delete
- Approve/reject
- Assign/unassign
- Import/export
- Publish/archive
- Payment received
- Salary generated
- Invoice generated

## Required payload

Each activity log should include:

- Actor user ID
- Actor name/email
- Event name
- Subject model and UUID
- Old values where relevant
- New values where relevant
- Branch ID where relevant
- IP address
- User agent
- Request ID if available

## Sensitive data

Never log raw passwords, tokens, full bank details or complete medical notes. Mask sensitive values.

## API endpoints

- `GET /activity-logs`
- `GET /activity-logs/{uuid}`

## Retention

Define retention in settings. Production systems often retain audit logs longer than application logs.

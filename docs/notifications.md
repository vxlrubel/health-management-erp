# Notifications

Notifications can be database, email or push. Database notifications are required; email/push are optional per setting.

## Channels

- Database notification
- Email notification
- Push notification

## Notification events

| Notification | Recipient | Trigger |
|---|---|---|
| Employee assigned to client | Employee | Client assignment created. |
| Schedule created | Employee | Schedule created/generated. |
| Schedule changed | Employee/client | Schedule updated or cancelled. |
| Leave requested | Branch manager/HR | Employee submits leave. |
| Leave approved/rejected | Employee | Leave decision made. |
| Activity requires approval | Manager | Activity completed. |
| Invoice generated | Client/funder/admin | Invoice created. |
| Invoice paid | Finance/admin | Payment recorded. |
| Salary generated | HR/finance | Salary draft created. |
| Document expiring soon | Employee/HR | Scheduled document expiry check. |
| Form assigned | Target users | Form assigned. |
| Form submitted | Reviewer | Form submission received. |

## API endpoints

- `GET /notifications`
- `PUT /notifications/read`
- `PUT /notifications/read-all`

## Rules

- Notification delivery should be queued.
- Users should only see their own notifications.
- Notification payload should include `type`, `title`, `message`, `module`, `resource_uuid` and optional `action_url` for frontend usage.
- Mark-read endpoints must not expose other users' notifications.

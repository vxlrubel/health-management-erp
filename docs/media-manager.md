# Media Manager

The media manager handles uploads, attachments and document libraries using Spatie Media Library.

## Supported collections

- `employee_documents`
- `client_documents`
- `forms`
- `reports`
- `invoices`
- `profile_avatars`
- `general`

## Upload rules

- Validate file size.
- Validate MIME type.
- Validate collection name.
- Validate target model ownership and permission.
- Store media metadata.
- Log upload and delete actions.

## Endpoints

- `GET /media`
- `POST /media`
- `GET /media/{{uuid}}`
- `DELETE /media/{{uuid}}`
- `GET /media/{{uuid}}/download`

## Security rules

- Sensitive employee/client documents require explicit permission.
- Media must be branch-scoped through the parent model.
- Public URLs must not be generated for private documents unless signed and time-limited.

# Care Plan

Care plans store client care information such as summary, goals, risks and effective dates.

## Fields

- Client
- Title
- Summary
- Goals
- Risks
- Effective from
- Effective to
- Status

## Statuses

- `draft`
- `active`
- `archived`

## Endpoints

- `GET /care-plans`
- `POST /care-plans`
- `GET /care-plans/{{uuid}}`
- `PUT /care-plans/{{uuid}}`
- `DELETE /care-plans/{{uuid}}`

## Business rules

- Care plan must belong to a client.
- Client branch access controls care plan access.
- Active care plan must be visible only to authorized staff assigned to the client.
- Care plan changes must be activity logged.

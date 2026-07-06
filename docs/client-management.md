# Client Management

Client management covers client profiles, funder relationships, care plans, assignments and visibility rules.

## Main data

- Branch
- Funder
- Name
- Date of birth
- Contact details
- Address
- Care level/plan
- Status
- Next of kin

## Assignment rules

- Clients can have many employees.
- Employees can have many clients.
- Assignment dates define active/inactive assignment.
- Primary assignment should be unique when enabled.
- Employee and client must belong to compatible branch access.

## Endpoints

- `GET /clients`
- `POST /clients`
- `GET /clients/{{uuid}}`
- `PUT /clients/{{uuid}}`
- `DELETE /clients/{{uuid}}`
- `GET /clients/{{uuid}}/activities`
- `GET /clients/{{uuid}}/employees`
- `GET /clients/{{uuid}}/reports`

## Rules

- Inactive clients cannot receive new schedules.
- Clients see only their own information.
- Funders see only clients they fund.
- Staff visibility can be restricted to assigned clients.

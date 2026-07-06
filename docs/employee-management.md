# Employee Management

Employee management covers staff profile, branch assignment, documents, client assignment and HR workflows.

## Main data

- Branch
- Linked user account
- Employee number
- Name
- Contact information
- Date of birth
- Gender
- Joining date
- Employment type
- Hourly rate
- Salary type
- Status
- Emergency contact

## Documents

- Passport
- Certificate
- Contract
- CV
- Training evidence
- Other HR documents

## Endpoints

- `GET /employees`
- `POST /employees`
- `GET /employees/{{uuid}}`
- `PUT /employees/{{uuid}}`
- `DELETE /employees/{{uuid}}`
- `POST /employees/{{uuid}}/assign-client`
- `DELETE /employees/{{uuid}}/remove-client/{{client_uuid}}`
- `GET /employees/{{uuid}}/activities`
- `GET /employees/{{uuid}}/schedules`
- `GET /employees/{{uuid}}/salary`
- `GET /employees/{{uuid}}/reports`

## Rules

- Employee email and number must be unique.
- Suspended/inactive employees cannot receive new schedules.
- Employee hourly rate is required for payroll if salary uses hourly calculation.
- Document verification must be auditable.

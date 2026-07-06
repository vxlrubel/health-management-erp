# Medicine Management

Medicine management stores client medicines and administration history.

## Medicine fields

- Client
- Medicine name
- Dosage
- Frequency
- Route
- Start date
- End date
- Prescribed by
- Status

## Administration fields

- Medicine
- Client
- Employee
- Administered at
- Dose given
- Status
- Notes

## Endpoints

- `GET /medicines`
- `POST /medicines`
- `GET /medicines/{{uuid}}`
- `PUT /medicines/{{uuid}}`
- `DELETE /medicines/{{uuid}}`
- `POST /medicines/{{uuid}}/administrations`
- `GET /medicines/{{uuid}}/administrations`

## Rules

- Only authorized staff assigned to the client can view/administer medicines unless higher permission is granted.
- Administration time must be recorded.
- Missed/refused/administered statuses should be tracked.
- Medicine changes and administration records must be logged.

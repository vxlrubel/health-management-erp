# Invoice Management

Invoice management covers client/funder invoices, invoice items, payments, refunds and credit notes.

## Invoice types

- Client invoice
- Funder invoice
- Salary invoice where applicable

## Calculation rules

- Invoice number is generated server-side.
- Invoice items define subtotal.
- Tax and discount are calculated server-side.
- `total = subtotal + tax - discount`.
- `balance = total - paid_amount`.
- Invoice becomes `paid` when balance is zero.
- Invoice becomes `partially_paid` when paid amount is greater than zero and less than total.

## Statuses

- `draft`
- `pending`
- `paid`
- `partially_paid`
- `cancelled`

## Endpoints

- `GET /invoices`
- `POST /invoices`
- `GET /invoices/{{uuid}}`
- `PUT /invoices/{{uuid}}`
- `DELETE /invoices/{{uuid}}`
- `POST /invoices/{{uuid}}/pay`
- `POST /invoices/{{uuid}}/cancel`
- `GET /invoices/export`

## Business rules

- Paid invoices should be locked from destructive changes.
- Payments cannot exceed balance unless overpayment is enabled.
- Cancelled invoices must not count as revenue.
- Payment and cancellation events must be logged.

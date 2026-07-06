# Reports

Reports must respect branch isolation and permission rules.

## Report types

- Dashboard report
- Employee report
- Client report
- Salary report
- Invoice report
- Activity report
- Schedule report
- Leave report
- Branch report
- Revenue report
- Attendance report
- Staff performance report
- Branch performance report
- Client statistics report

## Export formats

- PDF
- Excel
- CSV

## API endpoints

- `GET /api/v1/reports/dashboard`
- `GET /api/v1/reports/activity`
- `GET /api/v1/reports/schedule`
- `GET /api/v1/reports/employee`
- `GET /api/v1/reports/client`
- `GET /api/v1/reports/invoice`
- `GET /api/v1/reports/salary`
- `GET /api/v1/reports/leave`
- `GET /api/v1/reports/export/pdf`
- `GET /api/v1/reports/export/excel`

## Common filters

- `branch_id`
- `employee_id`
- `client_id`
- `funder_id`
- `status`
- `date_from`
- `date_to`
- `group_by`
- `export_format`

## Rules

- Large exports must be queued.
- Non-Super Admin users can only report on accessible branches.
- Reports should use date range filters by default to avoid full-table scans.
- PDF exports should use DomPDF/Browsershot.
- Excel/CSV exports should use Laravel Excel.

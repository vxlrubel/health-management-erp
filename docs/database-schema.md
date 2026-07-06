# Database Schema

This file defines the main database tables for the Health Management ERP API. The schema is designed for MySQL with Laravel migrations.

## Global conventions

- Primary key: `id` as unsigned bigint.
- Public identifier: `uuid` where the table is exposed through API.
- Soft deletes: `deleted_at` on all master and transactional tables where recovery is useful.
- Audit fields: `created_by`, `updated_by`, `deleted_by` where the table is user-managed.
- Timestamps: `created_at`, `updated_at` on every table.
- Foreign keys should use `restrictOnDelete()` for master data unless domain rules require cascade.
- All money columns should use `decimal(12,2)`.
- Time duration values should be stored as decimal hours or integer minutes consistently.
- JSON columns should use casts and never store unvalidated arbitrary frontend data.

## `users`

Fields:

- `id`
- `uuid`
- `branch_id (FK nullable)`
- `role_id (FK)`
- `name`
- `email (unique)`
- `password`
- `phone`
- `avatar`
- `status`
- `last_login_at`
- `remember_token`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `branches`

Fields:

- `id`
- `uuid`
- `name`
- `code (unique)`
- `description`
- `address`
- `city`
- `postcode`
- `phone`
- `email`
- `manager_id (FK users nullable)`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `roles`

Fields:

- `id`
- `name (unique)`
- `guard_name`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `permissions`

Fields:

- `id`
- `name (unique)`
- `guard_name`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `employees`

Fields:

- `id`
- `uuid`
- `branch_id (FK)`
- `user_id (FK nullable)`
- `employee_no (unique)`
- `first_name`
- `last_name`
- `email`
- `phone`
- `dob`
- `gender`
- `address`
- `joining_date`
- `employment_type`
- `hourly_rate`
- `salary_type`
- `status`
- `emergency_contact_name`
- `emergency_contact_phone`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `employee_documents`

Fields:

- `id`
- `uuid`
- `employee_id (FK)`
- `type`
- `title`
- `file_path`
- `expiry_date`
- `is_verified`
- `verified_by`
- `verified_at`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `clients`

Fields:

- `id`
- `uuid`
- `branch_id (FK)`
- `funder_id (FK nullable)`
- `client_no (unique)`
- `first_name`
- `last_name`
- `dob`
- `email`
- `phone`
- `address`
- `care_level`
- `status`
- `next_of_kin_name`
- `next_of_kin_phone`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `client_employee`

Fields:

- `id`
- `client_id (FK)`
- `employee_id (FK)`
- `assigned_from`
- `assigned_to`
- `is_primary`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `funders`

Fields:

- `id`
- `uuid`
- `name`
- `email`
- `phone`
- `address`
- `status`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `care_plans`

Fields:

- `id`
- `uuid`
- `client_id (FK)`
- `title`
- `summary`
- `goals`
- `risks`
- `effective_from`
- `effective_to`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `ratesheets`

Fields:

- `id`
- `uuid`
- `branch_id (FK)`
- `name`
- `description`
- `hourly_rate`
- `weekend_rate`
- `holiday_rate`
- `night_rate`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `rotas`

Fields:

- `id`
- `uuid`
- `branch_id (FK)`
- `ratesheet_id (FK nullable)`
- `name`
- `start_date`
- `end_date`
- `start_time`
- `end_time`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `shift_templates`

Fields:

- `id`
- `uuid`
- `branch_id (FK)`
- `name`
- `start_time`
- `end_time`
- `planned_hours`
- `break_minutes`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `recurring_rotas`

Fields:

- `id`
- `uuid`
- `branch_id (FK)`
- `rota_id (FK)`
- `shift_template_id (FK)`
- `frequency`
- `days_of_week`
- `start_date`
- `end_date`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `holiday_calendar`

Fields:

- `id`
- `uuid`
- `branch_id (FK nullable)`
- `name`
- `holiday_date`
- `type`
- `is_paid`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `schedules`

Fields:

- `id`
- `uuid`
- `rota_id (FK nullable)`
- `employee_id (FK)`
- `client_id (FK)`
- `branch_id (FK)`
- `start_datetime`
- `end_datetime`
- `planned_hours`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `activities`

Fields:

- `id`
- `uuid`
- `schedule_id (FK nullable)`
- `employee_id (FK)`
- `client_id (FK)`
- `branch_id (FK)`
- `activity_type`
- `notes`
- `start_datetime`
- `end_datetime`
- `actual_hours`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `timesheets`

Fields:

- `id`
- `uuid`
- `employee_id (FK)`
- `branch_id (FK)`
- `period_start`
- `period_end`
- `regular_hours`
- `overtime_hours`
- `holiday_hours`
- `status`
- `approved_by`
- `approved_at`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `leaves`

Fields:

- `id`
- `uuid`
- `employee_id (FK)`
- `leave_type`
- `reason`
- `start_date`
- `end_date`
- `status`
- `approved_by`
- `approved_at`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `forms`

Fields:

- `id`
- `uuid`
- `branch_id (FK nullable)`
- `name`
- `description`
- `schema_json`
- `status`
- `published_at`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `form_submissions`

Fields:

- `id`
- `uuid`
- `form_id (FK)`
- `submitted_by`
- `subject_type`
- `subject_id`
- `answers_json`
- `status`
- `submitted_at`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `medicines`

Fields:

- `id`
- `uuid`
- `client_id (FK)`
- `name`
- `dosage`
- `frequency`
- `route`
- `start_date`
- `end_date`
- `prescribed_by`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `medicine_administrations`

Fields:

- `id`
- `uuid`
- `medicine_id (FK)`
- `client_id (FK)`
- `employee_id (FK)`
- `administered_at`
- `dose_given`
- `status`
- `notes`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `invoices`

Fields:

- `id`
- `uuid`
- `invoice_number (unique)`
- `invoice_type`
- `employee_id (FK nullable)`
- `client_id (FK nullable)`
- `funder_id (FK nullable)`
- `amount`
- `tax`
- `discount`
- `total`
- `paid_amount`
- `balance`
- `status`
- `due_date`
- `paid_date`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `invoice_items`

Fields:

- `id`
- `uuid`
- `invoice_id (FK)`
- `description`
- `quantity`
- `unit_price`
- `tax`
- `discount`
- `total`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `invoice_payments`

Fields:

- `id`
- `uuid`
- `invoice_id (FK)`
- `amount`
- `payment_date`
- `payment_method`
- `reference`
- `status`
- `created_by`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `salary_records`

Fields:

- `id`
- `uuid`
- `employee_id (FK)`
- `branch_id (FK)`
- `month`
- `working_hours`
- `hourly_rate`
- `overtime`
- `bonus`
- `deduction`
- `net_salary`
- `status`
- `created_by`
- `updated_by`
- `deleted_by`
- `created_at`
- `updated_at`
- `deleted_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `media`

Fields:

- `id`
- `model_type`
- `model_id`
- `uuid`
- `collection_name`
- `name`
- `file_name`
- `mime_type`
- `disk`
- `size`
- `manipulations`
- `custom_properties`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `messages`

Fields:

- `id`
- `uuid`
- `conversation_id`
- `sender_id`
- `body`
- `read_at`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `notifications`

Fields:

- `id`
- `type`
- `notifiable_type`
- `notifiable_id`
- `data`
- `read_at`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `activity_logs`

Fields:

- `id`
- `log_name`
- `description`
- `subject_type`
- `subject_id`
- `causer_type`
- `causer_id`
- `properties`
- `event`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `settings`

Fields:

- `id`
- `key (unique)`
- `group`
- `name`
- `description`
- `value`
- `type`
- `is_public`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.

## `reports`

Fields:

- `id`
- `uuid`
- `name`
- `type`
- `filters_json`
- `generated_by`
- `file_path`
- `status`
- `created_at`
- `updated_at`

Recommended indexes:

- Primary key on `id`.
- Unique index on `uuid` where present.
- Index all foreign keys.
- Index `branch_id`, `status`, `created_at` and date range fields used for reports.


## Migration implementation rules

- Create core tables first: users, roles, permissions, branches, settings, activity logs.
- Create employee/client/funder tables before schedules, activities, invoices or salary tables.
- Use indexes on report-heavy fields: `branch_id`, `employee_id`, `client_id`, `status`, `start_datetime`, `end_datetime`, `created_at`.
- Use composite indexes for common queries such as `(branch_id, status)`, `(employee_id, start_datetime)`, `(client_id, start_datetime)`, `(invoice_id, status)`.
- Add database constraints for required foreign keys.
- Use application-level validation for complex branch ownership rules.

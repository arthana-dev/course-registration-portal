# Database notes

The project uses two business tables:

- `courses`: one row per course.
- `registrations`: one row per student registration.

Relationship:
- `registrations.course_id` is a foreign key to `courses.id`.
- One course has many registrations.
- Each registration belongs to one course.
- A composite unique index on (`course_id`, `email`) prevents the same email from registering more than once for the same course.

Run `php artisan migrate --seed` to create and seed the tables.

To export a SQL file from phpMyAdmin:
1. Select the `course_portal` database.
2. Choose Export.
3. Select SQL format.
4. Download the `.sql` file and include it in your final submission if requested.

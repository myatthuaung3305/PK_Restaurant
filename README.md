# Pandan Kitchen

Pandan Kitchen is a small PHP + MySQL restaurant website project.
It includes:
- a landing page with menu sections,
- a feedback form,
- a report page to view feedback by date,
- and CSV export.

## Tech used
- HTML/CSS
- JavaScript (small amount in `index.html`)
- PHP (plain PHP, no framework)
- MySQL

## Main files
- `index.html` — homepage + feedback form
- `style.css` — site styling
- `feedback.php` — handles feedback submission
- `report.php` — report UI and table
- `export_csv.php` — CSV export by date range
- `csrf.php` — returns CSRF token
- `includes/config.php` — DB settings
- `includes/functions.php` — shared helper functions
- `sql/setup.sql` — database/table setup script

## Current status
This project is in a good state for a junior portfolio/demo project.
It already shows practical web dev basics:
- server-side validation,
- prepared statements,
- CSRF protection,
- basic reporting and export.

## Suggested future upgrades
- Proper admin authentication for report/export pages
- Pagination + search in report table
- Move report inline CSS into a shared stylesheet
- Better mobile responsiveness
- Add automated tests

## Run locally
Please see `README_RUN.md`.

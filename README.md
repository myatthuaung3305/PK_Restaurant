# Pandan Kitchen (Junior Full-Stack Portfolio Project)

A simple restaurant website with a feedback form and a basic report page.

## Project Scope
- **Frontend:** `index.html` + `style.css`
- **Backend:** PHP (`feedback.php`, `report.php`, `export_csv.php`, `csrf.php`)
- **Database:** MySQL table `Feedback`

## Is this good for junior level?
Yes — this is a strong **junior-level** practice project because it demonstrates:
- Multi-page structure and navigation
- Form handling
- Database CRUD (create + read)
- Basic security (prepared statements + CSRF token + escaping output)
- A small reporting feature (date filtering + CSV export)

## Improvements made in this version
To keep the project stable and interview-ready, these issues were fixed:
1. Added missing backend support files (`includes/config.php`, `includes/functions.php`, `csrf.php`).
2. Fixed broken HTML in the menu sections (unclosed tags / typo issues).
3. Added a ready-to-run SQL script (`sql/setup.sql`).
4. Rewrote setup docs with clear run instructions and troubleshooting.

## Folder Structure
```
PK_Restaurant/
├── index.html
├── style.css
├── feedback.php
├── report.php
├── export_csv.php
├── csrf.php
├── includes/
│   ├── config.php
│   └── functions.php
├── sql/
│   └── setup.sql
├── README.md
├── README_RUN.md
└── Note For Database.md
```

## Security Notes (Junior-friendly)
- Uses **prepared statements** for DB writes/reads.
- Uses `htmlspecialchars` for output escaping in report page.
- Uses **CSRF token** for feedback form submissions.
- Input validation exists on the server side.

## Next steps to make it even better
- Add authentication for report/admin page (instead of front-end prompt).
- Add pagination and search on report page.
- Add responsive/mobile improvements.
- Add unit/integration tests (or at least small validation tests).
- Move inline CSS in `report.php` into a shared stylesheet.

## Quick Start
See `README_RUN.md`.

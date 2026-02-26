# Run Guide (XAMPP / Local PHP)

## 1) Place project in web root
Copy project folder to:
- **Windows/XAMPP:** `C:\xampp\htdocs\PK_Restaurant`
- **Linux (Apache):** `/var/www/html/PK_Restaurant`

## 2) Start services
Start:
- Apache
- MySQL

## 3) Create database and table
Option A (recommended):
1. Open phpMyAdmin
2. Click **Import**
3. Import `sql/setup.sql`

Option B (manual):
1. Open SQL tab in phpMyAdmin
2. Paste SQL from `sql/setup.sql`

## 4) Configure DB credentials
Edit `includes/config.php` if your MySQL settings differ:
- `DB_HOST`
- `DB_USER`
- `DB_PASS`
- `DB_NAME`

## 5) Open app
- Home: `http://localhost/PK_Restaurant/index.html`
- Report: `http://localhost/PK_Restaurant/report.php`

## Common issues
1. **"Database connection failed"**
   - Check MySQL is running
   - Verify values in `includes/config.php`
   - Ensure DB name exists and table was created

2. **CSRF token error**
   - Ensure PHP sessions are enabled
   - Allow browser cookies on localhost

3. **Images not showing**
   - Ensure `Image/` folder exists in project root

4. **CSV export downloads empty file**
   - Try report date range with data
   - Confirm rows exist in `Feedback` table

# Pandan Kitchen v2 (upgraded)

## What changed (intern → junior)
- ✅ Prepared statements (SQL injection protection)
- ✅ Server-side validation
- ✅ CSRF protection for feedback form
- ✅ Admin login + dashboard (search, filters, pagination)
- ✅ CSV export (public + admin)

## How to run (XAMPP)
1. Copy **PandanKitchen_v2** folder into `C:\xampp\htdocs\PandanKitchen_v2`
2. Start **Apache** + **MySQL** in XAMPP.
3. Create DB + tables:
   - Open phpMyAdmin → **SQL** tab → run `sql/setup.sql`
4. If your MySQL username/password/database is different:
   - Edit `includes/config.php`

## URLs
- Website: `http://localhost/PandanKitchen_v2/index.html`
- Public Report: `http://localhost/PandanKitchen_v2/report.php`
- Admin Login: `http://localhost/PandanKitchen_v2/admin/login.php`

## Admin account
- username: `admin`
- password: `Admin@123`

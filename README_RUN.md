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

## 5) Open app (default localhost)
- Home: `http://localhost/PK_Restaurant/index.html`
- Report: `http://localhost/PK_Restaurant/report.php`

## 6) Run with a custom local domain (Apache)
If you want to access the app like a real domain (for example `http://pandan-kitchen.local`), follow these steps.

1. Copy `custom-domain.apache.conf` to your Apache virtual hosts folder.
   - Linux (Apache): usually `/etc/apache2/sites-available/`
   - XAMPP (Windows): usually `C:\xampp\apache\conf\extra\`

2. Open the file and confirm `DocumentRoot` and `<Directory ...>` match your actual project path.

3. Add a hosts file entry:
   - Windows (`C:\Windows\System32\drivers\etc\hosts`)
   - Linux/macOS (`/etc/hosts`)

   Add this line:
   ```
   127.0.0.1 pandan-kitchen.local www.pandan-kitchen.local
   ```

4. Enable virtual hosts:
   - Linux Apache:
     ```bash
     sudo a2ensite custom-domain.apache.conf
     sudo systemctl reload apache2
     ```
   - XAMPP Apache:
     - Ensure this line is enabled in `httpd.conf`:
       `Include conf/extra/httpd-vhosts.conf`
     - Paste the vhost content into `httpd-vhosts.conf`
     - Restart Apache from XAMPP Control Panel

5. Open the app using:
   - Home: `http://pandan-kitchen.local/index.html`
   - Report: `http://pandan-kitchen.local/report.php`

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

5. **Custom domain does not open**
   - Confirm hosts entry exists and has no typo
   - Confirm Apache vhost file points to the correct path
   - Restart Apache after changing vhost/hosts settings

# Pandan Kitchen

Laravel restaurant ordering system for browsing Burmese menu items, placing take out orders, and managing orders through an admin dashboard.

## Features

- Menu search and category filter
- Cart, order confirmation, receipt, and feedback flow
- Customer registration, login, profile management, and order history
- Admin dashboard with summary cards for orders, revenue, active menu items, and feedback
- Admin order status flow: `Confirmed -> Preparing -> Ready -> Completed` or `Cancelled`
- Receipt page with clearer status display and navigation
- Shared theme styling across customer and admin pages

## Tech Stack

- PHP 8.2
- Laravel 12
- Blade
- SQLite by default
- CSS and Vite

## Project Structure

- `app/Http/Controllers/` - customer and admin request handling
- `app/Models/` - menu, order, feedback, and user models
- `resources/views/` - Blade templates
- `routes/web.php` - web routes
- `public/assets/css/theme.css` - project styling

## Run Locally

1. Install PHP dependencies:

```bash
composer install
```

2. Create the environment file if needed:

```bash
copy .env.example .env
```

3. Generate the app key:

```bash
php artisan key:generate
```

4. Prepare the database and seed admin data:

```bash
php artisan migrate:fresh --seed
```

5. Start the app:

```bash
php artisan serve --host=127.0.0.1 --port=8090
```

6. Open `http://127.0.0.1:8090`

## Default Admin Account

- Email: `admin@gmail.com`
- Password: `admin12345`

## Main Routes

- `/` home page
- `/menu` menu page
- `/cart` cart page
- `/order/confirm` order confirmation
- `/receipt/{order}` order receipt
- `/orders` customer order history
- `/admin` admin dashboard

## Notes

- The project uses SQLite by default through `.env`.
- Uploaded menu images are stored under `public/assets/images/menu_uploads/`.
- Guest users can still view the receipt for the order they just placed.

## Verification

- `php -l` checked updated PHP files
- `php artisan view:cache` passed
- `php artisan test` passed

## Deployment

- `Dockerfile` and `entrypoint.sh` are included for container-based hosting
- The container uses SQLite by default and runs migrations on startup
- Set `APP_URL` and any production env values on your hosting platform

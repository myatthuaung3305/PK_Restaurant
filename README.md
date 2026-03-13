# Pandan Kitchen (Laravel)

This is a Laravel rewrite of your Pandan Kitchen project with:
- Login and Sign Up
- Take Order -> Cart -> Confirm Order -> Receipt
- Feedback form
- Admin dashboard:
  - add new menu item (image file upload)
  - view order history
  - view feedback report by date range

## Theme
Auth pages (Login / Sign Up) and main pages use your Pandan Kitchen visual theme:
- background: `#CED0C0`
- panel: `#F6F3EB`
- text: `#2E2E28`

Theme CSS location:
- `public/assets/css/theme.css`

## Default Admin Account
Seeded automatically:
- Email: `admin@pandan.test`
- Password: `admin12345`

## Project Path
`C:\Users\ASUS\Downloads\PK_Restaurant-main\pandan-kitchen-laravel`

## Run Locally
1. Install dependencies (already done):
   - `composer install`
2. Prepare DB + seed:
   - `php artisan migrate:fresh --seed`
3. Create storage link for uploads:
   - `php artisan storage:link`
4. Start server:
   - `php artisan serve --host=127.0.0.1 --port=8090`
5. Open:
   - `http://127.0.0.1:8090`

### Order Confirmation
- If a user is logged in, `customer_name` is taken automatically from the profile.
- Users only need to enter phone and optional notes on the confirm order page.

## Main Routes
- `/` Home
- `/login` Login
- `/register` Sign Up
- `/menu` Take Order
- `/cart` Cart
- `/profile` User Profile (auth only)
- `/order/confirm` Confirm Order
- `/receipt/{order}` Receipt
- `/admin` Admin Dashboard (auth + admin only)

## Assets
Images were copied from your old project into:
- `public/assets/images`

## Notes
- Database is configured with SQLite by default (`DB_CONNECTION=sqlite`).
- You can switch to MySQL by editing `.env` and running migrations again.

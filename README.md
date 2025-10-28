## Mini ERP (Laravel + Tailwind + Alpine)

A small ERP to manage products, customers, and sales, built with Laravel (MVC), Tailwind CSS, and Alpine.js. It includes a dashboard with KPIs, CRUD for products/customers, and a sales flow that decrements stock and calculates totals.

### Features

-   Dashboard: counts, revenue, recent sales, and low-stock panel
-   Products: CRUD with pagination
-   Customers: CRUD with pagination
-   Sales: create sales with multiple line items, 10% tax example, inventory decrement in a DB transaction
-   Beautiful Tailwind UI with Alpine animations (flash messages, mobile nav, dynamic sale form)

### Quick start

1. Requirements: PHP 8.2+, Composer, Node 18+, SQLite or MySQL
2. Install PHP deps: `composer install`
3. Environment:
    - Copy `.env.example` to `.env` and set `APP_KEY`, DB settings
    - For SQLite (default): ensure `database/database.sqlite` exists
4. Generate app key: `php artisan key:generate`
5. Migrate DB: `php artisan migrate`
6. Install/build assets: `npm install` then `npm run build` (or `npm run dev` for HMR)
7. Serve: `php artisan serve` and open http://localhost:8000

Root path `/` goes to the Dashboard.

### Tech notes

-   Tailwind v4 via official Vite plugin in `vite.config.js`
-   Assets: `resources/css/app.css`, `resources/js/app.js`
-   Routes: `routes/web.php`
-   Controllers: `app/Http/Controllers/*`
-   Models: `app/Models/*`
-   Views: `resources/views/*`

### Testing ideas

-   Create a product with stock 50; create a sale for qty 5; verify stock becomes 45
-   Delete a product referenced by a sale is prevented (FK restrict)

### License

MIT

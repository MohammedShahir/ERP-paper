## Mini ERP (Laravel + Tailwind + Alpine)

A small ERP to manage products, customers, and sales, built with Laravel (MVC), Tailwind CSS, and Alpine.js. It includes a dashboard with KPIs, CRUD for products/customers, and a sales flow that decrements stock and calculates totals.

### Features

-   Dashboard: counts, revenue, recent sales, and low-stock panel
-   Products: CRUD with pagination
-   Customers: CRUD with pagination
-   Sales: create sales with multiple line items, 10% tax example, inventory decrement in a DB transaction
-   Beautiful Tailwind UI with Alpine animations (flash messages, mobile nav, dynamic sale form)

# Smart Menu System - Backend API 🍽️

This is the backend for the Smart Menu System, built with Laravel 11. It manages everything a restaurant needs behind the scenes: tables, orders, kitchen queues, and billing.

## What it does

* **Multiple Users (Roles):** Different access levels for Admins, Waiters, Kitchen Staff, and Cashiers using Laravel Sanctum.
* **Order Tracking:** Follows the order from start to finish (pending -> preparing -> eady -> served -> paid).
* **Table Management:** Keeps track of table availability, capacity, and prevents double bookings.
* **Safe Billing:** Uses database transactions and soft deletes so past invoices and financial records are never lost.
* **Staff Integrations:** Provides specific endpoints for the kitchen display and the cashier's checkout system.

## Built With

* **Framework:** Laravel 11.x
* **Auth:** Laravel Sanctum
* **Database:** MySQL / PostgreSQL

## Getting Started

Follow these steps to get the project running locally:

1. **Clone the repo:**
   `ash
   git clone https://github.com/Amad-yaser/Smart-Menu-System---API.git
   cd smart-menu-system
   `

2. **Install dependencies:**
   `ash
   composer install
   `

3. **Set up the environment file:**
   Make sure you configure your database settings in the .env file!
   `ash
   cp .env.example .env
   php artisan key:generate
   `

4. **Run migrations and add test data:**
   `ash
   php artisan migrate --seed
   `

5. **Start the server:**
   `ash
   php artisan serve
   `

## Test Accounts

If you ran the seeders, you can log in with:
* **Admin:** dmin@test.com (Password: 123456)
* **Waiter:** waiter@test.com (Password: 123456)

# Smart Menu System - API

A robust, scalable RESTful API built with Laravel for managing restaurant operations. This backend powers the Smart Menu System, handling everything from table reservations and waiter orders to kitchen queues and cashier billing.

## Core Features

* Role-Based Access Control (RBAC): Secure API endpoints tailored specifically for Admin, Waiter, Kitchen, and Cashier roles using Laravel Sanctum tokens.
* Order Lifecycle Management: Tracks orders automatically through precise stages: pending -> preparing -> 
eady -> served -> paid.
* Smart Table Management: Prevents double-booking, tracks table capacity, and dynamically updates current status (available, occupied, reserved).
* Financial Integrity: Uses strict database transactions for order processing and SoftDeletes for menu items and users, ensuring historical invoices and financial reports are never lost or corrupted.
* Kitchen & Cashier Flows: Dedicated endpoints for kitchen staff to pull active orders and cashiers to generate invoices and process payments natively.

## Tech Stack

* Framework: Laravel 11.x
* Authentication: Laravel Sanctum (Token-based SPA Auth)
* Database: MySQL / PostgreSQL (Relational schema with strict foreign key constraints)

## Local Setup

1. Clone the repository:
   `ash
   git clone <your-repo-url>
   cd smart-menu-system
   `
2. Install PHP dependencies:
   `ash
   composer install
   `
3. Setup environment variables:
   `ash
   cp .env.example .env
   php artisan key:generate
   `
4. Run migrations and seed the database with test data:
   `ash
   php artisan migrate --seed
   `
5. Start the development server:
   `ash
   php artisan serve
   `

## Default Test Accounts (Seeders)
* Admin: admin@test.com (Password: 123456)
* Waiter: waiter@test.com (Password: 123456)

---
*Architected and designed for modern restaurant workflows.*

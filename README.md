<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Point of Sale System

A comprehensive Laravel-based Point of Sale (POS) system with the following features:

## Features

1. **Authentication** - Login system with user roles (Admin and Reception)
2. **Counter Management** - Users can open and close counters for sales
3. **Counter Screen** - Displays products, services, and plans
4. **Product Management** - Inventory-managed products with SKU tracking
5. **Service Management** - Services with optional service providers
6. **Plan Management** - Plans/packages that include products or services with unified pricing
7. **Service Providers** - Service providers with availability schedules
8. **Appointments** - Calendar-based appointment scheduling system
9. **Billing** - Bills can be prepaid or postpaid based on configuration
10. **Admin Panel** - Admins can manage users, receptions, billable items, service providers, webhooks, and settings

## Installation

1. Clone the repository:
```bash
git clone https://github.com/afaryab/point-of-sale.git
cd point-of-sale
```

2. Install dependencies:
```bash
composer install
npm install && npm run build
```

3. Set up environment:
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure database in `.env` file (SQLite is default)

5. Run migrations and seed data:
```bash
php artisan migrate
php artisan db:seed --class=InitialDataSeeder
```

6. Start the development server:
```bash
php artisan serve
```

## Default Credentials

After seeding, you can login with:

**Admin User:**
- Email: admin@pos.com
- Password: password

**Reception User:**
- Email: reception@pos.com
- Password: password

## Usage

### Counter Management
- Navigate to Counters section
- Create counters and open/close them
- Each counter tracks who opened it and when

### Products
- Manage inventory with quantity tracking
- Set prices and SKUs
- Mark products as active/inactive

### Services
- Create services with duration and pricing
- Optionally require service providers
- Use in appointments and billing

### Plans
- Create bundled offerings of products and services
- Set unified pricing for packages

### Appointments
- Schedule appointments for services
- Assign service providers
- Track appointment status (scheduled, confirmed, completed, cancelled)

### Billing
- Create bills at counters or standalone
- Add products, services, or plans to bills
- Support for prepaid and postpaid billing
- Mark bills as paid

### Admin Functions
- Manage service providers with availability
- Configure system settings
- Set up webhooks for external integrations

## Database Schema

The system uses the following main tables:
- `users` - System users with roles
- `counters` - Sales counters
- `products` - Inventory items
- `services` - Service offerings
- `service_providers` - Service personnel
- `plans` - Bundled offerings
- `plan_items` - Items in plans (polymorphic)
- `appointments` - Scheduled appointments
- `bills` - Sales transactions
- `bill_items` - Line items in bills (polymorphic)
- `settings` - System configuration
- `webhooks` - External integrations

## Technology Stack

- Laravel 12.x
- PHP 8.3
- Tailwind CSS
- Alpine.js
- SQLite (default, can be changed to MySQL/PostgreSQL)

## License

Licensed under the Apache License 2.0. See LICENSE file for details.


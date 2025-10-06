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

### Standard Installation

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

### Docker Installation

The application can be run in Docker containers for production deployment.

1. Build the Docker image:
```bash
docker build -t point-of-sale .
```

2. Run the container:
```bash
docker run -d -p 80:80 \
  -e APP_KEY=base64:your-app-key-here \
  -e DB_CONNECTION=sqlite \
  --name pos-app \
  point-of-sale
```

3. Access the application at `http://localhost`

#### Using Docker Compose (Coming Soon)

For easier setup with database and other services, a `docker-compose.yml` file will be provided.

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

## CI/CD

This project uses GitHub Actions for continuous integration and deployment:

### Automated Testing
- **Tests Workflow**: Runs on push to master and on all pull requests
  - Builds frontend assets with `npm run build`
  - Runs PHPUnit tests across multiple PHP versions (8.2, 8.3, 8.4)

### Pull Request Validation  
- **PR Validation Workflow**: Validates all pull requests to main/master branch
  - Ensures code quality before merging
  - Runs tests across multiple PHP versions

### Docker Image Release
- **Docker Release Workflow**: Automatically builds and publishes Docker images
  - Triggers on push to main/master branch
  - Publishes images to GitHub Container Registry (ghcr.io)
  - Tags images with branch name, commit SHA, and `latest` tag
  - Uses GitHub Actions cache for faster builds

To pull the latest Docker image:
```bash
docker pull ghcr.io/afaryab/point-of-sale:latest
```

## License

Licensed under the Apache License 2.0. See LICENSE file for details.


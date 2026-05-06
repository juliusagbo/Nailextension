# Analytics Setup Guide

This guide will help you set up and populate the database to enable the Analytics/Reports page with real data.

## Prerequisites

- XAMPP/WAMP/MAMP installed and running
- MySQL database running
- PHP 8.1 or higher
- Composer installed

## Database Setup

### Step 1: Configure Database Connection

1. Open the `.env` file in the `nailextension` directory
2. Ensure your database configuration is correct:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nailextension
DB_USERNAME=root
DB_PASSWORD=
```

### Step 2: Create Database

Open your MySQL client (phpMyAdmin or command line) and create the database:

```sql
CREATE DATABASE IF NOT EXISTS nailextension CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Or run this command in your terminal:

```bash
cd nailextension
php artisan db:create
```

### Step 3: Run Migrations

This will create all necessary tables (users, services, appointments, etc.):

```bash
cd nailextension
php artisan migrate:fresh
```

### Step 4: Seed the Database

This will populate the database with:
- 1 Admin user
- 5 Service offerings
- 20 Customer accounts
- 120-180 Appointments spanning 6 months (for analytics)

```bash
php artisan db:seed
```

**OR** to do both migration and seeding in one command:

```bash
php artisan migrate:fresh --seed
```

## Login Credentials

After seeding, you can log in with:

**Admin Account:**
- Email: `admin@nailedbyvia.com`
- Password: `admin123`

## Accessing Analytics

1. Start your development server:
   ```bash
   php artisan serve
   ```

2. Open your browser and navigate to:
   ```
   http://localhost:8000/admin/login
   ```

3. Log in with the admin credentials above

4. Click on "Analytics" in the sidebar

## What Data is Generated

The seeder creates realistic data including:

### KPI Metrics
- **Total Revenue**: Calculated from completed appointments
- **Total Appointments**: Across all statuses
- **New Customers**: Recently registered users
- **Average Spend**: Revenue per appointment

### Charts
- **Monthly Revenue**: 6 months of revenue history
- **Service Locations**: Distribution of home-service vs walk-in
- **Service Performance**: Revenue by service type

### Top Customers Table
- Customer names with avatars
- Appointment count per customer
- Total spend
- Last visit date
- Loyalty tier (Gold/Silver/Bronze/New)

## Refreshing Data

If you want to reset and regenerate all data:

```bash
php artisan migrate:fresh --seed
```

**Warning:** This will delete ALL existing data and create fresh data.

## Troubleshooting

### Issue: "No data available"

**Solution:**
1. Make sure you ran the seeders: `php artisan db:seed`
2. Check if appointments have status 'completed' - analytics only shows completed appointments
3. Verify database connection in `.env` file

### Issue: "Class not found" error

**Solution:**
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Issue: Charts not displaying

**Solution:**
1. Check browser console for JavaScript errors
2. Ensure Chart.js CDN is loading (check internet connection)
3. Clear browser cache (Ctrl+Shift+R or Cmd+Shift+R)

### Issue: Database migration errors

**Solution:**
```bash
# Drop all tables and start fresh
php artisan migrate:fresh

# Then seed again
php artisan db:seed
```

## Database Structure

### Users Table
- Stores admin and customer information
- `role` field: 'admin' or 'customer'
- `status` field: 'active' or 'inactive'

### Services Table
- Available nail extension services
- Pricing, duration, category
- `location_type`: 'home-service', 'walk-in', or 'both'

### Appointments Table
- Links users with services
- `status`: 'pending', 'confirmed', 'completed', 'cancelled'
- `payment_status`: 'pending', 'partial', 'paid'
- `location_type`: 'home-service' or 'walk-in'
- `amount`: Service price (may vary from base price)

## API Endpoint

The analytics data is also available via API:

```
GET /admin/reports/api?period=month
```

Parameters:
- `period`: 'week', 'month', or 'year'

Returns JSON with all analytics data.

## Customization

### Modify Seeded Data

Edit these files to customize the seeded data:
- `database/seeders/AdminUserSeeder.php` - Admin credentials
- `database/seeders/ServiceSeeder.php` - Available services
- `database/seeders/AppointmentSeeder.php` - Appointment generation logic

After modifications, run:
```bash
php artisan migrate:fresh --seed
```

### Change Date Range

Edit `app/Http/Controllers/AnalyticsController.php` method `getMonthlyRevenue()` to change how many months of data to display.

## Support

If you encounter any issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Enable debug mode in `.env`: `APP_DEBUG=true`
3. Check database connection
4. Verify all tables exist in database

## Next Steps

After setting up analytics:
1. Explore other admin pages (Dashboard, Appointments, Services)
2. Create real appointments through the booking system
3. Real appointments will automatically appear in analytics
4. Use the search feature to find specific customers
5. Export reports as needed


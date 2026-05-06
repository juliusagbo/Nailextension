# 🚀 Quick Start - Analytics Setup

Get your analytics dashboard up and running in 3 minutes!

## Option 1: One-Click Setup (Windows)

1. Open Command Prompt in the `nailextension` folder
2. Run:
   ```cmd
   setup-analytics.bat
   ```

## Option 2: One-Click Setup (Mac/Linux)

1. Open Terminal in the `nailextension` folder
2. Run:
   ```bash
   chmod +x setup-analytics.sh
   ./setup-analytics.sh
   ```

## Option 3: Manual Setup

```bash
# Navigate to project directory
cd nailextension

# Install dependencies (if not done)
composer install

# Create .env file from example (if not done)
cp .env.example .env

# Generate application key (if not done)
php artisan key:generate

# Configure database in .env file
# DB_DATABASE=nailextension
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations and seeders
php artisan migrate:fresh --seed

# Start the server
php artisan serve
```

## Login

After setup, visit: http://localhost:8000/admin/login

**Credentials:**
- Email: `admin@nailedbyvia.com`
- Password: `admin123`

## What You'll See

The analytics dashboard will display:
- ✅ **120-180 appointments** spanning the last 6 months
- ✅ **20 sample customers** with varying activity levels
- ✅ **5 nail services** with different pricing
- ✅ Complete KPI metrics (Revenue, Appointments, New Customers, Avg Spend)
- ✅ Monthly revenue chart
- ✅ Service location distribution
- ✅ Service performance comparison
- ✅ Top customers leaderboard

## Troubleshooting

### Database Connection Error
1. Make sure MySQL/MariaDB is running in XAMPP
2. Check `.env` file has correct database credentials
3. Create database manually: `CREATE DATABASE nailextension;`

### "Class not found" Error
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
```

### Port Already in Use
```bash
# Use a different port
php artisan serve --port=8001
```

## Refresh Data

To regenerate fresh analytics data:

```bash
# Keep users, regenerate appointments only
php artisan analytics:refresh --keep-users

# Full refresh (deletes everything)
php artisan analytics:refresh
```

## Need Help?

Check the detailed guide: [ANALYTICS_SETUP.md](ANALYTICS_SETUP.md)


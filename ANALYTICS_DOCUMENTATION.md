# Analytics System Documentation

## Overview

The Analytics/Reports system provides comprehensive business insights for Nailed by Via nail extension appointments. It tracks revenue, customer behavior, service performance, and business trends.

## Database Structure

### Tables Used

1. **appointments** - Core data for analytics
   - `id` - Primary key
   - `user_id` - Foreign key to users (customers)
   - `service_id` - Foreign key to services
   - `appointment_date` - When the appointment is scheduled
   - `location_type` - 'home-service' or 'walk-in'
   - `customer_address` - Address for home services
   - `amount` - Service price charged
   - `status` - 'pending', 'confirmed', 'completed', 'cancelled'
   - `payment_status` - 'pending', 'partial', 'paid'
   - `notes` - Optional appointment notes
   - `created_at` - Used for analytics date ranges
   - `updated_at` - Last modification

2. **users** - Customer information
   - `id` - Primary key
   - `name` - Customer name
   - `email` - Contact email
   - `phone` - Contact phone
   - `role` - 'admin' or 'customer'
   - `status` - 'active' or 'inactive'
   - `created_at` - Registration date

3. **services** - Available services
   - `id` - Primary key
   - `name` - Service name
   - `description` - Service details
   - `price` - Base price
   - `duration_minutes` - Estimated duration
   - `category` - Service category
   - `location_type` - Where service is available
   - `status` - 'active' or 'inactive'

## Analytics Features

### 1. Key Performance Indicators (KPIs)

#### Total Revenue
- Calculates sum of all completed appointments
- Compares current period vs previous period
- Shows percentage change with trend indicator
- Formula: `SUM(amount) WHERE status = 'completed'`

#### Total Appointments
- Counts all completed appointments
- Period-over-period comparison
- Shows growth/decline trend
- Formula: `COUNT(*) WHERE status = 'completed'`

#### New Customers
- Tracks newly registered customers
- Compares with previous period
- Shows customer acquisition trend
- Formula: `COUNT(*) FROM users WHERE role = 'customer' AND created_at IN period`

#### Average Spend
- Average revenue per appointment
- Period comparison
- Indicates pricing trends
- Formula: `Total Revenue / Total Appointments`

### 2. Monthly Revenue Chart

**Type:** Line chart with area fill

**Data:**
- X-axis: Last 6 months (e.g., "Oct", "Nov", "Dec")
- Y-axis: Revenue in thousands (e.g., "₱15k", "₱20k")

**Calculation:**
```php
For each of the last 6 months:
  revenue = SUM(amount) 
  WHERE status = 'completed'
  AND created_at BETWEEN month_start AND month_end
```

**Purpose:** Visualizes revenue trends and seasonality

### 3. Service Locations Chart

**Type:** Doughnut chart

**Data:**
- Home Service appointments count
- Walk-in appointments count
- Percentage distribution

**Calculation:**
```php
SELECT location_type, COUNT(*) as count
FROM appointments
WHERE status = 'completed'
GROUP BY location_type
```

**Purpose:** Shows customer preference for service delivery method

### 4. Service Performance Chart

**Type:** Horizontal bar chart

**Data:**
- Service names
- Revenue per service
- Sorted by highest revenue

**Calculation:**
```php
For each service:
  revenue = SUM(appointments.amount)
  WHERE status = 'completed'
  AND service_id = service.id
ORDER BY revenue DESC
```

**Purpose:** Identifies most profitable services

### 5. Top Customers Table

**Columns:**
1. Customer name with avatar
2. Number of appointments
3. Total spend (lifetime value)
4. Last visit date
5. Loyalty tier (visual progress bar)

**Loyalty Tiers:**
- **Gold**: Score ≥ 100 (high-value customers)
- **Silver**: Score ≥ 50
- **Bronze**: Score ≥ 20
- **New**: Score < 20

**Loyalty Score Formula:**
```
score = (total_appointments × 10) + (total_spend ÷ 100)
```

**Example:**
- 8 appointments + ₱5,000 spent = (8 × 10) + (5000 ÷ 100) = 80 + 50 = 130 = Gold

## Controller Methods

### AnalyticsController.php

Located at: `app/Http/Controllers/AnalyticsController.php`

#### Main Methods

**index()**
- Returns the analytics view with all data
- Route: `GET /admin/reports`

**getAnalyticsData($period)**
- Aggregates all analytics data
- Parameters: 'week', 'month', or 'year'
- Returns array with KPIs, charts, and tables

**getKPIs($dateRange)**
- Calculates all four KPI metrics
- Includes current vs previous period comparison

**getMonthlyRevenue()**
- Generates 6 months of revenue data
- Returns months array and revenues array

**getServicePerformance($dateRange)**
- Revenue by service type
- Sorted by highest revenue first

**getServiceLocations($dateRange)**
- Distribution of home-service vs walk-in
- Includes count and percentage

**getTopCustomers($dateRange)**
- Top 10 customers by total spend
- Includes loyalty score calculation

**getAnalyticsJson(Request $request)**
- API endpoint for analytics data
- Route: `GET /admin/reports/api?period=month`

## How Analytics Calculate

### Date Ranges

**Current Period:**
```php
'month': Start of current month → End of current month
'week': Start of current week → End of current week
'year': Start of current year → End of current year
```

**Previous Period:**
```php
previous_length = current_end - current_start
previous_start = current_start - previous_length
previous_end = current_start - 1 day
```

### Status Filtering

Only **completed** appointments count toward:
- Revenue calculations
- Performance metrics
- Customer statistics

Why? Because:
- Pending appointments haven't happened yet
- Cancelled appointments generate no revenue
- Only completed = actual business performance

## Data Flow

```
Database (MySQL)
    ↓
Appointment Model
    ↓
AnalyticsController
    ↓
Blade Template (reports.blade.php)
    ↓
Chart.js Visualization
    ↓
User Browser
```

## Sample Data Generation

The `AppointmentSeeder` creates realistic data:

**Generation Logic:**
1. Loop through last 6 months
2. For each month, create 15-30 appointments (more in recent months)
3. Random distribution of:
   - Customers (from 20 seeded users)
   - Services (5 different types)
   - Locations (home-service vs walk-in)
   - Statuses (mostly completed, some pending/cancelled)
   - Amounts (service price ± variation)
4. Set `created_at` to appointment date for accurate analytics

**Result:**
- ~120-180 total appointments
- Realistic revenue progression
- Diverse customer behavior patterns
- Multiple service performance levels

## API Usage

### Get Analytics Data

```http
GET /admin/reports/api?period=month
```

**Response:**
```json
{
  "kpis": {
    "total_revenue": {
      "current": 125000,
      "previous": 110000,
      "change": 13.6,
      "formatted": "₱125,000"
    },
    "appointments": { ... },
    "new_customers": { ... },
    "avg_spend": { ... }
  },
  "monthly_revenue": {
    "months": ["May", "Jun", "Jul", "Aug", "Sep", "Oct"],
    "revenues": [85000, 92000, 88000, 115000, 120000, 125000]
  },
  "service_performance": [ ... ],
  "service_locations": [ ... ],
  "top_customers": [ ... ]
}
```

## Frontend Integration

### Chart.js Configuration

**Revenue Chart:**
```javascript
new Chart(ctx, {
  type: 'line',
  data: {
    labels: @json($analytics['monthly_revenue']['months']),
    datasets: [{
      data: @json($analytics['monthly_revenue']['revenues']),
      borderColor: '#b48b8b',
      backgroundColor: 'rgba(180, 139, 139, 0.1)'
    }]
  }
})
```

**Location Chart:**
```javascript
new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: locationData.map(item => item.name),
    datasets: [{
      data: locationData.map(item => item.count)
    }]
  }
})
```

## Search Functionality

The page includes real-time customer search:

```javascript
document.querySelector('.search-bar input').addEventListener('input', function() {
  const searchTerm = this.value.toLowerCase();
  rows.forEach(row => {
    if (row.textContent.toLowerCase().includes(searchTerm)) {
      row.style.display = '';
    } else {
      row.style.display = 'none';
    }
  });
});
```

## Mobile Responsiveness

The analytics page is fully responsive:

**Desktop (>1200px):**
- 4-column KPI grid
- 3-column chart grid
- Full table layout

**Tablet (768px-1200px):**
- 2-column KPI grid
- Single column charts
- Table scrolls horizontally

**Mobile (<768px):**
- Single column layout
- Cards replace table rows
- Touch-friendly navigation
- Sidebar transforms to drawer

## Performance Considerations

### Query Optimization

1. **Eager Loading:**
   ```php
   User::with(['appointments' => function($query) { ... }])
   ```

2. **Aggregate Functions:**
   ```php
   ->withCount(['appointments'])
   ->withSum(['appointments'], 'amount')
   ```

3. **Date Indexing:**
   - Index on `created_at` for faster date queries
   - Index on `status` for filtering

### Caching Recommendations

For production, consider caching:

```php
Cache::remember('analytics_monthly', 3600, function() {
    return $this->getMonthlyRevenue();
});
```

## Maintenance

### Adding New Metrics

1. Add method to `AnalyticsController`
2. Update `getAnalyticsData()` to include new metric
3. Add visualization to `reports.blade.php`
4. Update this documentation

### Modifying Date Ranges

Edit `getDateRange()` method:
```php
private function getDateRange($period)
{
    switch ($period) {
        case 'custom':
            return [
                'start' => Carbon::parse($request->start_date),
                'end' => Carbon::parse($request->end_date),
            ];
    }
}
```

## Troubleshooting

### No Data Showing

**Check:**
1. Appointments exist: `SELECT COUNT(*) FROM appointments`
2. Completed status: `SELECT COUNT(*) FROM appointments WHERE status = 'completed'`
3. Date range: Ensure appointments are within current month

**Solution:**
```bash
php artisan analytics:refresh
```

### Incorrect Calculations

**Check:**
1. `created_at` timestamps on appointments
2. Status values are exactly 'completed'
3. Amounts are positive numbers

**Debug:**
```php
dd($analytics); // In controller
console.log(analytics); // In JavaScript
```

### Charts Not Rendering

**Check:**
1. Chart.js CDN is loading
2. Canvas elements have IDs
3. JavaScript has no errors (F12 console)
4. Data arrays are not empty

## Security

### Access Control

Analytics are protected by:
```php
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('reports', [AnalyticsController::class, 'index']);
});
```

### Data Privacy

- Customer names are displayed (authorized admin view)
- No sensitive payment information exposed
- Phone numbers and addresses are not in analytics
- Email addresses are not displayed

## Future Enhancements

Potential additions:
1. Date range picker for custom periods
2. Export to PDF/Excel
3. Email scheduled reports
4. Predictive analytics (revenue forecasting)
5. Customer lifetime value predictions
6. Service recommendation engine
7. Peak hours analysis
8. Cancellation rate tracking
9. Payment method analytics
10. Technician performance metrics

## Related Files

- Controller: `app/Http/Controllers/AnalyticsController.php`
- View: `resources/views/admin/reports.blade.php`
- Models: `app/Models/{Appointment,User,Service}.php`
- Seeder: `database/seeders/AppointmentSeeder.php`
- Routes: `routes/web.php` (line 86-87)
- Command: `app/Console/Commands/RefreshAnalyticsData.php`

## Support

For questions or issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Enable debug mode: `APP_DEBUG=true` in `.env`
3. Review this documentation
4. Check database connection and data integrity


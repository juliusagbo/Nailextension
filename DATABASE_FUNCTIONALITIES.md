# Database & Functionalities Documentation

## Database Structure

### Settings Table

The `settings` table stores all configuration data for the application:

```sql
CREATE TABLE settings (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    key VARCHAR(255) UNIQUE NOT NULL,
    value TEXT,
    type VARCHAR(50) DEFAULT 'string',
    description TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

#### Fields Explanation:
- **id**: Unique identifier for each setting
- **key**: Setting name (e.g., 'business_name', 'business_hours')
- **value**: The actual setting value (can be string, JSON, number, boolean)
- **type**: Data type indicator ('string', 'json', 'integer', 'boolean')
- **description**: Human-readable description of the setting
- **created_at/updated_at**: Automatic timestamps

### Current Settings Stored

#### Business Information (String Type)
```
business_name        → "Nailed by Via"
contact_email        → "nailedbyvia@gmail.com"
phone_number         → "+63 912 345 6789"
business_address     → "Alegria, Cordova, Cebu, Philippines"
```

#### Business Hours (JSON Type)
```json
{
  "monday": {"open": "09:00", "close": "19:00", "closed": false},
  "tuesday": {"open": "09:00", "close": "19:00", "closed": false},
  "wednesday": {"open": "09:00", "close": "19:00", "closed": false},
  "thursday": {"open": "09:00", "close": "19:00", "closed": false},
  "friday": {"open": "09:00", "close": "19:00", "closed": false},
  "saturday": {"open": "10:00", "close": "20:00", "closed": false},
  "sunday": {"open": "00:00", "close": "00:00", "closed": true}
}
```

#### Security Settings
```
two_factor_enabled   → false (boolean)
password_min_length  → 8 (integer)
session_timeout      → 120 (integer, minutes)
```

---

## Functionalities

### 1. Settings Model (`App\Models\Settings`)

#### Methods:

**`Settings::get($key, $default = null)`**
- Retrieves a setting value by key
- Returns default value if setting doesn't exist
- Automatically caches for 1 hour
- Auto-casts based on type

```php
$businessName = Settings::get('business_name', 'Default Business');
```

**`Settings::set($key, $value, $type, $description)`**
- Creates or updates a setting
- Automatically clears cache for that key
- Supports all data types

```php
Settings::set('business_name', 'New Name', 'string', 'Business name');
```

**`Settings::getBusinessInfo()`**
- Returns array of all business information
- Includes: business_name, contact_email, phone_number, business_address

```php
$info = Settings::getBusinessInfo();
// Returns: ['business_name' => '...', 'contact_email' => '...', ...]
```

**`Settings::getBusinessHours()`**
- Returns array of business hours for all days
- Includes: open time, close time, closed status

```php
$hours = Settings::getBusinessHours();
// Returns: ['monday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false], ...]
```

**`Settings::getSecuritySettings()`**
- Returns array of security settings
- Includes: two_factor_enabled, password_min_length, session_timeout

```php
$security = Settings::getSecuritySettings();
```

**`Settings::clearCache()`**
- Clears all settings cache
- Forces fresh database reads

```php
Settings::clearCache();
```

**`Settings::getAll()`**
- Returns all settings as key-value pairs
- Cached for performance

---

### 2. Settings Controller (`App\Http\Controllers\SettingsController`)

#### Routes:

**GET `/admin/settings`** → `index()`
- Displays settings page
- Loads business info, hours, and security settings
- Passes data to view

**POST `/admin/settings/update-all`** → `updateAllSettings()`
- **NEW UNIFIED METHOD**
- Updates all settings at once
- Validates all fields
- Handles errors gracefully
- Logs activity
- Returns with success/error message

**POST `/admin/settings/business-info`** → `updateBusinessInfo()`
- Updates only business information
- (Legacy method, still available)

**POST `/admin/settings/business-hours`** → `updateBusinessHours()`
- Updates only business hours
- (Legacy method, still available)

**POST `/admin/settings/security`** → `updateSecuritySettings()`
- Updates only security settings
- (Legacy method, still available)

**GET `/admin/settings/api`** → `getSettings()`
- Returns all settings as JSON
- For API/AJAX usage

**POST `/admin/settings/reset`** → `resetToDefault()`
- Resets all settings to default values

---

### 3. Customer Controller (`App\Http\Controllers\CustomerController`)

**GET `/`** → `index()`
- Homepage controller
- Fetches business info and hours from Settings
- Passes to welcome.blade.php view
- Ensures welcome page always shows current settings

---

### 4. Artisan Commands

#### `php artisan settings:show`
- Displays all current settings in formatted tables
- Shows business info, hours, and security settings
- **Options:**
  - `--raw`: Show raw database values

```bash
php artisan settings:show
php artisan settings:show --raw
```

#### `php artisan settings:refresh`
- Clears settings cache
- Warms up cache with fresh data
- Displays current settings
- Use after manual database changes

```bash
php artisan settings:refresh
```

#### `php artisan db:seed --class=SettingsSeeder`
- Seeds default settings into database
- Safe to run multiple times (uses updateOrCreate)
- Restores default values

```bash
php artisan db:seed --class=SettingsSeeder
```

---

### 5. Validation Rules

#### Business Information:
```php
'business_name' => 'required|string|max:255'
'contact_email' => 'required|email|max:255'
'phone_number' => 'required|string|max:20'
'business_address' => 'required|string|max:500'
```

#### Business Hours:
```php
'{day}_open' => 'required|date_format:H:i'    // 24-hour format
'{day}_close' => 'required|date_format:H:i'
'{day}_closed' => 'boolean'                    // checkbox
```

#### Security:
```php
'current_password' => 'required_with:new_password|current_password'
'new_password' => 'nullable|confirmed|min:8'
'password_min_length' => 'required|integer|min:6|max:20'
'session_timeout' => 'required|integer|min:30|max:480'
```

---

### 6. Cache Management

**Cache Keys:**
- `setting.{key}` - Individual setting cache
- `settings.all` - All settings cache

**Cache Duration:** 1 hour (3600 seconds)

**Auto-Clear Events:**
- When Settings::set() is called
- When Settings::clearCache() is called
- Via artisan settings:refresh command

---

### 7. Activity Logging

All settings updates are logged with:
- Action type: 'UPDATED SETTINGS'
- Description: What was updated
- Old values
- New values
- Timestamp
- User who made the change

View logs: Admin → Activity Log

---

## Data Flow Diagrams

### Settings Update Flow:
```
Admin fills form
    ↓
Clicks "Save All Settings"
    ↓
POST /admin/settings/update-all
    ↓
SettingsController@updateAllSettings
    ↓
Validate all fields
    ↓
Try-Catch block:
    ├─ Success: Update all settings
    │   ├─ Business Info (4 settings)
    │   ├─ Business Hours (JSON)
    │   └─ Security (3 settings)
    ├─ Clear cache
    ├─ Log activity
    └─ Return success message
    ↓
Or catch errors:
    ├─ ValidationException → Show errors
    └─ Exception → Log error, show generic message
    ↓
Redirect back to settings page
```

### Welcome Page Display Flow:
```
Customer visits homepage (/)
    ↓
CustomerController@index
    ↓
Fetch from cache (or database if cache miss):
    ├─ Settings::getBusinessInfo()
    └─ Settings::getBusinessHours()
    ↓
Pass to welcome.blade.php
    ↓
Template renders footer:
    ├─ Business contact info
    └─ Business hours (formatted)
    ↓
Display to customer
```

---

## Error Handling

### Validation Errors
- Displayed at top of form
- Individual field errors highlighted
- Form data preserved (old input)
- Red error message box

### Database Errors
- Caught and logged
- Generic error message shown to user
- Original values preserved
- User can retry

### Cache Errors
- Gracefully fall back to database
- Automatic retry mechanism
- Logged for debugging

---

## Testing

### Manual Testing:
1. Go to Admin → Settings
2. Change any value
3. Click "Save All Settings"
4. Verify success message
5. Check welcome page footer
6. Confirm changes are visible

### Command Line Testing:
```bash
# View current settings
php artisan settings:show

# Make changes via admin panel

# Refresh and verify
php artisan settings:refresh

# Check raw database
php artisan settings:show --raw
```

### Database Testing:
```bash
# Run seeder
php artisan db:seed --class=SettingsSeeder

# Verify settings
php artisan settings:show
```

---

## Performance Optimization

### Caching Strategy:
1. **First Request**: Database query → Store in cache
2. **Subsequent Requests**: Serve from cache (fast)
3. **After Update**: Clear cache → Force fresh read
4. **After 1 Hour**: Auto-expire → Fresh read

### Database Indexes:
- Primary key on `id`
- Unique index on `key` (fast lookups)

### Query Optimization:
- Single query per setting type (getBusinessInfo, getBusinessHours)
- Batch updates in transactions
- Minimal database roundtrips

---

## Security Features

### Authentication:
- Admin middleware required for all settings routes
- CSRF protection on all forms
- Session-based authentication

### Validation:
- Server-side validation on all inputs
- Type checking (email, integer, boolean)
- Length limits on strings
- Range limits on numbers

### Activity Logging:
- All changes tracked
- User identification
- Timestamp recording
- Old/new value comparison

### Password Security:
- Current password required to change
- Minimum length enforcement
- Confirmation required
- Hashed storage

---

## Troubleshooting

### Settings Not Updating?
```bash
# Clear all caches
php artisan cache:clear
php artisan settings:refresh

# Check database
php artisan settings:show --raw
```

### Welcome Page Not Showing Changes?
```bash
# Refresh settings cache
php artisan settings:refresh

# Hard refresh browser (Ctrl + F5)
```

### Database Issues?
```bash
# Re-seed settings
php artisan db:seed --class=SettingsSeeder

# Check migration status
php artisan migrate:status
```

---

## API Usage

### Get All Settings (JSON):
```javascript
fetch('/admin/settings/api')
    .then(response => response.json())
    .then(data => {
        console.log(data.business_info);
        console.log(data.business_hours);
        console.log(data.security_settings);
    });
```

### Update Settings (AJAX):
```javascript
const formData = new FormData(document.querySelector('form'));

fetch('/admin/settings/update-all', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': document.querySelector('[name="_token"]').value
    },
    body: formData
})
.then(response => response.json())
.then(data => {
    // Handle response
});
```

---

## Summary

✅ **Database:** Properly structured with settings table
✅ **Model:** Settings model with helper methods and caching
✅ **Controller:** Unified update method with validation and error handling
✅ **Views:** Admin settings page and customer welcome page integration
✅ **Commands:** CLI tools for viewing and refreshing settings
✅ **Validation:** Comprehensive input validation
✅ **Logging:** Activity logging for audit trail
✅ **Caching:** Performance optimization with automatic cache management
✅ **Security:** Authentication, CSRF protection, password validation
✅ **Error Handling:** Try-catch blocks with user-friendly messages

The database and functionalities are fully implemented and production-ready! 🎉

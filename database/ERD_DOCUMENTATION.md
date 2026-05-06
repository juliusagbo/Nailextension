# Nailed by Via - Database ERD Documentation

## 📁 ERD File Location
**File:** `database/ERD_Nailed_by_Via.drawio`

## 🎯 How to Open the ERD

### Option 1: Draw.io (Recommended)
1. Go to [https://app.diagrams.net/](https://app.diagrams.net/)
2. Click "Open Existing Diagram"
3. Upload the file: `database/ERD_Nailed_by_Via.drawio`
4. The ERD will load with all tables and relationships

### Option 2: VS Code Extension
1. Install "Draw.io Integration" extension in VS Code
2. Open the `.drawio` file
3. Edit and view directly in VS Code

### Option 3: Desktop App
1. Download Draw.io desktop app
2. Open the `.drawio` file
3. Edit and export in various formats

---

## 🗄️ Database Overview

### Total Tables: 10
- **Main Business Tables:** 7
- **System Tables:** 3

### Database Type: SQLite
### Framework: Laravel

---

## 📊 Table Details

### 1. **users** (Primary Entity)
**Purpose:** Store customer and admin user information

**Key Fields:**
- `id` (PK) - Primary key
- `email` (UK) - Unique email address
- `name` - User's full name
- `role` - 'customer' or 'admin'
- `phone` - Contact number
- `address` - User address
- `status` - Account status ('active', 'inactive')
- `profile_picture` - Profile image path

**Relationships:**
- 1:N → appointments
- 1:N → favorites
- 1:N → activity_logs
- 1:1 → password_reset_tokens
- 1:N → sessions

---

### 2. **services** (Service Catalog)
**Purpose:** Store nail services offered

**Key Fields:**
- `id` (PK) - Primary key
- `name` - Service name
- `description` - Service details
- `price` - Service cost (decimal)
- `duration_minutes` - Service duration
- `category` - Service category
- `location_type` - 'home-service', 'walk-in', 'both'
- `status` - 'active' or 'inactive'
- `image_url` - Service image

**Relationships:**
- 1:N → appointments
- 1:N → favorites

---

### 3. **appointments** (Core Business Entity)
**Purpose:** Store booking appointments

**Key Fields:**
- `id` (PK) - Primary key
- `user_id` (FK) → users.id
- `service_id` (FK) → services.id
- `appointment_date` - Scheduled date/time
- `location_type` - Service location
- `customer_address` - Address for home service
- `amount` - Total cost
- `status` - 'pending', 'confirmed', 'completed', 'cancelled'
- `payment_status` - 'pending', 'partial', 'paid'
- `notes` - Additional notes

**Relationships:**
- N:1 → users
- N:1 → services

---

### 4. **favorites** (User Preferences)
**Purpose:** Store user's favorite services

**Key Fields:**
- `id` (PK) - Primary key
- `user_id` (FK) → users.id
- `service_id` (FK) → services.id
- Unique constraint on (user_id, service_id)

**Relationships:**
- N:1 → users
- N:1 → services

---

### 5. **galleries** (Portfolio Management)
**Purpose:** Store portfolio images

**Key Fields:**
- `id` (PK) - Primary key
- `title` - Image title
- `description` - Image description
- `image_path` - File path
- `category` - Image category
- `is_featured` - Featured image flag
- `sort_order` - Display order
- `is_active` - Active status

---

### 6. **activity_logs** (Audit Trail)
**Purpose:** Track all system activities

**Key Fields:**
- `id` (PK) - Primary key
- `user_id` (FK) → users.id (nullable)
- `user_type` - 'admin' or 'customer'
- `action` - Action performed
- `details` - Action details
- `model_type` - Related model
- `model_id` - Related record ID
- `old_values` (JSON) - Previous values
- `new_values` (JSON) - New values

**Relationships:**
- N:1 → users (optional)

---

### 7. **settings** (Configuration)
**Purpose:** Store system configuration

**Key Fields:**
- `id` (PK) - Primary key
- `key` (UK) - Setting name
- `value` - Setting value
- `type` - Data type ('string', 'json', 'boolean', 'integer')
- `description` - Setting description

**Current Settings:**
- Business information (name, email, phone, address)
- Business hours (JSON format)
- Security settings (password rules, session timeout)

---

### 8. **cache** (Laravel Cache)
**Purpose:** Store cached data

**Key Fields:**
- `key` (PK) - Cache key
- `value` - Cached data
- `expiration` - Expiration timestamp

---

### 9. **jobs** (Laravel Queue)
**Purpose:** Store queued jobs

**Key Fields:**
- `id` (PK) - Job ID
- `queue` - Queue name
- `payload` - Job data
- `attempts` - Retry count
- `reserved_at` - When reserved
- `available_at` - When available
- `created_at` - Creation time

---

### 10. **password_reset_tokens** (Auth System)
**Purpose:** Store password reset tokens

**Key Fields:**
- `email` (PK) - User email
- `token` - Reset token
- `created_at` - Token creation time

**Relationships:**
- 1:1 → users (email)

---

### 11. **sessions** (Laravel Sessions)
**Purpose:** Store user sessions

**Key Fields:**
- `id` (PK) - Session ID
- `user_id` (FK) → users.id (nullable)
- `payload` - Session data
- `last_activity` - Last activity timestamp

**Relationships:**
- N:1 → users (optional)

---

## 🔗 Relationship Summary

### Primary Relationships
1. **Users → Appointments** (1:N)
   - One user can have many appointments
   - Each appointment belongs to one user

2. **Services → Appointments** (1:N)
   - One service can have many appointments
   - Each appointment is for one service

3. **Users → Favorites** (1:N)
   - One user can favorite many services
   - Each favorite belongs to one user

4. **Services → Favorites** (1:N)
   - One service can be favorited by many users
   - Each favorite is for one service

5. **Users → Activity Logs** (1:N)
   - One user can have many activity logs
   - Each log entry belongs to one user (optional)

6. **Users → Password Reset Tokens** (1:1)
   - One user can have one reset token
   - Each token belongs to one user

7. **Users → Sessions** (1:N)
   - One user can have many sessions
   - Each session belongs to one user (optional)

---

## 🎨 Color Coding in ERD

- 🔵 **Blue** - Users and related tables
- 🟣 **Purple** - Services and related tables
- 🟢 **Green** - Appointments and activity logs
- 🟠 **Orange** - Favorites
- 🩷 **Pink** - Galleries
- 🟡 **Yellow** - Settings
- 🔵 **Light Blue** - System tables (cache, sessions, etc.)

---

## 📈 Business Logic Flow

### Customer Journey
1. **User Registration** → users table
2. **Browse Services** → services table
3. **Book Appointment** → appointments table
4. **Add to Favorites** → favorites table
5. **View Gallery** → galleries table

### Admin Operations
1. **Manage Services** → services table
2. **View Appointments** → appointments table
3. **Update Settings** → settings table
4. **Monitor Activity** → activity_logs table
5. **Manage Gallery** → galleries table

---

## 🔧 Technical Features

### Indexes
- Primary keys on all tables
- Unique constraints on email, setting keys
- Foreign key constraints with cascade delete
- Composite unique constraint on favorites

### Data Types
- **VARCHAR** - Variable length strings
- **TEXT** - Long text content
- **BIGINT** - Large integers for IDs
- **DECIMAL** - Precise decimal numbers for prices
- **TIMESTAMP** - Date/time values
- **JSON** - Structured data (business hours, activity logs)
- **BOOLEAN** - True/false values

### Constraints
- **NOT NULL** - Required fields
- **UNIQUE** - Unique values
- **FOREIGN KEY** - Referential integrity
- **CASCADE DELETE** - Automatic cleanup
- **DEFAULT VALUES** - Fallback values

---

## 🚀 Usage Instructions

### Opening the ERD
1. Navigate to `database/ERD_Nailed_by_Via.drawio`
2. Open with Draw.io (online or desktop)
3. View, edit, or export as needed

### Exporting Options
- **PNG** - For presentations
- **PDF** - For documentation
- **SVG** - For web use
- **XML** - For editing

### Editing the ERD
1. Add new tables by copying existing table format
2. Modify relationships using the connection tools
3. Update colors and styling as needed
4. Save changes to maintain version control

---

## 📋 Maintenance

### When to Update the ERD
- Adding new tables
- Modifying existing table structure
- Changing relationships
- Adding new fields
- Removing deprecated fields

### Keeping ERD Current
1. Update ERD after migration changes
2. Sync with actual database structure
3. Document any custom modifications
4. Version control the ERD file

---

## 🎯 Summary

Your ERD file is located at:
**`database/ERD_Nailed_by_Via.drawio`**

This comprehensive Entity Relationship Diagram shows:
- ✅ All 10 database tables
- ✅ Complete field definitions
- ✅ All relationships and constraints
- ✅ Color-coded organization
- ✅ Technical specifications
- ✅ Business logic flow

The ERD is ready to use for:
- 📊 Documentation
- 🎯 Development reference
- 📈 Database planning
- 👥 Team collaboration
- 🔧 System maintenance

Open it with Draw.io to start exploring your database structure! 🚀

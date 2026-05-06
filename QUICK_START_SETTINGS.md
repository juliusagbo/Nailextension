# Quick Start: Admin Settings

## How to Update Settings (Simple Guide)

### Step 1: Login to Admin Panel
1. Go to `http://localhost:8000/admin/login`
2. Login with admin credentials

### Step 2: Navigate to Settings
1. Click **"Settings"** in the sidebar
2. You'll see three sections:
   - **Business Information**
   - **Business Hours**
   - **Security**

### Step 3: Make Your Changes

#### Update Business Information
```
✏️ Business Name
✏️ Contact Email
✏️ Phone Number
✏️ Business Address
```

#### Update Business Hours
```
✏️ Monday: 9:00 AM - 7:00 PM
✏️ Tuesday: 9:00 AM - 7:00 PM
... and so on

☑️ Check "Closed" for days you're closed
```

#### Update Security Settings
```
✏️ Current Password (required to change password)
✏️ New Password (optional)
✏️ Confirm New Password
✏️ Password Minimum Length
✏️ Session Timeout
☑️ Two-Factor Authentication
```

### Step 4: Save Everything
1. Scroll to the bottom
2. Click the big **"Save All Settings"** button
3. Wait for success message

### Step 5: Verify Changes
1. Visit the homepage: `http://localhost:8000/`
2. Scroll to the footer
3. Your changes are now visible!

---

## Common Tasks

### Change Business Hours
1. Go to **Settings**
2. Find the **Business Hours** section
3. Adjust the times or check "Closed" for closed days
4. Click **"Save All Settings"**
5. Check the homepage footer to see the changes

### Update Contact Information
1. Go to **Settings**
2. Find the **Business Information** section
3. Update email, phone, or address
4. Click **"Save All Settings"**
5. Check the homepage footer to see the changes

### Change Password
1. Go to **Settings**
2. Find the **Security** section
3. Enter your current password
4. Enter new password twice
5. Click **"Save All Settings"**
6. Login with new password next time

---

## Tips

💡 **All Changes Together:** You can update multiple sections at once - just make your changes and click the button once!

💡 **Immediate Updates:** Changes appear on the website immediately after saving

💡 **Disabled Fields:** When a day is marked "Closed", the time fields are disabled automatically

💡 **Success Message:** Look for the green success message at the top after saving

💡 **Cache Cleared:** The system automatically clears the cache when you save settings

---

## Troubleshooting

### Changes Not Showing?
1. Hard refresh the page (Ctrl + F5)
2. Clear your browser cache
3. Check if the save was successful (green message at top)

### Can't Save?
1. Check all required fields are filled
2. Make sure email format is correct
3. If changing password, current password must be correct

### Validation Errors?
1. Read the error message carefully
2. Fix the issue mentioned
3. Try saving again

---

## Quick Reference

| Setting | Where It Appears |
|---------|------------------|
| Business Name | Homepage Footer |
| Contact Email | Homepage Footer |
| Phone Number | Homepage Footer |
| Business Address | Homepage Footer |
| Business Hours | Homepage Footer |
| Password | Admin Login |
| Session Timeout | Admin Session Length |

---

## Need Help?

If you encounter any issues:
1. Check the documentation files in the project root
2. Review the activity log for recent changes
3. Verify database settings are correct

**That's it!** The settings system is designed to be simple and intuitive. One button, all settings saved! 🎉

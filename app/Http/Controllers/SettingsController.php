<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /**
     * Display the settings page
     */
    public function index()
    {
        $businessInfo = Settings::getBusinessInfo();
        $businessHours = Settings::getBusinessHours();
        $securitySettings = Settings::getSecuritySettings();

        return view('admin.settings', compact('businessInfo', 'businessHours', 'securitySettings'));
    }

    /**
     * Update all settings at once
     */
    public function updateAllSettings(Request $request)
    {
        try {
            $validated = $request->validate([
            // Business Information
            'business_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'business_address' => 'required|string|max:500',
            
            // Business Hours - make time fields optional when day is closed
            'monday_open' => 'nullable|date_format:H:i',
            'monday_close' => 'nullable|date_format:H:i',
            'tuesday_open' => 'nullable|date_format:H:i',
            'tuesday_close' => 'nullable|date_format:H:i',
            'wednesday_open' => 'nullable|date_format:H:i',
            'wednesday_close' => 'nullable|date_format:H:i',
            'thursday_open' => 'nullable|date_format:H:i',
            'thursday_close' => 'nullable|date_format:H:i',
            'friday_open' => 'nullable|date_format:H:i',
            'friday_close' => 'nullable|date_format:H:i',
            'saturday_open' => 'nullable|date_format:H:i',
            'saturday_close' => 'nullable|date_format:H:i',
            'sunday_open' => 'nullable|date_format:H:i',
            'sunday_close' => 'nullable|date_format:H:i',
            
            // Security
            'current_password' => 'required_with:new_password|current_password',
            'new_password' => 'nullable|confirmed|min:8',
            'password_min_length' => 'required|integer|min:6|max:20',
            'session_timeout' => 'required|integer|min:30|max:480',
            ]);

            // Update Business Information
        Settings::set('business_name', $request->business_name, 'string', 'Business name');
        Settings::set('contact_email', $request->contact_email, 'string', 'Contact email address');
        Settings::set('phone_number', $request->phone_number, 'string', 'Business phone number');
        Settings::set('business_address', $request->business_address, 'string', 'Business address');

        // Update Business Hours
        $businessHours = [
            'monday' => [
                'open' => $request->monday_open ?: '09:00',
                'close' => $request->monday_close ?: '19:00',
                'closed' => $request->has('monday_closed')
            ],
            'tuesday' => [
                'open' => $request->tuesday_open ?: '09:00',
                'close' => $request->tuesday_close ?: '19:00',
                'closed' => $request->has('tuesday_closed')
            ],
            'wednesday' => [
                'open' => $request->wednesday_open ?: '09:00',
                'close' => $request->wednesday_close ?: '19:00',
                'closed' => $request->has('wednesday_closed')
            ],
            'thursday' => [
                'open' => $request->thursday_open ?: '09:00',
                'close' => $request->thursday_close ?: '19:00',
                'closed' => $request->has('thursday_closed')
            ],
            'friday' => [
                'open' => $request->friday_open ?: '09:00',
                'close' => $request->friday_close ?: '19:00',
                'closed' => $request->has('friday_closed')
            ],
            'saturday' => [
                'open' => $request->saturday_open ?: '10:00',
                'close' => $request->saturday_close ?: '20:00',
                'closed' => $request->has('saturday_closed')
            ],
            'sunday' => [
                'open' => $request->sunday_open ?: '00:00',
                'close' => $request->sunday_close ?: '00:00',
                'closed' => $request->has('sunday_closed')
            ],
        ];

        Settings::set('business_hours', json_encode($businessHours), 'json', 'Business operating hours');

        // Update Security Settings
        if ($request->filled('new_password')) {
            $user = Auth::user();
            $user->password = Hash::make($request->new_password);
            $user->save();

            LogsActivity::logActivity(
                'UPDATED SETTINGS',
                'Changed admin password',
                $user
            );
        }

        Settings::set('two_factor_enabled', $request->has('two_factor_enabled'), 'boolean', 'Two-factor authentication enabled');
        Settings::set('password_min_length', $request->password_min_length, 'integer', 'Minimum password length');
        Settings::set('session_timeout', $request->session_timeout, 'integer', 'Session timeout in minutes');

            // Log activity
            LogsActivity::logActivity(
                'UPDATED SETTINGS',
                'Updated all settings',
                null
            );

            return redirect()->back()->with('success', 'All settings updated successfully!');
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Please check the form for errors.');
                
        } catch (\Exception $e) {
            \Log::error('Settings update failed: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update settings. Please try again.');
        }
    }

    /**
     * Update business information
     */
    public function updateBusinessInfo(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'business_address' => 'required|string|max:500',
        ]);

        $oldValues = Settings::getBusinessInfo();

        // Update settings
        Settings::set('business_name', $request->business_name, 'string', 'Business name');
        Settings::set('contact_email', $request->contact_email, 'string', 'Contact email address');
        Settings::set('phone_number', $request->phone_number, 'string', 'Business phone number');
        Settings::set('business_address', $request->business_address, 'string', 'Business address');

        // Log activity
        LogsActivity::logActivity(
            'UPDATED SETTINGS',
            'Updated business information',
            null,
            $oldValues,
            $request->only(['business_name', 'contact_email', 'phone_number', 'business_address'])
        );

        return redirect()->back()->with('success', 'Business information updated successfully.');
    }

    /**
     * Update business hours
     */
    public function updateBusinessHours(Request $request)
    {
        $request->validate([
            'monday_open' => 'required|date_format:H:i',
            'monday_close' => 'required|date_format:H:i',
            'monday_closed' => 'boolean',
            'tuesday_open' => 'required|date_format:H:i',
            'tuesday_close' => 'required|date_format:H:i',
            'tuesday_closed' => 'boolean',
            'wednesday_open' => 'required|date_format:H:i',
            'wednesday_close' => 'required|date_format:H:i',
            'wednesday_closed' => 'boolean',
            'thursday_open' => 'required|date_format:H:i',
            'thursday_close' => 'required|date_format:H:i',
            'thursday_closed' => 'boolean',
            'friday_open' => 'required|date_format:H:i',
            'friday_close' => 'required|date_format:H:i',
            'friday_closed' => 'boolean',
            'saturday_open' => 'required|date_format:H:i',
            'saturday_close' => 'required|date_format:H:i',
            'saturday_closed' => 'boolean',
            'sunday_open' => 'required|date_format:H:i',
            'sunday_close' => 'required|date_format:H:i',
            'sunday_closed' => 'boolean',
        ]);

        $oldValues = Settings::getBusinessHours();

        $businessHours = [
            'monday' => [
                'open' => $request->monday_open,
                'close' => $request->monday_close,
                'closed' => $request->has('monday_closed')
            ],
            'tuesday' => [
                'open' => $request->tuesday_open,
                'close' => $request->tuesday_close,
                'closed' => $request->has('tuesday_closed')
            ],
            'wednesday' => [
                'open' => $request->wednesday_open,
                'close' => $request->wednesday_close,
                'closed' => $request->has('wednesday_closed')
            ],
            'thursday' => [
                'open' => $request->thursday_open,
                'close' => $request->thursday_close,
                'closed' => $request->has('thursday_closed')
            ],
            'friday' => [
                'open' => $request->friday_open,
                'close' => $request->friday_close,
                'closed' => $request->has('friday_closed')
            ],
            'saturday' => [
                'open' => $request->saturday_open,
                'close' => $request->saturday_close,
                'closed' => $request->has('saturday_closed')
            ],
            'sunday' => [
                'open' => $request->sunday_open,
                'close' => $request->sunday_close,
                'closed' => $request->has('sunday_closed')
            ],
        ];

        Settings::set('business_hours', json_encode($businessHours), 'json', 'Business operating hours');

        // Log activity
        LogsActivity::logActivity(
            'UPDATED SETTINGS',
            'Updated business hours',
            null,
            $oldValues,
            $businessHours
        );

        return redirect()->back()->with('success', 'Business hours updated successfully.');
    }

    /**
     * Update security settings
     */
    public function updateSecuritySettings(Request $request)
    {
        $request->validate([
            'current_password' => 'required_with:new_password|current_password',
            'new_password' => 'nullable|confirmed|min:8',
            'two_factor_enabled' => 'boolean',
            'password_min_length' => 'required|integer|min:6|max:20',
            'session_timeout' => 'required|integer|min:30|max:480',
        ]);

        $oldValues = Settings::getSecuritySettings();

        // Update password if provided
        if ($request->filled('new_password')) {
            $user = Auth::user();
            $user->password = Hash::make($request->new_password);
            $user->save();

            LogsActivity::logActivity(
                'UPDATED SETTINGS',
                'Changed admin password',
                $user
            );
        }

        // Update security settings
        Settings::set('two_factor_enabled', $request->has('two_factor_enabled'), 'boolean', 'Two-factor authentication enabled');
        Settings::set('password_min_length', $request->password_min_length, 'integer', 'Minimum password length');
        Settings::set('session_timeout', $request->session_timeout, 'integer', 'Session timeout in minutes');

        // Log activity
        LogsActivity::logActivity(
            'UPDATED SETTINGS',
            'Updated security settings',
            null,
            $oldValues,
            [
                'two_factor_enabled' => $request->has('two_factor_enabled'),
                'password_min_length' => $request->password_min_length,
                'session_timeout' => $request->session_timeout,
            ]
        );

        return redirect()->back()->with('success', 'Security settings updated successfully.');
    }

    /**
     * Get settings as JSON (for API)
     */
    public function getSettings()
    {
        return response()->json([
            'business_info' => Settings::getBusinessInfo(),
            'business_hours' => Settings::getBusinessHours(),
            'security_settings' => Settings::getSecuritySettings(),
        ]);
    }

    /**
     * Reset settings to default
     */
    public function resetToDefault()
    {
        $oldValues = Settings::getAll();

        // Reset to default values
        Settings::set('business_name', 'Nailed by Via', 'string', 'Business name');
        Settings::set('contact_email', 'nailedbyvia@gmail.com', 'string', 'Contact email address');
        Settings::set('phone_number', '+63 912 345 6789', 'string', 'Business phone number');
        Settings::set('business_address', 'Alegria, Cordova, Cebu, Philippines', 'string', 'Business address');

        $defaultHours = [
            'monday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'tuesday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'wednesday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'thursday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'friday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'saturday' => ['open' => '10:00', 'close' => '20:00', 'closed' => false],
            'sunday' => ['open' => '00:00', 'close' => '00:00', 'closed' => true],
        ];

        Settings::set('business_hours', json_encode($defaultHours), 'json', 'Business operating hours');
        Settings::set('two_factor_enabled', false, 'boolean', 'Two-factor authentication enabled');
        Settings::set('password_min_length', 8, 'integer', 'Minimum password length');
        Settings::set('session_timeout', 120, 'integer', 'Session timeout in minutes');

        // Log activity
        LogsActivity::logActivity(
            'UPDATED SETTINGS',
            'Reset all settings to default values',
            null,
            $oldValues,
            Settings::getAll()
        );

        return redirect()->back()->with('success', 'Settings reset to default values successfully.');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'description',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("setting.{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            
            if (!$setting) {
                return $default;
            }

            return static::castValue($setting->value, $setting->type);
        });
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'string', $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'description' => $description,
            ]
        );

        Cache::forget("setting.{$key}");
        
        return $setting;
    }

    /**
     * Cast value based on type
     */
    private static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    /**
     * Get all settings as key-value pairs
     */
    public static function getAll()
    {
        return Cache::remember('settings.all', 3600, function () {
            $settings = static::all();
            $result = [];
            
            foreach ($settings as $setting) {
                $result[$setting->key] = static::castValue($setting->value, $setting->type);
            }
            
            return $result;
        });
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        Cache::forget('settings.all');
        
        // Clear individual setting caches
        $keys = static::pluck('key');
        foreach ($keys as $key) {
            Cache::forget("setting.{$key}");
        }
    }

    /**
     * Get business information settings
     */
    public static function getBusinessInfo()
    {
        return [
            'business_name' => static::get('business_name', 'Nailed by Via'),
            'contact_email' => static::get('contact_email', 'nailedbyvia@gmail.com'),
            'phone_number' => static::get('phone_number', '+63 912 345 6789'),
            'business_address' => static::get('business_address', 'Alegria, Cordova, Cebu, Philippines'),
        ];
    }

    /**
     * Get business hours settings
     */
    public static function getBusinessHours()
    {
        return static::get('business_hours', [
            'monday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'tuesday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'wednesday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'thursday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'friday' => ['open' => '09:00', 'close' => '19:00', 'closed' => false],
            'saturday' => ['open' => '10:00', 'close' => '20:00', 'closed' => false],
            'sunday' => ['open' => '00:00', 'close' => '00:00', 'closed' => true],
        ]);
    }

    /**
     * Get security settings
     */
    public static function getSecuritySettings()
    {
        return [
            'two_factor_enabled' => static::get('two_factor_enabled', false),
            'password_min_length' => static::get('password_min_length', 8),
            'session_timeout' => static::get('session_timeout', 120), // minutes
        ];
    }
}

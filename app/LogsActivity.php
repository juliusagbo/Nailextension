<?php

namespace App;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    /**
     * Log an activity
     */
    public static function logActivity($action, $details, $model = null, $oldValues = null, $newValues = null)
    {
        $user = Auth::user();
        
        ActivityLog::create([
            'user_id' => $user ? $user->id : null,
            'user_type' => $user ? ($user->role === 'admin' ? 'admin' : 'customer') : 'guest',
            'user_name' => $user ? $user->name : 'Guest',
            'user_role' => $user ? ($user->role === 'admin' ? 'Owner' : 'Customer') : 'Guest',
            'action' => $action,
            'details' => $details,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model ? $model->id : null,
            'old_values' => $oldValues,
            'new_values' => $newValues,
        ]);
    }

    /**
     * Log activity when model is created
     */
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            $action = self::getActionName($model, 'created');
            $details = self::getDetailsForAction($model, 'created');
            self::logActivity($action, $details, $model);
        });

        static::updated(function ($model) {
            $action = self::getActionName($model, 'updated');
            $details = self::getDetailsForAction($model, 'updated');
            $oldValues = $model->getOriginal();
            $newValues = $model->getChanges();
            self::logActivity($action, $details, $model, $oldValues, $newValues);
        });

        static::deleted(function ($model) {
            $action = self::getActionName($model, 'deleted');
            $details = self::getDetailsForAction($model, 'deleted');
            self::logActivity($action, $details, $model);
        });
    }

    /**
     * Get action name based on model and event
     */
    private static function getActionName($model, $event)
    {
        $modelName = class_basename($model);
        
        $actions = [
            'Appointment' => [
                'created' => 'NEW BOOKING',
                'updated' => 'APPOINTMENT UPDATED',
                'deleted' => 'APPOINTMENT CANCELLED',
            ],
            'Gallery' => [
                'created' => 'GALLERY ITEM ADDED',
                'updated' => 'GALLERY ITEM UPDATED',
                'deleted' => 'GALLERY ITEM DELETED',
            ],
            'Service' => [
                'created' => 'SERVICE ADDED',
                'updated' => 'SERVICE UPDATED',
                'deleted' => 'SERVICE DELETED',
            ],
            'User' => [
                'created' => 'CUSTOMER ADDED',
                'updated' => 'CUSTOMER UPDATED',
                'deleted' => 'CUSTOMER DELETED',
            ],
        ];

        return $actions[$modelName][$event] ?? strtoupper($modelName . ' ' . $event);
    }

    /**
     * Get details for the action
     */
    private static function getDetailsForAction($model, $event)
    {
        $modelName = class_basename($model);
        
        switch ($modelName) {
            case 'Appointment':
                if ($event === 'created') {
                    return $model->service->name . ' - ' . $model->service->description . ' (₱' . number_format($model->service->price, 0) . ')';
                }
                return 'Appointment #' . $model->id;
                
            case 'Gallery':
                return $model->title;
                
            case 'Service':
                return "Added '{$model->name}'";
                
            case 'User':
                if ($event === 'created') {
                    return "Added new customer: {$model->name}";
                }
                return $model->name;
                
            default:
                return $modelName . ' #' . $model->id;
        }
    }
}

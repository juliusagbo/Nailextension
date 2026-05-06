<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'user_name',
        'user_role',
        'action',
        'details',
        'ip_address',
        'user_agent',
        'model_type',
        'model_id',
        'old_values',
        'new_values',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    /**
     * Get the model that this activity log belongs to
     */
    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who performed the action
     */
    public function user()
    {
        if ($this->user_type === 'admin') {
            return $this->belongsTo(User::class, 'user_id')->where('role', 'admin');
        }
        
        return $this->belongsTo(User::class, 'user_id')->where('role', 'customer');
    }

    /**
     * Scope to filter by user type
     */
    public function scopeByUserType($query, $userType)
    {
        return $query->where('user_type', $userType);
    }

    /**
     * Scope to filter by action
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope to filter by date range
     */
    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Scope to get recent activities
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Get formatted timestamp
     */
    public function getFormattedTimestampAttribute()
    {
        return $this->created_at->format('M j, g:i A');
    }

    /**
     * Get action badge color based on action type
     */
    public function getActionBadgeColorAttribute()
    {
        $colors = [
            'NEW BOOKING' => 'bg-green-100 text-green-800',
            'PAYMENT PROCESSED' => 'bg-yellow-100 text-yellow-800',
            'SERVICE ADDED' => 'bg-red-100 text-red-800',
            'CUSTOMER ADDED' => 'bg-red-100 text-red-800',
            'UPDATED SETTINGS' => 'bg-blue-100 text-blue-800',
            'GALLERY ITEM ADDED' => 'bg-purple-100 text-purple-800',
            'GALLERY ITEM UPDATED' => 'bg-purple-100 text-purple-800',
            'GALLERY ITEM DELETED' => 'bg-red-100 text-red-800',
            'APPOINTMENT CANCELLED' => 'bg-orange-100 text-orange-800',
            'APPOINTMENT RESCHEDULED' => 'bg-indigo-100 text-indigo-800',
        ];

        return $colors[$this->action] ?? 'bg-gray-100 text-gray-800';
    }
}

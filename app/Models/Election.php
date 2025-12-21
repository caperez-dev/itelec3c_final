<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Election extends Model
{
    protected $fillable = ['status'];
    
    /**
     * Get the current election (ID = 1)
     */
    public static function getCurrentElection()
    {
        return self::find(1);
    }
    
    /**
     * Get status display text with proper formatting
     */
    public function getStatusDisplayAttribute()
    {
        return ucfirst($this->status);
    }
    
    /**
     * Get status badge class based on status
     */
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'active' => 'status-active',
            'completed' => 'status-inactive',
            'pending' => 'status-pending',
            default => 'status-pending'
        };
    }
}
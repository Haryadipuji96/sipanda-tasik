<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    use HasFactory;

    protected $table = 'userlogin';

    protected $fillable = [
        'id_user',
        'ip_address',
        'user_agent',
        'logged_in_at',
        'logged_out_at',
        'last_activity',
    ];

    protected $casts = [
        'logged_in_at' => 'datetime',
        'logged_out_at' => 'datetime',
        'last_activity' => 'datetime',
    ];

    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get durasi dalam detik
     */
    public function getDurationInSeconds()
    {
        if (!$this->logged_in_at) {
            return 0;
        }

        $end = $this->logged_out_at ?? $this->last_activity ?? now();
        return $this->logged_in_at->diffInSeconds($end);
    }

    /**
     * Get durasi format readable
     */
    public function getFormattedDuration()
    {
        $seconds = $this->getDurationInSeconds();
        
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;

        return sprintf('%d jam %d menit %d detik', $hours, $minutes, $secs);
    }
}
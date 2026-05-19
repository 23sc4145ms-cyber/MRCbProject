<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'started_at',
        'estimated_end_at',
        'ended_at',
        'maintenance_type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'estimated_end_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * Get the current active maintenance record.
     */
    public static function isActive()
    {
        return self::where('status', 'active')->exists();
    }

    /**
     * Get the active maintenance record.
     */
    public static function getActive()
    {
        return self::where('status', 'active')->first();
    }

    /**
     * Mark maintenance as completed.
     */
    public function complete()
    {
        return $this->update([
            'status' => 'completed',
            'ended_at' => now(),
        ]);
    }
}

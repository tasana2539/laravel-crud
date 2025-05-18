<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'status',
        'priority',
        'assigned_to',
        'approved_by',
    ];

    // ความสัมพันธ์กับ User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(RepairLog::class);
    }

    public function latestLog()
    {
        return $this->hasOne(RepairLog::class)->latestOfMany();
    }

    public function technician()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

}

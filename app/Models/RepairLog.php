<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'repair_request_id',
        'updated_by',
        'status_before',
        'status_after',
        'note',
        'previous_updated_at',
    ];

    public function repairRequest()
    {
        return $this->belongsTo(RepairRequest::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}


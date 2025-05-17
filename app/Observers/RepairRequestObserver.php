<?php

namespace App\Observers;

use App\Models\RepairRequest;

class RepairRequestObserver
{
    public function updating(RepairRequest $repair)
    {
        if ($repair->isDirty('status')) {
            \App\Models\RepairLog::create([
                'repair_request_id' => $repair->id,
                'updated_by' => auth()->id(),
                'status_before' => $repair->getOriginal('status'),
                'status_after' => $repair->status,
                'note' => session('repair_note') ?? '',
                'updated_at' => now(),
                'previous_updated_at' => $repair->updated_at, // เวลาที่สถานะก่อนหน้าเกิด
            ]);
        }
    }


}

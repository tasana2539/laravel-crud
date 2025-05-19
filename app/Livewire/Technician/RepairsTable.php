<?php

namespace App\Livewire\Technician;

use Livewire\Component;
use App\Models\RepairRequest;
use App\Models\User;

class RepairsTable extends Component
{
    public function render()
    {
        $repairs = RepairRequest::with(['latestLog.updater', 'user','technician', 'manager'])
            ->where('assigned_to', auth()->id()) // แสดงเฉพาะที่ช่างรับเอง
            ->latest()
            ->get();

        return view('livewire.technician.repairs-table', compact('repairs'));
    }
}

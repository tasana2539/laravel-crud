<?php

namespace App\Livewire\ItManager;

use Livewire\Component;
use App\Models\RepairRequest;
use App\Models\User;

class RepairsTable extends Component
{
    public function render()
    {
        $repairs = RepairRequest::with(['latestLog.updater', 'user', 'technician', 'manager'])
        ->whereNotIn('status', ['completed', 'cancel']) // กรองสถานะที่ยังไม่เสร็จและยังไม่ถูกยกเลิก
        ->latest()->get();
        $technicians = User::where('role', 'technician')->get();
        return view('livewire.it-manager.repairs-table', compact('repairs','technicians'));
    }
}

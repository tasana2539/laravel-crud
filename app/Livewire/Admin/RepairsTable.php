<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\RepairRequest;
use App\Models\User;

class RepairsTable extends Component
{
    public function render()
    {
        $repairs = RepairRequest::with(['latestLog.updater', 'user', 'technician', 'manager'])->latest()->get();
        return view('livewire.admin.repairs-table', compact('repairs'));
    }
}


<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\RepairRequest;
use App\Models\User;

class RepairsTable extends Component
{
    public function render()
    {
        $repairs = RepairRequest::with(['latestLog.updater', 'user', 'technician', 'manager'])->where('user_id', auth()->id())->latest()->get();
        return view('livewire.user.repairs-table', compact('repairs'));
    }
}

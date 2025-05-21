<?php

namespace App\Livewire\Task;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class TaskTable extends Component
{
    public function render()
    {
        $tasks = DB::table('repair_requests')
        ->select('id','title', 'status', 'updated_at')
        ->get();
        return view('livewire.task.task-table', compact('tasks'));
    }
}

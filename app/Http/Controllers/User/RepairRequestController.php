<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepairRequest;

class RepairRequestController extends Controller
{
    public function index()
    {
        $repairs = RepairRequest::with('latestLog')->where('user_id', auth()->id())->latest()->get();
        return view('repair-system.user.dashboard', compact('repairs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,critical',
        ]);

        RepairRequest::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
        ]);

        return redirect()->route('user.requests.index')->with('success', 'แจ้งซ่อมเรียบร้อยแล้ว');
    }

    public function cancel(Request $request, $id)
    {
        $request->validate([
            'note' => 'nullable|string|max:255',
        ]);

        $repair = RepairRequest::where('user_id', auth()->id())->findOrFail($id);

        // seseion observer
        session(['repair_note' => $request->note]);

        $repair->update(['status' => 'cancel']);

        session()->forget('repair_note'); // clear session

        return redirect()->route('user.requests.index')->with('success', 'ยกเลิกรายการเรียบร้อยแล้ว');
    }


}


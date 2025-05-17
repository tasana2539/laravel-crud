<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairRequest;
use Illuminate\Http\Request;

class RepairRequestController extends Controller
{
    public function index()
    {
        $repairs = RepairRequest::with('latestLog')->latest()->get();
        return view('repair-system.admin.dashboard', compact('repairs'));
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

        return redirect()->route('admin.requests.index')->with('success', 'แจ้งซ่อมเรียบร้อยแล้ว');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'status' => 'required|string|max:50',
            'priority' => 'required|string|max:10',
            'description' => 'nullable|string|min:5|max:255',
        ]);
        
        $data = array_filter($validated, function ($value) {
            return $value !== 'undefined';
        });

        $repair = RepairRequest::findOrFail($id);

        // seseion observer
        session(['repair_note' => $request->note]);

        $repair->update($data);

        session()->forget('repair_note'); // clear session

        return redirect()->back()->with('success', 'อัปเดตเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $repair = RepairRequest::findOrFail($id);

        // repair_logs
        $repair->logs()->delete(); 

        // repair_request
        $repair->delete();

        return redirect()->back()->with('success', 'ลบรายการเรียบร้อยแล้ว');
    }


}

<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RepairRequest;

class RepairRequestController extends Controller
{
    public function index()
    {
        return view('repair-system.user.dashboard');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        RepairRequest::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description
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

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string|min:5|max:255',
        ]);
        
        $data = array_filter($validated, function ($value) {
            return $value !== 'undefined';
        });

        // เงื่อนไขการจัดการ status
        if ($request->has('status') && $request->status === 'returned') {
            $data['status'] = 'assigned';
        }

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


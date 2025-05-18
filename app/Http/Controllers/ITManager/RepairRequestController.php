<?php

namespace App\Http\Controllers\ITManager;

use App\Http\Controllers\Controller;
use App\Models\RepairRequest;
use Illuminate\Http\Request;

class RepairRequestController extends Controller
{
    public function index()
    {
        return view('repair-system.it-manager.dashboard');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:50',
            'approved_by' => 'required|numeric|max:10',
            'assigned_to' => 'required|string|max:50',
            'priority' => 'required|string|max:10',
            'note' => 'nullable|string|max:255',
        ]);
        
        $data = array_filter($validated, function ($value) {
            return $value !== 'undefined';
        });

        $repair = RepairRequest::findOrFail($id);

        // seseion observer
        session(['repair_note' => $request->note]);

        $repair->update($data);

        session()->forget('repair_note'); // clear session

        return redirect()->back()->with('success', 'มอบหมายงานแล้ว');
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
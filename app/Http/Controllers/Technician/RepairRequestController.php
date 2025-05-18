<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\RepairRequest;
use Illuminate\Http\Request;

class RepairRequestController extends Controller
{
    public function index()
    {
        return view('repair-system.technician.dashboard');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|max:50'
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

}

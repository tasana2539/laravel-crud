<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RepairRequest;
use Illuminate\Http\Request;

//enum
use Illuminate\Validation\Rules\Enum;
use App\Enums\Role;

class RepairRequestController extends Controller
{
    public function index()
    {
        return view('repair-system.admin.dashboard');
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

        return redirect()->back()->with('success', 'แจ้งซ่อมเรียบร้อยแล้ว');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'priority' => 'required|string|max:10',
            'note' => 'nullable|string|max:255',
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

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:10',
            'email' => 'required|email|max:20',
            'password' => 'required|string|max:255',
            'role' => ['required', new Enum(Role::class)],
        ]);

        User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>Role::form($request->role)->value,
            'password'=>Hash::make($request->password)
        ]);

        return redirect()->back()->with('success','สร้างผู้ใช้สำเร็จแล้ว');
        
    }


}

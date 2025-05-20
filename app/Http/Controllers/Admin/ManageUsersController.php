<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Enums\Role;

class ManageUsersController extends Controller
{
    public function index(Request $request) {
        return view('repair-system.admin.users');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => ['required', 'string', \Illuminate\Validation\Rule::in(array_map(fn($r) => $r->value, Role::cases()))],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User created successfully.');
    }

    public function update(Request $request) {
        return view('repair-system.admin.users');
    }

    public function destroy(Request $request) {
        return view('repair-system.admin.users');
    }
}

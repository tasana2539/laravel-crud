<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Enums\Role;
use App\Models\User;

class ManageUsersController extends Controller
{
    public function index() {
        return view('repair-system.admin.users',
            [
                'roles' => Role::cases(),
            ]
        );
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

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|confirmed|min:6',
            'role' => ['required', 'string', \Illuminate\Validation\Rule::in(array_map(fn($r) => $r->value, Role::cases()))],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        $user->role = $validated['role'];
        $user->save();

        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function edit(User $user)
    {
        return response()->json($user);
    }

    public function destroy(Request $request, $id) {
        $user = User::FindOrFail($id);

        $user->delete();

        return redirect()->back()->with('success', 'User Deleted successfully.');
    }
}

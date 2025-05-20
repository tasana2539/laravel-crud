<?php
namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Enums\Role;

class ManageUsers extends Component
{
    public function render()
    {
        $roles = Role::cases();
        $users = User::where('role', '!=', Role::ADMIN->value)->latest()->get();

        return view('livewire.admin.manage-users', compact('users', 'roles'));
    }
}

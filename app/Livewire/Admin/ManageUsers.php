<?php
namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use App\Enums\Role;

class ManageUsers extends Component
{
    public array $roles = [];
    public $users;

    public function mount()
    {
        $this->roles = Role::cases();
        $this->users = User::where('role', '!=', Role::ADMIN->value)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.manage-users');
    }
}

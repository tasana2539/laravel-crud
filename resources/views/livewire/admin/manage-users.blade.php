<div class="p-4">

    <!-- Button to open modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#userCreateModal">
        Create User
    </button>

    <!-- Users table -->
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th style="width: 150px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('Y-m-d') }}</td>
                    <td>
                        <button wire:click="editUser({{ $user->id }})" class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="modal" data-bs-target="#userModal">Edit</button>
                        <button wire:click="deleteUser({{ $user->id }})" class="btn btn-sm btn-outline-danger" onclick="confirm('Are you sure?') || event.stopImmediatePropagation()">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
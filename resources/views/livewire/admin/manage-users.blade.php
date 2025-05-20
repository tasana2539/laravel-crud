<div class="p-4">

    <!-- Button to open modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createUserModal">
        Create User
    </button>

    <!-- Users table -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>ชื่อ</th>
                <th>อีเมล</th>
                <th>สร้างเมื่อ</th>
                <th>แก้ไขเมื่อ</th>
                <th style="width: 150px;">ดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at?->format('Y-m-d') ?? '-' }}</td>
                    <td>{{ $user->updated_at?->format('Y-m-d') ?? '-' }}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary me-2" onclick="editUser({{ $user->id }})"
                             data-bs-toggle="modal" data-bs-target="#editUserModal">แก้ไข
                        </button>
                        <button onclick="deleteUser({{ $user->id }})" class="btn btn-sm btn-outline-danger">ลบ</button>
                        <form id="delete-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">ไม่พบผู้ใช้!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
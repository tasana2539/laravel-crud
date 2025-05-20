{{-- edit user modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" id="editUserForm">
      @csrf
      @method('PUT')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editUserModalLabel">แก้ไขข้อมูลผู้ใช้</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password">
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation">
          </div>

          <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" name="role" id="role" required>
              <option value="" disabled selected>-- Selected --</option>
              @foreach ($roles as $role)
                  <option value="{{ $role->value }}">{{ $role->label() }}</option>
              @endforeach
            </select>

          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-primary">Save</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function editUser(userId) {
    const form = document.getElementById('editUserForm');
    form.reset();
    
    fetch(`/admin/users/${userId}/edit`)
        .then(response => response.json())
        .then(user => {
            // Update form action
            document.getElementById('editUserForm').action = `/admin/users/${userId}`;

            // Populate form fields
            document.querySelector('#editUserForm input[name="name"]').value = user.name;
            document.querySelector('#editUserForm input[name="email"]').value = user.email;
            document.querySelector('#editUserForm input[name="password"]').value = '';
            document.querySelector('#editUserForm input[name="password_confirmation"]').value = '';
            document.querySelector('#editUserForm select[name="role"]').value = user.role;
        })
        .catch(error => {
            console.error('Error fetching user data:', error);
            alert('Could not load user data.');
        });
}
</script>
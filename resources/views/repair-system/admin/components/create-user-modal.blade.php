{{-- create user modal --}}
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.users.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="createUserModalLabel">สร้างผู้ใช้ใหม่</h5>
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
            <input type="password" class="form-control" name="password" required>
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" required>
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
  function deleteUser (id) {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่?',
        text: 'หากลบแล้วจะไม่สามารถกู้คืนได้!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ใช่, ลบเลย!',
        cancelButtonText: 'ยกเลิก'
    }).then((result) => {
        if (result.isConfirmed) {
            form = document.getElementById('delete-form-' + id);
            if (form) {
                form.submit();
            } else {
                console.error('ไม่พบฟอร์ม delete-form-' + id);
            }
        }
    });
  }
</script>
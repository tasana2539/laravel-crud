{{-- create modal --}}
<div class="modal fade" id="repairModal" tabindex="-1" aria-labelledby="repairModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.requests.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="repairModalLabel">แจ้งซ่อมใหม่</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
        </div>
        <div class="modal-body">

          <div class="mb-3">
            <label for="title" class="form-label">หัวข้อ</label>
            <input type="text" class="form-control" name="title" required>
          </div>

          <div class="mb-3">
            <label for="description" class="form-label">รายละเอียด</label>
            <textarea class="form-control" name="description" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label for="priority" class="form-label">ระดับความสำคัญ</label>
            <select class="form-select" name="priority" required>
              <option value="low">ต่ำ</option>
              <option value="medium">ปานกลาง</option>
              <option value="high">สูง</option>
              <option value="critical">วิกฤติ</option>
            </select>
          </div>

        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-outline-primary">ส่งแจ้งซ่อม</button>
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
          
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  function confirmDelete(id) {
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
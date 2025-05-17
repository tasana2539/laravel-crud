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
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
          <button type="submit" class="btn btn-primary">ส่งแจ้งซ่อม</button>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- update modal --}}
<form id="admin-update-form" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="title" id="update-title">
    <input type="hidden" name="status" id="update-status">
    <input type="hidden" name="priority" id="update-priority">
    <input type="hidden" name="note" id="update-note">
    <input type="hidden" name="description" id="update-description">
</form>

<script>
    function adminUpdateRepair(repairId,priority = '',title='',status='',note='',description='') {
        Swal.fire({
            title: 'อัปเดตรายการ',
            html:
                `
                
                <select id="swal-status" class="swal2-input my-2">
                    <option value="pending" ${status === 'pending' ? 'selected' : ''}>รอดำเนินการ</option>
                    <option value="assigned" ${status === 'assigned' ? 'selected' : ''}>มอบหมายแล้ว</option>
                    <option value="in_progress" ${status === 'in_progress' ? 'selected' : ''}>กำลังดำเนินการ</option>
                    <option value="completed" ${status === 'completed' ? 'selected' : ''}>เสร็จสิ้น</option>
                    <option value="rejected" ${status === 'rejected' ? 'selected' : ''}>ปฏิเสธ</option>
                    <option value="cancelled" ${status === 'cancelled' ? 'selected' : ''}>ยกเลิก</option>
                 </select>
                 <select id="swal-priority" class="swal2-input my-2">
                    <option value="low" ${priority === 'low' ? 'selected' : ''}>low</option>
                    <option value="medium" ${priority === 'medium' ? 'selected' : ''}>medium</option>
                    <option value="high" ${priority === 'high' ? 'selected' : ''}>high</option>
                    <option value="critical" ${priority === 'critical' ? 'selected' : ''}>critical</option>
                 </select>
                 <input id="swal-title" class="swal2-input" placeholder="หัวข้อ (ขั้นต่ำ 5 ตัวอักษร)" value="${title || ''}">
                 <textarea id="swal-note" class="swal2-textarea" placeholder="หมายเหตุ (ไม่จำเป็น)">${note || ''}</textarea>
                 <textarea id="swal-description" class="swal2-textarea" placeholder="รายละเอียด (ขั้นต่ำ 5 ตัวอักษร)">${description || ''}</textarea>`,
            focusConfirm: false,
            preConfirm: () => {
                const title = document.getElementById('swal-title').value;
                const priority = document.getElementById('swal-priority').value;
                const status = document.getElementById('swal-status').value;
                const note = document.getElementById('swal-note').value;
                
                const description = document.getElementById('swal-description').value;

                if (title.length < 5 || title.length > 100) {
                    Swal.showValidationMessage('ชื่อต้องไม่เกิน 100 ตัวอักษร (ขั้นต่ำ 5 ตัวอักษร)');
                    return false;
                }
                
                if (description.length < 5 || description.length > 255) {
                    Swal.showValidationMessage('รายละเอียดต้องไม่เกิน 255 ตัวอักษร (ขั้นต่ำ 5 ตัวอักษร)');
                    return false;
                }

                if (note.length > 255) {
                    Swal.showValidationMessage('หมายเหตุต้องไม่เกิน 255 ตัวอักษร');
                    return false;
                }

                return { title,priority,status, note, description };
            },
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('admin-update-form');
                document.getElementById('update-title').value = result.value.title;
                document.getElementById('update-priority').value = result.value.priority;
                document.getElementById('update-status').value = result.value.status;
                document.getElementById('update-note').value = result.value.note;
                document.getElementById('update-description').value = result.value.description;

                form.action = `/admin/requests/${repairId}`;
                form.submit();
            }
        });
    }
</script>

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
<div class="modal fade" id="repairModal" tabindex="-1" aria-labelledby="repairModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('user.requests.store') }}" method="POST">
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

<!-- Form ซ่อนสำหรับ submit PATCH -->
<form id="cancel-form" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="note" id="cancel-note">
</form>

<script>
    function confirmCancel(repairId) {
        Swal.fire({
            title: 'ยืนยันการยกเลิก?',
            input: 'textarea',
            inputLabel: 'กรุณาระบุหมายเหตุ (ถ้ามี)',
            inputPlaceholder: 'พิมพ์หมายเหตุของคุณที่นี่...',
            inputAttributes: {
                'aria-label': 'หมายเหตุ'
            },
            showCancelButton: true,
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
            inputValidator: (value) => {
                if (value.length > 100) {
                    return 'หมายเหตุต้องไม่เกิน 100 ตัวอักษร';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('cancel-form');
                const noteInput = document.getElementById('cancel-note');

                noteInput.value = result.value;

                form.action = `/user/requests/${repairId}/cancel`;
                form.submit();
            }
        });
    }
</script>
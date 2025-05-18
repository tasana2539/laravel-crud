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

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-outline-primary">ส่งแจ้งซ่อม</button>
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
          
        </div>
      </div>
    </form>
  </div>
</div>

<!-- cancle PATCH form-->
<form id="cancel-form" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="note" id="cancel-note">
</form>

{{-- update modal --}}
<form id="user-update-form" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="title" id="update-title">
    <input type="hidden" name="note" id="update-note">
    <input type="hidden" name="description" id="update-description">
</form>

<script>
    function userUpdateRepair(repairId,title='',note='',description='') {
        Swal.fire({
            title: 'อัปเดตรายการ',
            html:
                `
                 <input id="swal-title" class="swal2-input" placeholder="หัวข้อ (ขั้นต่ำ 5 ตัวอักษร)" value="${title || ''}">
                 <textarea id="swal-note" class="swal2-textarea" placeholder="หมายเหตุ (ไม่จำเป็น)">${note || ''}</textarea>
                 <textarea id="swal-description" class="swal2-textarea" placeholder="รายละเอียด (ขั้นต่ำ 5 ตัวอักษร)">${description || ''}</textarea>`
            ,
            focusConfirm: false,
            preConfirm: () => {
                const title = document.getElementById('swal-title').value;
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

                return { title, note, description };
            },
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('user-update-form');
                document.getElementById('update-title').value = result.value.title;
                document.getElementById('update-note').value = result.value.note;
                document.getElementById('update-description').value = result.value.description;

                form.action = `/user/requests/${repairId}`;
                form.submit();
            }
        });
    }
</script>

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
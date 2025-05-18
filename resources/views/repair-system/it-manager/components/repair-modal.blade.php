{{-- update modal --}}
<form id="it-manager-update-form" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
    <input type="hidden" name="status" id="update-status">
    <input type="hidden" name="note" id="update-note">
</form>

<script>
    function itManagerUpdateRepair(repairId,title='',status='',note='') {
        Swal.fire({
            title: 'อัปเดตรายการ',
            html:
                `
                <select id="swal-status" class="swal2-input my-2">
                    <option value="in_progress" ${status === 'in_progress' ? 'selected' : ''}>กำลังดำเนินการ</option>
                    <option value="completed" ${status === 'completed' ? 'selected' : ''}>เสร็จสิ้น</option>
                    <option value="rejected" ${status === 'rejected' ? 'selected' : ''}>ปฏิเสธ</option>
                 </select>
                 <input disabled id="swal-title" class="disabled swal2-input" placeholder="หัวข้อ" value="${title || ''}">
                 <textarea id="swal-note" class="swal2-textarea" placeholder="หมายเหตุ (ไม่จำเป็น)">${note || ''}</textarea>
                `
            ,
            focusConfirm: false,
            preConfirm: () => {
                const status = document.getElementById('swal-status').value;
                const note = document.getElementById('swal-note').value;

                if (note.length > 255) {
                    Swal.showValidationMessage('หมายเหตุต้องไม่เกิน 255 ตัวอักษร');
                    return false;
                }

                return { status, note };
            },
            showCancelButton: true,
            confirmButtonText: 'บันทึก',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('it-manager-update-form');
                document.getElementById('update-status').value = result.value.status;
                document.getElementById('update-note').value = result.value.note;

                form.action = `/it-manager/requests/${repairId}`;
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
@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    ตารางข้อมูล
  </div>
  <div class="card-body">
    
    <!-- ตารางแจ้งซ่อม -->
    <div class="table-responsive">
       @livewire('technician.repairs-table')
    </div>
  </div>
</div>
<script>
    const assignModal = document.getElementById('updateModal')
    if (assignModal) {
      assignModal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget
          const id = button.getAttribute('data-id')
          const title = button.getAttribute('data-title')
          const status = button.getAttribute('data-status')
          const note = button.getAttribute('data-note')

          const form = assignModal.querySelector('#updateForm')
          form.action = `/technician/requests/${id}` // ใช้ route update

          assignModal.querySelector('#title').value = title ?? ''
          assignModal.querySelector('#status').value = status
          assignModal.querySelector('#note').value = note ?? ''
      })
    }

    function openPdfPreview(repairId) {
      fetch("{{ route('repair.pdf.single-request') }}", {
          method: "POST",
          headers: {
              "X-CSRF-TOKEN": "{{ csrf_token() }}",
              "Content-Type": "application/json"
          },
          body: JSON.stringify({ repair_id: repairId })
      })
      .then(() => {
          // เมื่อ session พร้อมแล้ว เปลี่ยน src ของ iframe
          const iframe = document.getElementById('pdfIframe');
          iframe.src = "{{ route('repair.pdf.single-view') }}";

          // เปลี่ยนลิงก์ของปุ่มดาวน์โหลด
          const downloadBtn = document.getElementById('downloadPdfBtn');
          downloadBtn.href = "{{ route('repair.pdf.single-view') }}?download=1";

          // เปิด modal
          const modal = new bootstrap.Modal(document.getElementById('pdfPreviewModal'));
          modal.show();
      });
  }

</script>
@endsection
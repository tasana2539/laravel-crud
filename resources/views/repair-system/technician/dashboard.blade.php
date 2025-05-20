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

</script>
@endsection
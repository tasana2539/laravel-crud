@extends('layouts.app')

@section('content')
<button type="button" class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#repairModal">
    แจ้งซ่อม
</button>
<div class="card">
  <div class="card-header">
    ตารางข้อมูล
  </div>
  <div class="card-body">
    
    <!-- ตารางแจ้งซ่อม -->
    <div class="table-responsive">
        @livewire('user.repairs-table')
    </div>
  </div>
</div>
@include('repair-system.user.components.repair-modal')
<script>
    const assignModal = document.getElementById('updateModal')
    if (assignModal) {
      assignModal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget
          const id = button.getAttribute('data-id')
          const title = button.getAttribute('data-title')
          const status = button.getAttribute('data-status')
          const description = button.getAttribute('data-description')
          const note = button.getAttribute('data-note')

          const form = assignModal.querySelector('#updateForm')
          form.action = `/user/requests/${id}` // ใช้ route update
          
          assignModal.querySelector('#title').value = title ?? ''
          assignModal.querySelector('#status').value = status ?? ''
          assignModal.querySelector('#description').value = description ?? ''
          assignModal.querySelector('#note').value = note ?? ''
      })
    }
</script>
@endsection


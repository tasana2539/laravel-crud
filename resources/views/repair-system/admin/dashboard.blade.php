@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    ตารางข้อมูล
  </div>
  <div class="card-body">

    <!-- ตารางแจ้งซ่อม -->
    <div class="table-responsive">
       @livewire('admin.repairs-table')
    </div>
  </div>
</div>
@include('repair-system.admin.components.repair-modal')
<script>
    const assignModal = document.getElementById('adminUpdateModal')
    if (assignModal) {
      assignModal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget
          const id = button.getAttribute('data-id')
          const title = button.getAttribute('data-title')
          const status = button.getAttribute('data-status')
          const priority = button.getAttribute('data-priority')
          const description = button.getAttribute('data-description')
          const note = button.getAttribute('data-note')

          const form = assignModal.querySelector('#adminUpdateForm')
          form.action = `/admin/requests/${id}` // ใช้ route update

          assignModal.querySelector('#title').value = title ?? ''
          assignModal.querySelector('#status').value = status ?? ''
          assignModal.querySelector('#priority').value = priority
          assignModal.querySelector('#description').value = description ?? ''
          assignModal.querySelector('#note').value = note ?? ''
      })
    }
</script>
@endsection

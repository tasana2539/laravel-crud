@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    ตารางข้อมูล
  </div>
  <div class="card-body">
    
    <!-- ตารางแจ้งซ่อม -->
    <div class="table-responsive">
       @livewire('it-manager.repairs-table')
    </div>
  </div>
</div>
@include('repair-system.it-manager.components.repair-modal')
<script>
    const assignModal = document.getElementById('assignModal')
    if (assignModal) {
      assignModal.addEventListener('show.bs.modal', function (event) {
          const button = event.relatedTarget
          const id = button.getAttribute('data-id')
          const priority = button.getAttribute('data-priority')
          const note = button.getAttribute('data-note')
          const assigned_to = button.getAttribute('data-assigned_to')
          const approved_by = button.getAttribute('data-approved_by')

          const form = assignModal.querySelector('#assignForm')
          form.action = `/it-manager/requests/${id}` // ใช้ route update
          
          assignModal.querySelector('#approved_by').value = approved_by
          assignModal.querySelector('#priority').value = priority
          assignModal.querySelector('#assigned_to').value = assigned_to ?? ''
          assignModal.querySelector('#note').value = note ?? ''
      })
    }
</script>
@endsection
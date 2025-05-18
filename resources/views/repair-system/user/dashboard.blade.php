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
@endsection


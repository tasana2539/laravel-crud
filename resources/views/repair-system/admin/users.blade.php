@extends('layouts.app')

@section('content')
<div class="card">
  <div class="card-header">
    ตารางข้อมูล
  </div>
  <div class="card-body">
    
    <div class="table-responsive">
        @livewire('admin.manage-users')
    </div>
  </div>
</div>
@include('repair-system.admin.components.create-user-modal')
@include('repair-system.admin.components.edit-user-modal')
@endsection
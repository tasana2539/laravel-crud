@extends('layouts.app')

@section('content')
    <!-- ปุ่มเรียก Modal -->
<div class="card-body mb-4">
  <div class="row">
    <a href="{{route('admin.requests.index')}}" class="btn btn-outline-primary col-md-2">
        dashboard
    </a>
  </div>
</div>
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
@endsection
@include('repair-system.admin.components.create-user-modal')
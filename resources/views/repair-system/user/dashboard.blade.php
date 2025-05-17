@extends('layouts.app')

@section('content')
<div class="container">
    <!-- ปุ่มเรียก Modal -->
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
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>หัวข้อ</th>
                    <th>รายละเอียด</th>
                    <th>ความสำคัญ</th>
                    <th>สถานะ</th>
                    <th>หมายเหตุ</th>
                    <th>ผู้รับผิดชอบ</th>
                    <th>อนุมัติโดย</th>
                    <th>วันที่แจ้ง</th>
                    <th>วันที่แก้ไข</th>
                    <th>การจัดการ</th>
                </tr>
            </thead>
            <tbody>
                
                @forelse($repairs as $repair)
                {{-- @json($repair->logs, JSON_PRETTY_PRINT) --}}
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $repair->title }}</td>
                        <td>{{ $repair->description }}</td>
                        <td>
                            <span class="badge bg-{{ 
                                match($repair->priority) {
                                    'low' => 'secondary',
                                    'medium' => 'info',
                                    'high' => 'warning',
                                    'critical' => 'danger',
                                    default => 'secondary'
                                }
                            }}">
                                {{ ucfirst($repair->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-{{ 
                                match($repair->status) {
                                    'pending' => 'secondary',
                                    'assigned' => 'primary',
                                    'in_progress' => 'warning',
                                    'completed' => 'success',
                                    'rejected' => 'danger',
                                    default => 'dark'
                                }
                            }}">
                                {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                            </span>
                        </td>
                        <td>{{ optional($repair->latestLog)->note ?? '-' }}</td>
                        <td>{{ $repair->assigned_to ?? '-' }}</td>
                        <td>{{ $repair->approved_by ?? '-' }}</td>
                        <td>{{ $repair->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ optional($repair->latestLog)->updated_at?->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>
                            @if($repair->status !== 'rejected' && $repair->status !== 'completed' && $repair->status !== 'cancel')
                                <button class="btn btn-sm btn-danger" onclick="confirmCancel({{ $repair->id }})">
                                    ยกเลิก
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="12" class="text-center text-muted">ยังไม่มีรายการแจ้งซ่อม</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
  </div>
</div>
</div>
@include('repair-system.user.components.repair-modal')
@endsection


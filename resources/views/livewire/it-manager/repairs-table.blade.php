 <table class="table table-bordered table-striped align-middle overflow-auto">
    <thead class="table-dark">
        <tr>
            <th>#</th>
            <th>ผู้แจ้ง</th>
            <th>ผู้ที่แก้ไขล่าสุด</th>
            <th>หัวข้อ</th>
            <th>รายละเอียด</th>
            <th>ความสำคัญ</th>
            <th>สถานะ</th>
            <th>หมายเหตุ</th>
            <th>ผู้รับผิดชอบ</th>
            <th>วันที่แจ้ง</th>
            <th>วันที่ล่าสุด</th>
            <th class="text-center">การจัดการ</th>
        </tr>
    </thead>
    <tbody>
        
        @forelse($repairs as $repair)
        <!-- {{-- @json($repair->logs, JSON_PRETTY_PRINT) --}} -->
            <tr>
                
                <td>{{ $loop->iteration }}</td>
                <td>{{ $repair->user->name ?? '-' }}</td>
                <td>{{ $repair->latestLog?->updater?->name ?? '-'}}</td>
                <td>{{ $repair->title }}</td>
                <td class="text-break">{{ $repair->description }}</td>
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
                    <span class="badge
                        text-{{
                            match($repair->status) {
                                'returned' => 'warning',
                                default => 'white'
                            }
                        }}

                        bg-{{ 
                            match($repair->status) {
                                'pending' => 'secondary',
                                'assigned' => 'primary',
                                'in_progress' => 'warning',
                                'completed' => 'success',
                                'rejected' => 'danger',
                                'returned' => 'white',
                                default => 'dark'
                            }
                        }}">
                        {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                    </span>
                </td>
                <td>{{ optional($repair->latestLog)->note ?? '-' }}</td>
                <td>{{ $repair->technician->name ?? '-' }}</td>
                <td>{{ $repair->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ optional($repair->latestLog)->updated_at?->format('d/m/Y H:i') ?? '-' }}</td>
                <td class="">
                    <button 
                        class="btn btn-sm btn-outline-secondary" 
                        onclick="openPdfPreview({{ $repair->id }})">
                        รายละเอียด
                    </button>
                    @if($repair->status !== 'rejected' && $repair->status !== 'cancel' && $repair->status !== 'completed')
                        <button class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#assignModal"
                            data-id="{{ $repair->id }}"
                            data-assigned_to="{{ $repair->assigned_to }}"
                            data-approved_by="{{ auth()->id() }}"
                            data-priority="{{ $repair->priority }}"
                            data-note="{{ optional($repair->latestLog)->note ?? '-' }}">
                            มอบหมาย
                        </button>
                        @include('repair-system.it-manager.components.assign-modal')

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
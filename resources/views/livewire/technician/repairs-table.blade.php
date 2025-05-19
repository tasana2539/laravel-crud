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
            <th>อนุมัติโดย</th>
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
                <td>{{ optional($repair->technician)->name ?? '-' }}</td>
                <td>{{ optional($repair->manager)->name ?? '-' }}</td>
                <td>{{ $repair->created_at->format('d/m/Y H:i') }}</td>
                <td>{{ optional($repair->latestLog)->updated_at?->format('d/m/Y H:i') ?? '-' }}</td>
                <td class="text-center">
                    @if($repair->status === 'assigned' || $repair->status === 'in_progress')
                        @if($repair->status !== 'rejected' && $repair->status !== 'cancel' && $repair->status !== 'completed')
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#updateModal"
                                data-id="{{ $repair->id }}"
                                data-title="{{ $repair->title }}"
                                data-status="{{ $repair->status }}"
                                data-note="{{ optional($repair->latestLog)->note ?? '-' }}">
                                แจ้งสถานะ
                            </button>
                            @include('repair-system.technician.components.update-modal')

                        @endif

                    @endif
                    <!-- ปุ่มเปิด modal -->
                    <button 
                        class="btn btn-sm btn-outline-secondary" 
                        onclick="openPdfPreview({{ $repair->id }})">
                        รายละเอียด
                    </button>

                    <div class="modal fade" id="pdfPreviewModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">ดูข้อมูลการแจ้งซ่อม</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      
                        </div>
                        <div class="modal-body">
                            <iframe id="pdfIframe" src="" width="100%" height="600px" style="border:none;"></iframe>
                        </div>
                        <div class="modal-footer">
                            <a id="downloadPdfBtn" href="#" class="btn btn-primary" target="_blank">ดาวน์โหลด PDF</a>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </div>
                        </div>
                    </div>
                    </div>

                </td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-center text-muted">ยังไม่มีรายการแจ้งซ่อม</td>
            </tr>
        @endforelse
    </tbody>
</table>
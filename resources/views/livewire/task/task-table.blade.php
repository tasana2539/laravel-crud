<div class="p-4">

    <div class="my-2">
        <button class="btn btn-sm btn-outline-primary" onclick="pdfTaskPreviewModal()">Print</button>
    </div>

    <!-- task table -->
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>หัวข้อ</th>
                <th>สถานะ</th>
                <th>วันที่</th>
                <th style="width: 150px;">ดำเนินการ</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tasks as $task)
                <tr>
                    <td>{{ $task->title ?? '-' }}</td>
                    <td>{{ $task->status ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($task->updated_at)->format('Y-m-d') }}</td>

                    <td>
                        <button
                            class="btn btn-sm btn-outline-secondary"
                            onclick="openPdfPreview({{ $task->id ?? null }})">
                            รายละเอียด
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">ไม่พบข้อมูล!</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

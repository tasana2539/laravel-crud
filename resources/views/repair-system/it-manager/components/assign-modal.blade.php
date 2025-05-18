<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="assignForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">มอบหมายงาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="repair_id" id="repair_id">

                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">เลือกช่าง</label>
                        <select class="form-select" name="assigned_to" id="assigned_to" required>
                            <option value="" disabled selected>-- รายการช่าง --</option>
                            @foreach ($technicians as $tech)
                                <option value="{{ $tech->id }}">{{ $tech->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="priority" class="form-label">ความสำคัญ</label>
                        <select class="form-select" name="priority" id="priority" required>
                            <option value="low">ต่ำ</option>
                            <option value="medium">ปานกลาง</option>
                            <option value="high">สูง</option>
                            <option value="critical">วิกฤติ</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">หมายเหตุ</label>
                        <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                    </div>

                    <input type="hidden" name="status" value="assigned">
                    <input type="hidden" name="approved_by" id="approved_by">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary">มอบหมาย</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </form>
    </div>
</div>
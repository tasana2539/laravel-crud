<!-- update Modal -->
<div class="modal fade" id="adminUpdateModal" tabindex="-1" aria-labelledby="adminUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="adminUpdateForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขรายการ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="priority" class="form-label">หัวข้อ</label>
                        <input type="text" class="form-control" name="title" id="title">
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
                        <label for="note" class="form-label">รายละเอียด</label>
                        <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">หมายเหตุ</label>
                        <input type="text" class="form-control" id="note" name="note">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-outline-primary">บันทึก</button>
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" id="updateForm">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">แก้ไขรายการ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="title" class="form-label">หัวข้อ</label>
                        <input type="text" class="form-control" name="title" id="title">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">สถานะ</label>
                        <select class="form-select" name="status" id="status" required>
                            <option value="in_progress">กำลังดำเนินการ</option>
                            <option value="returned">ขอรายละเอียดเพิ่มเติม</option>
                            <option value="completed">เสร็จสิ้น</option>
                            <option value="rejected">ปฏิเสธ</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="note" class="form-label">หมายเหตุ</label>
                        <textarea name="note" id="note" class="form-control" rows="3"></textarea>
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
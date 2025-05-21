@extends('layouts.app')

@section('content')
<div class="card-body mb-4">
  <div class="row">
    <a type="button" class="btn btn-outline-primary col-md-1" href="{{ route(auth()->user()->role.'.requests.index') }}">
        dashboard
    </a>


  </div>
</div>
<div class="card">
  <div class="card-header">
    ตารางข้อมูล
  </div>
  <div class="card-body">

    <!-- ตารางแจ้งซ่อม -->
    <div class="table-responsive">
        @livewire('task.task-table')
    </div>
  </div>
</div>

@include('repair-system.export.task-export-modal')

<script>
    function pdfTaskPreviewModal() {
        fetch("{{ route('task.pdf.request') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Content-Type": "application/json"
            }
        })
        .then(() => {
            // เมื่อ session พร้อมแล้ว เปลี่ยน src ของ iframe
            const iframe = document.getElementById('pdfTaskIframe');
            iframe.src = "{{ route('task.pdf.view') }}";

            // เปิด modal
            const modal = new bootstrap.Modal(document.getElementById('pdfTaskPreviewModal'));
            modal.show();
        });
    }
</script>

@endsection

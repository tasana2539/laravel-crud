<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Scripts -->
    </head><script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

</head>
<body>
    <h2 class="mt-3">ประวัติการดำเนินงาน</h2>

    <table class="table table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>หัวข้อ</th>
                <th style="width:100px">รายละเอียด</th>
                <th>หมายเหตุ</th>
                <th>ผู้แจ้ง</th>
                <th>ช่าง</th>
                <th>ผู้มอบหมาย</th>
                <th>ความสำคัญ</th>
                <th>สถานะ</th>
                <th>วันที่แจ้ง</th>
                <th>วันที่แก้ไข</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach($repairs as $log)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $log->title ?? '-' }}</td>
                    <td class="text-break">{{ $log->description ?? '-' }}</td>
                    <td>{{ $log->note ?? '-' }}</td>
                    <td>{{ $log->created_by_name ?? '-' }}</td>
                    <td>{{ $log->assigned_to_name ?? '-' }}</td>
                    <td>{{ $log->approved_by_name ?? '-' }}</td>
                    <td>{{ $log->priority ?? '-' }}</td>
                    <td>{{ $log->status ?? '-' }}</td>
                    <td>{{ $log->created_at ? \Carbon\Carbon::parse($log->created_at)->format('Y-m-d') : '-' }}</td>
                    <td>{{ $log->updated_at ? \Carbon\Carbon::parse($log->updated_at)->format('Y-m-d') : '-' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

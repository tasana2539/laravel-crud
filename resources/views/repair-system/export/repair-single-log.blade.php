<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "thsarabun";
            font-size: 16pt;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            margin: 0;
            font-size: 24pt;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 50px;
        }
        .signature {
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>ใบแจ้งซ่อม</h1>
    </div>

    <table>
        <tr>
            <th>หัวข้อ</th>
            <td>{{ $repair->title }}</td>
        </tr>
        
        <tr>
            <th>ชื่อผู้แจ้ง</th>
            <td>{{ $repair->user->name }}</td>
        </tr>
        <tr>
            <th>ช่างผู้รับผิดชอบ</th>
            <td>{{ $repair->technician->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>สถานะล่าสุด</th>
            <td>{{ $repair->latestLog->status_after ?? '-' }}</td>
        </tr>
        <tr>
            <th>อัปเดตล่าสุดเมื่อ</th>
            <td>
                @if($repair->latestLog)
                    {{ $repair->latestLog->created_at }}
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <th>ผู้ดำเนินการอัปเดตล่าสุด</th>
            <td>{{ $repair->latestLog->updater->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>หมายเหตุ</th>
            <td>{{ $repair->latestLog?->note ?? '-' }}</td>
        </tr>
    </table>

    <h5 class="mt-3">รายละเอียด</h5>
    <div class="w-100">
        <textarea class="form-control">{{ $repair->description ?? '-' }}</textarea>

    </div>
    <h5 class="mt-3">ประวัติการดำเนินงาน</h5>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th scope="col">สถานะ</th>
                <th scope="col">โดย</th>
                <th scope="col">วันที่</th>
            </tr>
        </thead>
        <tbody>
            @foreach($repair->logs as $log)
                <tr>
                    <td>
                        <span class="fw-bold">{{ $log->status_after }}</span>
                    </td>
                    <td>{{ $log->updater->name ?? '-' }}</td>
                    <td>{{ $log->updated_at->format('d/m/Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="">
            <div class="signature">
                ............................................<br>
                ผู้แจ้งซ่อม
            </div>

            <div class="signature">
                ............................................<br>
                ช่างผู้ดำเนินการ
            </div>
        </div>
    </div>

</body>
</html>

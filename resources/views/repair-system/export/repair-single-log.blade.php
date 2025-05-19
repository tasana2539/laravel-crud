<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
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
        .logo {
            width: 100px;
            margin-bottom: 10px;
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
        .qr {
            margin-top: 20px;
            text-align: right;
        }
    </style>
</head>
<body>

    <div class="header">
        {{-- โลโก้บริษัท (ปรับ path ตามจริง) --}}
        <h1>ใบแจ้งซ่อม</h1>
    </div>

    {{-- ตารางข้อมูล --}}
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
        <tr>
            <th>ความคิดเห็น</th>
            <td></td>
        </tr>
    </table>

    {{-- ลายเซ็น --}}
    <div class="footer">
        <div class="d-flex justify-content-between">
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

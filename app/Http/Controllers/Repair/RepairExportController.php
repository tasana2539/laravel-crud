<?php

namespace App\Http\Controllers\Repair;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
use App\Models\RepairRequest as Repair;

class RepairExportController extends Controller
{
    public function requestPdf(Request $request)
    {
        // เก็บ ID ลง Session
        session(['pdf_repair_id' => $request->repair_id]);

        // Redirect ไปแสดง PDF โดยไม่โชว์ id
        return redirect()->route('repair.pdf.single-view');
    }
    
    public function viewPdf(Request $request)
    {
        $id = session('pdf_repair_id');
        if (!$id) {
            abort(403, 'PDF access denied');
        }

        $repair = Repair::with(['user', 'technician', 'latestLog.updater'])->findOrFail($id);

        // mPDF ตั้งค่า font ภาษาไทย
        $defaultConfig = (new ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];

        $defaultFontConfig = (new FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
        $mpdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [resource_path('fonts/')]),
            'fontdata' => $fontData + [
                'thsarabun' => [
                    'R' => 'THSarabunNew.ttf',
                    'B' => 'THSarabunNew-Bold.ttf',
                    'I' => 'THSarabunNew-Italic.ttf',
                    'BI' => 'THSarabunNew-BoldItalic.ttf',
                ],
            ],
            'default_font' => 'thsarabun',
        ]);
        $html = view('repair-system.export.repair-single-log', compact('repair'))->render();
        $mpdf->WriteHTML($html);
        $pdfContent = $mpdf->Output('', 'S');

        // แยกดาวน์โหลดหรือแสดง
        $disposition = $request->has('download') ? 'attachment' : 'inline';

        $filename = date('Y-m-d_H-i-s') . '-document.pdf';
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', $disposition . '; filename='.$filename)
            ->header('Content-Length', strlen($pdfContent));
    }

}
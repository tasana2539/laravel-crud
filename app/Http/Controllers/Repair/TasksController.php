<?php

namespace App\Http\Controllers\Repair;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('repair-system.task.all-task-log');
    }

    public function requestPdf()
    {
        return redirect()->route('task.pdf.view');
    }

    public function viewPdf(Request $request)
    {

        $repairs = DB::table('repair_requests')
        ->join('repair_logs', 'repair_requests.id', '=', 'repair_logs.repair_request_id')

        // Join users table multiple times with aliases
        ->leftJoin('users as assigned_user', 'repair_requests.assigned_to', '=', 'assigned_user.id')
        ->leftJoin('users as approved_user', 'repair_requests.approved_by', '=', 'approved_user.id')
        ->leftJoin('users as updated_user', 'repair_logs.updated_by', '=', 'updated_user.id')
        ->leftJoin('users as user_id', 'repair_requests.user_id', '=', 'user_id.id')

        // Select needed fields
        ->select(
            'repair_requests.*',
            'repair_logs.*',
            'assigned_user.name as assigned_to_name',
            'approved_user.name as approved_by_name',
            'updated_user.name as updated_by_name',
            'user_id.name as created_by_name'
        )
        ->get();

        //dd($repairs);

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
        $html = view('repair-system.export.task-export', compact('repairs'))->render();
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

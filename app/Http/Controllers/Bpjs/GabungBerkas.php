<?php

namespace App\Http\Controllers\Bpjs;

use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class GabungBerkas extends Controller
{
    function gabungBerkas(Request $request){
        $cekINACBG = DB::table('bw_file_casemix_inacbg')->where('no_rawat', $request->cariNorawat)->first();
        $cekRESUMEDLL = DB::table('bw_file_casemix_remusedll')->where('no_rawat', $request->cariNorawat)->first();
        $cekSCAN = DB::table('bw_file_casemix_scan')->where('no_rawat', $request->cariNorawat)->first();

        // PROSES BNDLING=============================================
        try {
            $pdfPathINACBG = $cekINACBG ? public_path('storage/file_inacbg/'.$cekINACBG->file) : null;
            $pdfPathRESUMEDLL = $cekRESUMEDLL ? public_path('storage/resume_dll/'.$cekRESUMEDLL->file) : null;
            $pdfPathSCAN = $cekSCAN ? public_path('storage/file_scan/'.$cekSCAN->file) : null;
            $pdf = new Fpdi();
            function importPages($pdf, $pdfPath)
            {
                $pageCount = $pdf->setSourceFile($pdfPath);
                for ($pageNumber = 1; $pageNumber <= $pageCount; $pageNumber++) {
                    $template = $pdf->importPage($pageNumber);
                    $size = $pdf->getTemplateSize($template);
                    $pdf->AddPage($size['orientation'], $size);
                    $pdf->useTemplate($template);
                }
            }
            importPages($pdf, $pdfPathINACBG);
            importPages($pdf, $pdfPathRESUMEDLL);

            if ($pdfPathSCAN) {
                importPages($pdf, $pdfPathSCAN);
            }
            $no_rawatSTR = str_replace('/', '', $request->cariNorawat);
            $path_file = 'HASIL' . '-' . $no_rawatSTR.'.pdf';
            $outputPath = public_path('hasil_pdf/'.$path_file);
            $pdf->Output($outputPath, 'F');
            DB::beginTransaction();

                $cekBerkas = DB::table('bw_file_casemix_hasil')
                    ->where('no_rawat', $request->cariNorawat)
                    ->exists();
                if (!$cekBerkas) {
                    DB::table('bw_file_casemix_hasil')->insert([
                        'no_rkm_medis' => $request->no_rkm_medis,
                        'no_rawat' => $request->cariNorawat,
                        'file' => $path_file,
                    ]);
                    DB::commit();
                }

            Session::forget('tgl1');
            Session::forget('tgl2');
            // Session::forget('page');
            Session::forget('statusLanjut');
            if ($request->statusLanjut === 'Ranap') {
                return redirect('/cari-list-pasein-ranap?tgl1=' . $request->tgl1 . '&tgl2=' . $request->tgl2);
            }else{
                return redirect('/cari-list-pasein-ralan?tgl1=' . $request->tgl1 . '&tgl2=' . $request->tgl2 /*. '&page='. $request->page*/);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('errorBundling', 'Gagal Menggabungkan Berkas, Silahkan Upload File Inacbg Dan simpan File Kahnza.');
        }
    }
}

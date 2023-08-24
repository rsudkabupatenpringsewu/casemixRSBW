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
        // GET PASIEN
        $noRawat = $request->cariNorawat;
        $cekNorawat = DB::table('reg_periksa')
        ->select('reg_periksa.status_lanjut', 'pasien.nm_pasien', 'reg_periksa.no_rkm_medis')
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->where('no_rawat', '=', $noRawat);
        $getpasien = $cekNorawat->first();
        // INACBG
        $cekINACBG = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $noRawat)
                ->where('jenis_berkas', 'INACBG')
                ->first();
        // RESEUMEDLL
        $cekRESUMEDLL = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $noRawat)
        ->where('jenis_berkas', 'RESUMEDLL')
        ->first();
        // SCAN
        $cekSCAN = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $noRawat)
        ->where('jenis_berkas', 'SCAN')
        ->first();

        // PROSES BNDLING=============================================
        $pdf = new Fpdi();
        if (!$cekSCAN){
            $pdfPathINACBG = public_path('storage/file_inacbg/'.$cekINACBG->file);
            $pdfPathRESUMEDLL = public_path('storage/resume_dll/'.$cekRESUMEDLL->file);
            // INACBG
            $pageCountINACBG = $pdf->setSourceFile($pdfPathINACBG);
            for ($pageNumber = 1; $pageNumber <= $pageCountINACBG; $pageNumber++) {
                $template = $pdf->importPage($pageNumber);
                $size = $pdf->getTemplateSize($template);
                $pdf->AddPage($size['orientation'], $size);
                $pdf->useTemplate($template);
            }
            // RESEUMEDLL
            $pageCountRESUMEDLL = $pdf->setSourceFile($pdfPathRESUMEDLL);
            for ($pageNumber = 1; $pageNumber <= $pageCountRESUMEDLL; $pageNumber++) {
                $template = $pdf->importPage($pageNumber);
                $size = $pdf->getTemplateSize($template);
                $pdf->AddPage($size['orientation'], $size);
                $pdf->useTemplate($template);
            }
        }else{
            $pdfPathINACBG = public_path('storage/file_inacbg/'.$cekINACBG->file);
            $pdfPathRESUMEDLL = public_path('storage/resume_dll/'.$cekRESUMEDLL->file);
            $pdfPathSCAN = public_path('storage/file_scan/'.$cekSCAN->file);
            // INACBG
            $pageCountINACBG = $pdf->setSourceFile($pdfPathINACBG);
            for ($pageNumber = 1; $pageNumber <= $pageCountINACBG; $pageNumber++) {
                $template = $pdf->importPage($pageNumber);
                $size = $pdf->getTemplateSize($template);
                $pdf->AddPage($size['orientation'], $size);
                $pdf->useTemplate($template);
            }
            // RESEUMEDLL
            $pageCountRESUMEDLL = $pdf->setSourceFile($pdfPathRESUMEDLL);
            for ($pageNumber = 1; $pageNumber <= $pageCountRESUMEDLL; $pageNumber++) {
                $template = $pdf->importPage($pageNumber);
                $size = $pdf->getTemplateSize($template);
                $pdf->AddPage($size['orientation'], $size);
                $pdf->useTemplate($template);
            }
            // SCAN
            $pageCountSCAN = $pdf->setSourceFile($pdfPathSCAN);
            for ($pageNumber = 1; $pageNumber <= $pageCountSCAN; $pageNumber++) {
                $template = $pdf->importPage($pageNumber);
                $size = $pdf->getTemplateSize($template);
                $pdf->AddPage($size['orientation'], $size);
                $pdf->useTemplate($template);
            }
        }
        $no_rawatSTR = str_replace('/', '', $noRawat);
        $path_file = 'HASIL' . '-' . $no_rawatSTR.'.pdf';
        $outputPath = public_path('hasil_pdf/'.$path_file);
        $pdf->Output($outputPath, 'F');

        $cekBerkas = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $noRawat)
            ->where('jenis_berkas', 'HASIL')
            ->exists();
        if (!$cekBerkas){
            DB::connection('db_con2')->table('file_casemix')->insert([
                'no_rkm_medis' => $getpasien->no_rkm_medis,
                'no_rawat' => $noRawat,
                'nama_pasein' => $getpasien->nm_pasien,
                'jenis_berkas' => 'HASIL',
                'file' => $path_file,
            ]);
        }
        Session::forget('tgl1');
        Session::forget('tgl2');
        Session::forget('statusLanjut');
        if ($request->statusLanjut === 'Ranap') {
            return redirect('/cari-list-pasein-ranap?tgl1=' . $request->tgl1 . '&tgl2=' . $request->tgl2);
        }else{
            return redirect('/cari-list-pasein-ralan?tgl1=' . $request->tgl1 . '&tgl2=' . $request->tgl2);
        }
    }
}

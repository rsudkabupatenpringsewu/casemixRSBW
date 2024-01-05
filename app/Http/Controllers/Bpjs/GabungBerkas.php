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
        $noRawat = $request->cariNorawat;
        $cekNorawat = DB::table('reg_periksa')
            ->select('reg_periksa.status_lanjut', 'pasien.nm_pasien', 'reg_periksa.no_rkm_medis')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->where('no_rawat', '=', $noRawat);
        $getpasien = $cekNorawat->first();

        $fileCasemix = DB::connection('db_con2')->table('file_casemix')
            ->where('no_rawat', $noRawat)
            ->whereIn('jenis_berkas', ['INACBG', 'RESUMEDLL', 'SCAN'])
            ->get();
        $cekINACBG = $fileCasemix->where('jenis_berkas', 'INACBG')->first();
        $cekRESUMEDLL = $fileCasemix->where('jenis_berkas', 'RESUMEDLL')->first();
        $cekSCAN = $fileCasemix->where('jenis_berkas', 'SCAN')->first();

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
            $no_rawatSTR = str_replace('/', '', $noRawat);
            $path_file = 'HASIL' . '-' . $no_rawatSTR.'.pdf';
            $outputPath = public_path('hasil_pdf/'.$path_file);
            $pdf->Output($outputPath, 'F');
            DB::connection('db_con2')->beginTransaction();

                $cekBerkas = DB::connection('db_con2')->table('file_casemix')
                    ->where('no_rawat', $noRawat)
                    ->where('jenis_berkas', 'HASIL')
                    ->exists();
                if (!$cekBerkas) {
                    DB::connection('db_con2')->table('file_casemix')->insert([
                        'no_rkm_medis' => $getpasien->no_rkm_medis,
                        'no_rawat' => $noRawat,
                        'nama_pasein' => $getpasien->nm_pasien,
                        'jenis_berkas' => 'HASIL',
                        'file' => $path_file,
                    ]);
                    DB::connection('db_con2')->commit();
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

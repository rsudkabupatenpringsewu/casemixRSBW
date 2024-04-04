<?php

namespace App\Services;

use setasign\Fpdi\Fpdi;
use Illuminate\Support\Facades\DB;

class GabungPdfService
{
    public static function printPdf($no_rawat, $no_rkm_medis)
    {
        $cekINACBG = DB::table('bw_file_casemix_inacbg')->where('no_rawat', $no_rawat)->first();
        $cekRESUMEDLL = DB::table('bw_file_casemix_remusedll')->where('no_rawat', $no_rawat)->first();
        $cekSCAN = DB::table('bw_file_casemix_scan')->where('no_rawat', $no_rawat)->first();

        // PROSES BNDLING=============================================
        $pdfPathINACBG = $cekINACBG ? public_path('storage/file_inacbg/' . $cekINACBG->file) : null;
        $pdfPathRESUMEDLL = $cekRESUMEDLL ? public_path('storage/resume_dll/' . $cekRESUMEDLL->file) : null;
        $pdfPathSCAN = $cekSCAN ? public_path('storage/file_scan/' . $cekSCAN->file) : null;
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
        $no_rawatSTR = str_replace('/', '', $no_rawat);
        $path_file = 'HASIL' . '-' . $no_rawatSTR . '.pdf';
        $outputPath = public_path('hasil_pdf/' . $path_file);
        $pdf->Output($outputPath, 'F');
        DB::beginTransaction();

        $cekBerkas = DB::table('bw_file_casemix_hasil')
            ->where('no_rawat', $no_rawat)
            ->exists();
        if (!$cekBerkas) {
            DB::table('bw_file_casemix_hasil')->insert([
                'no_rkm_medis' => $no_rkm_medis,
                'no_rawat' => $no_rawat,
                'file' => $path_file,
            ]);
            DB::commit();
        }
    }
}

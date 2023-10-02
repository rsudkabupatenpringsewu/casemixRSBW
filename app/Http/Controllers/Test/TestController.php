<?php

namespace App\Http\Controllers\Test;

use setasign\Fpdi\Fpdi;
use Spatie\PdfToImage\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
// TEST RADIOLOGI ===========================================
    // public function Test() {
    //     $noRawat = '2023/08/03/000158';
    //     $getLaborat = DB::table('periksa_lab')
    //     ->select('periksa_lab.no_rawat', 'reg_periksa.no_rkm_medis', 'pasien.nm_pasien', 'pasien.jk', 'pasien.alamat',
    //             'pasien.umur', 'petugas.nama as nama_petugas','petugas.nip', 'periksa_lab.tgl_periksa', 'periksa_lab.jam',
    //             'periksa_lab.dokter_perujuk', 'periksa_lab.kd_dokter', 'dokter.nm_dokter', 'dokter_pj.nm_dokter as nm_dokter_pj', 'penjab.png_jawab', 'kamar_inap.kd_kamar',
    //             'kamar.kd_bangsal', 'bangsal.nm_bangsal')
    //     ->join('reg_periksa','periksa_lab.no_rawat','=','reg_periksa.no_rawat')
    //     ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
    //     ->join('petugas','periksa_lab.nip','=','petugas.nip')
    //     ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
    //     ->join('dokter','periksa_lab.kd_dokter','=','dokter.kd_dokter')
    //     ->join('dokter as dokter_pj','periksa_lab.dokter_perujuk','=','dokter_pj.kd_dokter')
    //     ->join('kamar_inap','kamar_inap.no_rawat','=','reg_periksa.no_rawat')
    //     ->join('kamar','kamar_inap.kd_kamar','=','kamar.kd_kamar')
    //     ->join('bangsal','kamar.kd_bangsal','=','bangsal.kd_bangsal')
    //     ->where('periksa_lab.kategori','=','PK')
    //     ->where('periksa_lab.no_rawat','=', $noRawat)
    //     ->groupBy('periksa_lab.no_rawat','periksa_lab.tgl_periksa','periksa_lab.jam')
    //     ->orderBy('periksa_lab.tgl_periksa','desc')
    //     ->orderBy('periksa_lab.jam','desc')
    //     ->get();
    //     foreach ($getLaborat as $periksa) {
    //         $getPeriksaLab = DB::table('periksa_lab')
    //         ->select('jns_perawatan_lab.kd_jenis_prw', 'jns_perawatan_lab.nm_perawatan', 'periksa_lab.biaya')
    //         ->join('jns_perawatan_lab','periksa_lab.kd_jenis_prw','=','jns_perawatan_lab.kd_jenis_prw')
    //         ->where([
    //             ['periksa_lab.kategori', 'PK'],
    //             ['periksa_lab.no_rawat', $periksa->no_rawat],
    //             ['periksa_lab.tgl_periksa', $periksa->tgl_periksa],
    //             ['periksa_lab.jam', $periksa->jam],
    //         ])
    //         ->orderBy('jns_perawatan_lab.kd_jenis_prw','asc')
    //         ->get();
    //             foreach ($getPeriksaLab as $detaillab) {
    //                 $getDetailLab = DB::table('detail_periksa_lab')
    //                 ->select('detail_periksa_lab.no_rawat', 'detail_periksa_lab.tgl_periksa', 'template_laboratorium.Pemeriksaan', 'detail_periksa_lab.nilai', 'template_laboratorium.satuan', 'detail_periksa_lab.nilai_rujukan', 'detail_periksa_lab.biaya_item', 'detail_periksa_lab.keterangan', 'detail_periksa_lab.kd_jenis_prw')
    //                 ->join('template_laboratorium','detail_periksa_lab.id_template','=','template_laboratorium.id_template')
    //                 ->where([
    //                     ['detail_periksa_lab.kd_jenis_prw', $detaillab->kd_jenis_prw],
    //                     ['detail_periksa_lab.no_rawat', $periksa->no_rawat],
    //                     ['detail_periksa_lab.tgl_periksa', $periksa->tgl_periksa],
    //                     ['detail_periksa_lab.jam', $periksa->jam],
    //                     ])
    //                 ->orderBy('template_laboratorium.urut','asc')
    //                 ->get();
    //                 $detaillab->getDetailLab = $getDetailLab;
    //             }
    //         $periksa->getPeriksaLab = $getPeriksaLab;
    //     }

    // return view('test.test', [
    //     'getLaborat'=>$getLaborat,
    // ]);
    // }

    // TEST BUNDLING ======================================
    // public function Test(Request $request) {
    //     // GET PASIEN
    //     $noRawat = $request->cariNorawat;
    //     $cekNorawat = DB::table('reg_periksa')
    //     ->select('reg_periksa.status_lanjut', 'pasien.nm_pasien', 'reg_periksa.no_rkm_medis')
    //     ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
    //     ->where('no_rawat', '=', $noRawat);
    //     $getpasien = $cekNorawat->first();


    //     // INACBG
    //     $cekINACBG = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $noRawat)
    //             ->where('jenis_berkas', 'INACBG')
    //             ->first();
    //     $pdfPathINACBG = public_path('storage/file_inacbg/'.$cekINACBG->file);
    //     // RESEUMEDLL
    //     $cekRESUMEDLL = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $noRawat)
    //     ->where('jenis_berkas', 'RESUMEDLL')
    //     ->first();
    //     $pdfPathRESUMEDLL = public_path('storage/resume_dll/'.$cekRESUMEDLL->file);
    //     // SCAN
    //     $cekSCAN = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $noRawat)
    //     ->where('jenis_berkas', 'SCAN')
    //     ->first();
    //     $pdfPathSCAN = public_path('storage/file_scan/'.$cekSCAN->file);

    //     // PROSES BNDLING=============================================
    //     $pdf = new Fpdi();
    //         // INACBG
    //         $pageCountINACBG = $pdf->setSourceFile($pdfPathINACBG);
    //         for ($pageNumber = 1; $pageNumber <= $pageCountINACBG; $pageNumber++) {
    //             $template = $pdf->importPage($pageNumber);
    //             $size = $pdf->getTemplateSize($template);
    //             $pdf->AddPage($size['orientation'], $size);
    //             $pdf->useTemplate($template);
    //         }
    //         // RESEUMEDLL
    //         $pageCountRESUMEDLL = $pdf->setSourceFile($pdfPathRESUMEDLL);
    //         for ($pageNumber = 1; $pageNumber <= $pageCountRESUMEDLL; $pageNumber++) {
    //             $template = $pdf->importPage($pageNumber);
    //             $size = $pdf->getTemplateSize($template);
    //             $pdf->AddPage($size['orientation'], $size);
    //             $pdf->useTemplate($template);
    //         }
    //         // SCAN
    //         $pageCountSCAN = $pdf->setSourceFile($pdfPathSCAN);
    //         for ($pageNumber = 1; $pageNumber <= $pageCountSCAN; $pageNumber++) {
    //             $template = $pdf->importPage($pageNumber);
    //             $size = $pdf->getTemplateSize($template);
    //             $pdf->AddPage($size['orientation'], $size);
    //             $pdf->useTemplate($template);
    //         }

    //         $no_rawatSTR = str_replace('/', '', $noRawat);
    //         $path_file = 'HASIL' . '-' . $no_rawatSTR.'.pdf';
    //         $outputPath = public_path('hasil_pdf/'.$path_file);
    //         $pdf->Output($outputPath, 'F');

    //     $cekBerkas = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $noRawat)
    //         ->where('jenis_berkas', 'HASIL')
    //         ->exists();
    //     if (!$cekBerkas){
    //         DB::connection('db_con2')->table('file_casemix')->insert([
    //             'no_rkm_medis' => $getpasien->no_rkm_medis,
    //             'no_rawat' => $noRawat,
    //             'nama_pasein' => $getpasien->nm_pasien,
    //             'jenis_berkas' => 'HASIL',
    //             'file' => $path_file,
    //         ]);
    //     }
    //     return back()->with('success', 'Simpan success!');

    // }

    // TESSSSST AWAL MEDISSSSSSSSSSSSSSSS
    function Test(Request $request) {
        return view('test.test',[ ]);
    }
}

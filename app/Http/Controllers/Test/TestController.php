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
    // function Test(Request $request) {
    //     return view('test.test',[ ]);
    // }
//
    // // // TEST RESUME MEDIS

    // // function Test() {
    // //     $getSEPFisio = DB::table('pemeriksaan_ralan')
    // //     ->select('pemeriksaan_ralan.no_rawat',
    // //         'pemeriksaan_ralan.tgl_perawatan',
    // //         'pemeriksaan_ralan.jam_rawat',
    // //         'pemeriksaan_ralan.suhu_tubuh',
    // //         'pemeriksaan_ralan.tensi',
    // //         'pemeriksaan_ralan.nadi',
    // //         'pemeriksaan_ralan.respirasi',
    // //         'pemeriksaan_ralan.tinggi',
    // //         'pemeriksaan_ralan.berat',
    // //         'pemeriksaan_ralan.spo2',
    // //         'pemeriksaan_ralan.gcs',
    // //         'pemeriksaan_ralan.kesadaran',
    // //         'pemeriksaan_ralan.keluhan',
    // //         'pemeriksaan_ralan.pemeriksaan',
    // //         'pemeriksaan_ralan.alergi',
    // //         'pemeriksaan_ralan.lingkar_perut',
    // //         'pemeriksaan_ralan.rtl',
    // //         'pemeriksaan_ralan.penilaian',
    // //         'pemeriksaan_ralan.instruksi',
    // //         'pemeriksaan_ralan.evaluasi',
    // //         'pemeriksaan_ralan.nip',
    // //         'reg_periksa.no_rkm_medis',
    // //         'reg_periksa.kd_dokter',
    // //         'reg_periksa.kd_poli',
    // //         'poliklinik.nm_poli',
    // //         'pasien.nm_pasien',
    // //         'dokter.nm_dokter',
    // //         'reg_periksa.tgl_registrasi')
    // //     ->join('reg_periksa','pemeriksaan_ralan.no_rawat','=','reg_periksa.no_rawat')
    // //     ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
    // //     ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
    // //     ->join('dokter','reg_periksa.kd_dokter','=','dokter.kd_dokter')
    // //     ->where('pemeriksaan_ralan.no_rawat','=','2023/10/03/000484')
    // //     ->first();

    // //     return view('test.test', [
    // //         'getSEPFisio'=>$getSEPFisio,
    // //     ]);
    // }

    // function Test(){
    //     $kelasKamar =DB::table('kamar')
    //         ->select('kamar.kelas')
    //         ->where('kamar.statusdata','=','1')
    //         ->groupBy('kamar.kelas')
    //         ->get();

    //     $cariKelas = DB::table('reg_periksa')
    //         ->select('reg_periksa.no_rawat',
    //             'pasien.nm_pasien',
    //             'kamar.kelas',
    //             'reg_periksa.kd_pj',
    //             'penjab.png_jawab',
    //             'kamar.trf_kamar',
    //             'pasien.alamat',
    //             'kamar_inap.tgl_masuk',
    //             'kamar_inap.jam_masuk',
    //             'kamar_inap.tgl_keluar',
    //             'kamar_inap.jam_keluar',
    //             'kamar_inap.lama')
    //         ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
    //         ->join('kamar_inap','reg_periksa.no_rawat','=','kamar_inap.no_rawat')
    //         ->join('kamar','kamar_inap.kd_kamar','=','kamar.kd_kamar')
    //         ->join('penjab',function($join) {
    //             $join->on('pasien.kd_pj','=','penjab.kd_pj')
    //             ->on('reg_periksa.kd_pj','=','penjab.kd_pj');
    //         })
    //         ->whereBetween('kamar_inap.tgl_masuk',['2023-01-01','2023-07-31'])
    //         ->where('kamar.kelas','=','Kelas Vvip')
    //         ->where('pasien.kd_pj','!=','BPJ')
    //         ->get();

    //     return view('test.test', [
    //         'cariKelas'=>$cariKelas,
    //         'kelasKamar'=>$kelasKamar,
    //     ]);
    // }
    // function TestCari(Request $request){
    //     $tipeKelas = $request->kelasKamar;
    //     $tgl1 = $request->tgl1;
    //     $tgl2 = $request->tgl2;
    //     $penjab = $request->penjab;
    //     $kelasKamar =DB::table('kamar')
    //         ->select('kamar.kelas')
    //         ->where('kamar.statusdata','=','1')
    //         ->groupBy('kamar.kelas')
    //         ->get();

    //     $kelas = DB::table('reg_periksa')
    //         ->select('reg_periksa.no_rawat',
    //             'pasien.nm_pasien',
    //             'kamar.kelas',
    //             'reg_periksa.kd_pj',
    //             'penjab.png_jawab',
    //             'kamar.trf_kamar',
    //             'pasien.alamat',
    //             'kamar_inap.tgl_masuk',
    //             'kamar_inap.jam_masuk',
    //             'kamar_inap.tgl_keluar',
    //             'kamar_inap.jam_keluar',
    //             'kamar_inap.lama')
    //         ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
    //         ->join('kamar_inap','reg_periksa.no_rawat','=','kamar_inap.no_rawat')
    //         ->join('kamar','kamar_inap.kd_kamar','=','kamar.kd_kamar')
    //         ->join('penjab',function($join) {
    //             $join->on('pasien.kd_pj','=','penjab.kd_pj')
    //             ->on('reg_periksa.kd_pj','=','penjab.kd_pj');
    //         })
    //         ->whereBetween('kamar_inap.tgl_masuk',[$tgl1, $tgl2])
    //         ->where('kamar.kelas','=', $tipeKelas);
    //         if($penjab === 'BPJS'){
    //             $cariKelas = $kelas->where('pasien.kd_pj','=','BPJ')
    //             ->get();
    //         }else{
    //             $cariKelas = $kelas->where('pasien.kd_pj','!=','BPJ')
    //             ->get();

    //         }

    //         // dd($kelasKamar);
    //     return view('test.test', [
    //         'cariKelas'=>$cariKelas,
    //         'kelasKamar'=>$kelasKamar,
    //     ]);
    // }
//

function Test(){
    $test = 'tets';
    return view('test.test',[
        'test'=>$test,
    ]);    
}

}

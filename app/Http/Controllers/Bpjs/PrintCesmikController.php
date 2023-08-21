<?php

namespace App\Http\Controllers\Bpjs;

use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class PrintCesmikController extends Controller
{
    function printCasemix(Request $request, $id){
        $noRawat = urldecode($id);
        $cekNorawat = DB::table('reg_periksa')
        ->select('reg_periksa.status_lanjut', 'pasien.nm_pasien', 'reg_periksa.no_rkm_medis')
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->where('no_rawat', '=', $noRawat);
        $jumlahData = $cekNorawat->count();
        $statusLanjut = $cekNorawat->first();
        $getpasien = $cekNorawat->first();



        if ($jumlahData > 0) {
            // 1 BERKAS SEP
            $getSEP = DB::table('bridging_sep')
                ->select('bridging_sep.no_sep',
                    'reg_periksa.no_reg',
                    'reg_periksa.status_lanjut',
                    'reg_periksa.kd_pj',
                    'bridging_sep.no_rawat',
                    'bridging_sep.tglsep',
                    'bridging_sep.tglrujukan',
                    'bridging_sep.no_rujukan',
                    'bridging_sep.kdppkrujukan',
                    'bridging_sep.nmppkrujukan',
                    'bridging_sep.kdppkpelayanan',
                    'bridging_sep.nmppkpelayanan',
                    'bridging_sep.jnspelayanan',
                    'bridging_sep.catatan',
                    'bridging_sep.diagawal',
                    'bridging_sep.nmdiagnosaawal',
                    'bridging_sep.kdpolitujuan',
                    'bridging_sep.nmpolitujuan',
                    'bridging_sep.klsrawat',
                    'bridging_sep.klsnaik',
                    'bridging_sep.pembiayaan',
                    'bridging_sep.pjnaikkelas',
                    'bridging_sep.lakalantas',
                    'bridging_sep.user',
                    'bridging_sep.nomr',
                    'bridging_sep.nama_pasien',
                    'bridging_sep.tanggal_lahir',
                    'bridging_sep.peserta',
                    'bridging_sep.jkel',
                    'bridging_sep.no_kartu',
                    'bridging_sep.tglpulang',
                    'bridging_sep.asal_rujukan',
                    'bridging_sep.eksekutif',
                    'bridging_sep.cob',
                    'bridging_sep.notelep',
                    'bridging_sep.katarak',
                    'bridging_sep.tglkkl',
                    'bridging_sep.keterangankkl',
                    'bridging_sep.suplesi',
                    'bridging_sep.no_sep_suplesi',
                    'bridging_sep.kdprop',
                    'bridging_sep.nmprop',
                    'bridging_sep.kdkab',
                    'bridging_sep.nmkab',
                    'bridging_sep.kdkec',
                    'bridging_sep.nmkec',
                    'bridging_sep.noskdp',
                    'bridging_sep.kddpjp',
                    'bridging_sep.nmdpdjp',
                    'bridging_sep.tujuankunjungan',
                    'bridging_sep.flagprosedur',
                    'bridging_sep.penunjang',
                    'bridging_sep.asesmenpelayanan',
                    'bridging_sep.kddpjplayanan',
                    'bridging_sep.nmdpjplayanan')
                ->join('reg_periksa', 'reg_periksa.no_rawat', '=', 'bridging_sep.no_rawat')
                ->where('bridging_sep.no_rawat', '=', $noRawat)
                ->first();

            // 2 BERKAS RESUME
            if ($statusLanjut->status_lanjut === 'Ranap') {
                $getResume = DB::table('resume_pasien_ranap')
                    ->select('reg_periksa.no_rkm_medis',
                            'reg_periksa.umurdaftar',
                            'reg_periksa.almt_pj',
                            'pasien.nm_pasien',
                            'pasien.tgl_lahir',
                            'pasien.jk as jenis_kelamin',
                            'pasien.pekerjaan',
                            'dokter.nm_dokter',
                            'kamar_inap.kd_kamar',
                            'kamar_inap.tgl_masuk',
                            'kamar_inap.tgl_keluar',
                            'bangsal.nm_bangsal',
                            'resume_pasien_ranap.no_rawat',
                            'resume_pasien_ranap.kd_dokter',
                            'resume_pasien_ranap.diagnosa_awal',
                            'resume_pasien_ranap.alasan',
                            'resume_pasien_ranap.keluhan_utama',
                            'resume_pasien_ranap.pemeriksaan_fisik',
                            'resume_pasien_ranap.jalannya_penyakit',
                            'resume_pasien_ranap.pemeriksaan_penunjang',
                            'resume_pasien_ranap.hasil_laborat',
                            'resume_pasien_ranap.tindakan_dan_operasi',
                            'resume_pasien_ranap.obat_di_rs',
                            'resume_pasien_ranap.diagnosa_utama',
                            'resume_pasien_ranap.kd_diagnosa_utama',
                            'resume_pasien_ranap.diagnosa_sekunder',
                            'resume_pasien_ranap.kd_diagnosa_sekunder',
                            'resume_pasien_ranap.diagnosa_sekunder2',
                            'resume_pasien_ranap.kd_diagnosa_sekunder2',
                            'resume_pasien_ranap.diagnosa_sekunder3',
                            'resume_pasien_ranap.kd_diagnosa_sekunder3',
                            'resume_pasien_ranap.diagnosa_sekunder4',
                            'resume_pasien_ranap.kd_diagnosa_sekunder4',
                            'resume_pasien_ranap.prosedur_utama',
                            'resume_pasien_ranap.kd_prosedur_utama',
                            'resume_pasien_ranap.prosedur_sekunder',
                            'resume_pasien_ranap.kd_prosedur_sekunder',
                            'resume_pasien_ranap.prosedur_sekunder2',
                            'resume_pasien_ranap.kd_prosedur_sekunder2',
                            'resume_pasien_ranap.prosedur_sekunder3',
                            'resume_pasien_ranap.kd_prosedur_sekunder3',
                            'resume_pasien_ranap.alergi',
                            'resume_pasien_ranap.diet',
                            'resume_pasien_ranap.lab_belum',
                            'resume_pasien_ranap.edukasi',
                            'resume_pasien_ranap.cara_keluar',
                            'resume_pasien_ranap.ket_keluar',
                            'resume_pasien_ranap.keadaan',
                            'resume_pasien_ranap.ket_keadaan',
                            'resume_pasien_ranap.dilanjutkan',
                            'resume_pasien_ranap.ket_dilanjutkan',
                            'resume_pasien_ranap.kontrol',
                            'resume_pasien_ranap.obat_pulang')
                    ->join('reg_periksa','resume_pasien_ranap.no_rawat','=','reg_periksa.no_rawat')
                    ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
                    ->join('kamar_inap','kamar_inap.no_rawat','=','reg_periksa.no_rawat')
                    ->join('kamar','kamar_inap.kd_kamar','=','kamar.kd_kamar')
                    ->join('bangsal','kamar.kd_bangsal','=','bangsal.kd_bangsal')
                    ->join('dokter','resume_pasien_ranap.kd_dokter','=','dokter.kd_dokter')
                    ->where('resume_pasien_ranap.no_rawat','=', $noRawat)
                    ->first();
            } else {
                $getResume = DB::table('resume_pasien')
                    ->select('reg_periksa.tgl_registrasi',
                            'poliklinik.nm_poli',
                            'reg_periksa.almt_pj',
                            'pasien.pekerjaan',
                            'reg_periksa.umurdaftar',
                            'reg_periksa.no_rkm_medis',
                            'pasien.nm_pasien',
                            'pasien.tmp_lahir',
                            'pasien.tgl_lahir',
                            'dokter.kd_dokter',
                            'dokter.nm_dokter',
                            'pasien.jk',
                            'pasien.alamat',
                            'pasien.umur',
                            'reg_periksa.status_lanjut',
                            'reg_periksa.kd_pj',
                            'resume_pasien.no_rawat',
                            'resume_pasien.kd_dokter',
                            'resume_pasien.keluhan_utama',
                            'resume_pasien.jalannya_penyakit',
                            'resume_pasien.pemeriksaan_penunjang',
                            'resume_pasien.hasil_laborat',
                            'resume_pasien.diagnosa_utama',
                            'resume_pasien.kd_diagnosa_utama',
                            'resume_pasien.diagnosa_sekunder',
                            'resume_pasien.kd_diagnosa_sekunder',
                            'resume_pasien.diagnosa_sekunder2',
                            'resume_pasien.kd_diagnosa_sekunder2',
                            'resume_pasien.diagnosa_sekunder3',
                            'resume_pasien.kd_diagnosa_sekunder3',
                            'resume_pasien.diagnosa_sekunder4',
                            'resume_pasien.kd_diagnosa_sekunder4',
                            'resume_pasien.prosedur_utama',
                            'resume_pasien.kd_prosedur_utama',
                            'resume_pasien.prosedur_sekunder',
                            'resume_pasien.kd_prosedur_sekunder',
                            'resume_pasien.prosedur_sekunder2',
                            'resume_pasien.kd_prosedur_sekunder2',
                            'resume_pasien.prosedur_sekunder3',
                            'resume_pasien.kd_prosedur_sekunder3',
                            'resume_pasien.kondisi_pulang',
                            'resume_pasien.obat_pulang')
                    ->join('reg_periksa','resume_pasien.no_rawat','=','reg_periksa.no_rawat')
                    ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
                    ->join('dokter',function($join) {
                        $join->on('resume_pasien.kd_dokter','=','dokter.kd_dokter')
                        ->on('reg_periksa.kd_dokter','=','dokter.kd_dokter');
                    })
                    ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
                    ->where('resume_pasien.no_rawat','=', $noRawat)
                    ->first();
            }

            // RIANCIAN BIAYA
            $bilingRalan = DB::table('billing')
                ->select('billing.noindex',
                        'billing.no_rawat',
                        'billing.tgl_byr',
                        'billing.no',
                        'billing.nm_perawatan',
                        'billing.pemisah',
                        'billing.biaya',
                        'billing.jumlah',
                        'billing.tambahan',
                        'billing.totalbiaya',
                        'billing.status')
                ->where('billing.no_rawat','=', $noRawat)
                ->get();

            // BERKAS LABORAT
            $getLaborat = DB::table('periksa_lab')
            ->select('periksa_lab.no_rawat', 'reg_periksa.no_rkm_medis', 'pasien.nm_pasien', 'pasien.jk', 'pasien.alamat',
                    'pasien.umur', 'petugas.nama as nama_petugas','petugas.nip', 'periksa_lab.tgl_periksa', 'periksa_lab.jam',
                    'periksa_lab.dokter_perujuk', 'periksa_lab.kd_dokter', 'dokter.nm_dokter', 'dokter_pj.nm_dokter as nm_dokter_pj', 'penjab.png_jawab', 'kamar_inap.kd_kamar',
                    'kamar.kd_bangsal', 'bangsal.nm_bangsal')
            ->join('reg_periksa','periksa_lab.no_rawat','=','reg_periksa.no_rawat')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('petugas','periksa_lab.nip','=','petugas.nip')
            ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
            ->join('dokter','periksa_lab.kd_dokter','=','dokter.kd_dokter')
            ->join('dokter as dokter_pj','periksa_lab.dokter_perujuk','=','dokter_pj.kd_dokter')
            ->join('kamar_inap','kamar_inap.no_rawat','=','reg_periksa.no_rawat')
            ->join('kamar','kamar_inap.kd_kamar','=','kamar.kd_kamar')
            ->join('bangsal','kamar.kd_bangsal','=','bangsal.kd_bangsal')
            ->where('periksa_lab.kategori','=','PK')
            ->where('periksa_lab.no_rawat','=', $noRawat)
            ->groupBy('periksa_lab.no_rawat','periksa_lab.tgl_periksa','periksa_lab.jam')
            ->orderBy('periksa_lab.tgl_periksa','desc')
            ->orderBy('periksa_lab.jam','desc')
            ->get();
            foreach ($getLaborat as $periksa) {
                $getPeriksaLab = DB::table('periksa_lab')
                ->select('jns_perawatan_lab.kd_jenis_prw', 'jns_perawatan_lab.nm_perawatan', 'periksa_lab.biaya')
                ->join('jns_perawatan_lab','periksa_lab.kd_jenis_prw','=','jns_perawatan_lab.kd_jenis_prw')
                ->where([
                    ['periksa_lab.kategori', 'PK'],
                    ['periksa_lab.no_rawat', $periksa->no_rawat],
                    ['periksa_lab.tgl_periksa', $periksa->tgl_periksa],
                    ['periksa_lab.jam', $periksa->jam],
                ])
                ->orderBy('jns_perawatan_lab.kd_jenis_prw','asc')
                ->get();
                    foreach ($getPeriksaLab as $detaillab) {
                        $getDetailLab = DB::table('detail_periksa_lab')
                        ->select('detail_periksa_lab.no_rawat', 'detail_periksa_lab.tgl_periksa', 'template_laboratorium.Pemeriksaan', 'detail_periksa_lab.nilai', 'template_laboratorium.satuan', 'detail_periksa_lab.nilai_rujukan', 'detail_periksa_lab.biaya_item', 'detail_periksa_lab.keterangan', 'detail_periksa_lab.kd_jenis_prw')
                        ->join('template_laboratorium','detail_periksa_lab.id_template','=','template_laboratorium.id_template')
                        ->where([
                            ['detail_periksa_lab.kd_jenis_prw', $detaillab->kd_jenis_prw],
                            ['detail_periksa_lab.no_rawat', $periksa->no_rawat],
                            ['detail_periksa_lab.tgl_periksa', $periksa->tgl_periksa],
                            ['detail_periksa_lab.jam', $periksa->jam],
                            ])
                        ->orderBy('template_laboratorium.urut','asc')
                        ->get();
                        $detaillab->getDetailLab = $getDetailLab;
                    }
                $periksa->getPeriksaLab = $getPeriksaLab;
            }


            // BERKAS RADIOLOGI
            $getRadiologi = DB::table('hasil_radiologi')
            ->select('hasil_radiologi.no_rawat',
                    'hasil_radiologi.tgl_periksa',
                    'hasil_radiologi.jam',
                    'hasil_radiologi.hasil',
                    'reg_periksa.no_rkm_medis',
                    'reg_periksa.kd_dokter',
                    'pasien.nm_pasien',
                    'pasien.jk',
                    'pasien.umur',
                    'pasien.alamat',
                    'dokter.nm_dokter',
                    'kamar_inap.kd_kamar',
                    'bangsal.nm_bangsal',
                    'periksa_radiologi.nip',
                    'periksa_radiologi.kd_dokter as kd_dokter_pj',
                    'dokter_pj.nm_dokter as nm_dokter_pj',
                    'jns_perawatan_radiologi.nm_perawatan',
                    'pegawai.nama as nama_pegawai')
            ->join('reg_periksa','hasil_radiologi.no_rawat','=','reg_periksa.no_rawat')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('dokter','reg_periksa.kd_dokter','=','dokter.kd_dokter')
            ->join('kamar_inap','kamar_inap.no_rawat','=','reg_periksa.no_rawat')
            ->join('kamar','kamar_inap.kd_kamar','=','kamar.kd_kamar')
            ->join('bangsal','kamar.kd_bangsal','=','bangsal.kd_bangsal')
            ->join('periksa_radiologi',function($join) {
                $join->on('periksa_radiologi.no_rawat','=','hasil_radiologi.no_rawat')
                ->on('hasil_radiologi.jam','=','periksa_radiologi.jam');
            })
            ->join('jns_perawatan_radiologi','periksa_radiologi.kd_jenis_prw','=','jns_perawatan_radiologi.kd_jenis_prw')
            ->join('pegawai','periksa_radiologi.nip','=','pegawai.nik')
            ->join('dokter AS dokter_pj','periksa_radiologi.kd_dokter','=','dokter_pj.kd_dokter')
            ->where('hasil_radiologi.no_rawat','=', $noRawat)
            ->orderBy('hasil_radiologi.tgl_periksa','asc')
            ->get();


        } else {
            $jumlahData = '';
            $getSEP = '';
            $statusLanjut = '';
            $getResume = '';
            $bilingRalan = '';
            $getLaborat = '';
            $getRadiologi = '';
        }


        // VIEW
        $pdf = PDF::loadView('bpjs.printcasemix', [
            'jumlahData'=>$jumlahData,
            'getSEP'=>$getSEP,
            'statusLanjut'=>$statusLanjut,
            'getResume'=>$getResume,
            'bilingRalan'=>$bilingRalan,
            'getLaborat'=>$getLaborat,
            'getRadiologi'=>$getRadiologi,
        ]);

        $no_rawatSTR = str_replace('/', '', $noRawat);
        $pdfFilename = 'RESUMEDLL-'.$no_rawatSTR.'.pdf';
        Storage::disk('public')->put('resume_dll/' . $pdfFilename, $pdf->output());
        $cekBerkas = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $noRawat)
            ->where('jenis_berkas', 'RESUMEDLL')
            ->exists();
        if (!$cekBerkas){
            DB::connection('db_con2')->table('file_casemix')->insert([
                'no_rkm_medis' => $getpasien->no_rkm_medis,
                'no_rawat' => $noRawat,
                'nama_pasein' => $getpasien->nm_pasien,
                'jenis_berkas' => 'RESUMEDLL',
                'file' => $pdfFilename,
            ]);
        }

        $redirectUrl = url('/casemix-home-cari');
        $csrfToken = Session::token();
        $noRawat = $noRawat;
        $redirectUrlWithToken = $redirectUrl . '?' . http_build_query(['_token' => $csrfToken, 'cariNorawat' => $noRawat]);
        return redirect($redirectUrlWithToken);
    }
}

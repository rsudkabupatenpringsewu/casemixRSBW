<?php

namespace App\Http\Controllers\Bpjs;

use Spatie\PdfToImage\Pdf;
use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CesmikController extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    function Casemix(Request $request) {
        $getSetting = $this->cacheService->getSetting();
        $noRawat = $request->cariNorawat;
        $noSep = $request->cariNoSep;

        $cekNorawat = DB::table('reg_periksa')
        ->select('status_lanjut', 'kd_poli')
        ->where('no_rawat', '=', $noRawat);
        $jumlahData = $cekNorawat->count();
        $statusLanjut = $cekNorawat->first();

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
                ->where('bridging_sep.no_sep', '=', $noSep)
                ->first();

            // 2 BERKAS RESUME
            if($statusLanjut->kd_poli === 'U0061' || $statusLanjut->kd_poli === 'FIS'){ // U0061 = FisoTerapi
                $getResume = DB::table('pemeriksaan_ralan')
                ->select('pemeriksaan_ralan.no_rawat',
                    'pemeriksaan_ralan.tgl_perawatan',
                    'pemeriksaan_ralan.jam_rawat',
                    'pemeriksaan_ralan.suhu_tubuh',
                    'pemeriksaan_ralan.tensi',
                    'pemeriksaan_ralan.nadi',
                    'pemeriksaan_ralan.respirasi',
                    'pemeriksaan_ralan.tinggi',
                    'pemeriksaan_ralan.berat',
                    'pemeriksaan_ralan.spo2',
                    'pemeriksaan_ralan.gcs',
                    'pemeriksaan_ralan.kesadaran',
                    'pemeriksaan_ralan.keluhan',
                    'pemeriksaan_ralan.pemeriksaan',
                    'pemeriksaan_ralan.alergi',
                    'pemeriksaan_ralan.lingkar_perut',
                    'pemeriksaan_ralan.rtl',
                    'pemeriksaan_ralan.penilaian',
                    'pemeriksaan_ralan.instruksi',
                    'pemeriksaan_ralan.evaluasi',
                    'pemeriksaan_ralan.nip',
                    'reg_periksa.no_rkm_medis',
                    'reg_periksa.kd_dokter',
                    'reg_periksa.kd_poli',
                    'poliklinik.nm_poli',
                    'pasien.nm_pasien',
                    'dokter.nm_dokter',
                    'reg_periksa.tgl_registrasi')
                ->join('reg_periksa','pemeriksaan_ralan.no_rawat','=','reg_periksa.no_rawat')
                ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
                ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
                ->join('dokter','reg_periksa.kd_dokter','=','dokter.kd_dokter')
                ->where('pemeriksaan_ralan.no_rawat','=',$noRawat)
                ->first();
                $getKamarInap = '';
                $cekPasienKmrInap = '';
            }else{
                if ($statusLanjut->status_lanjut === 'Ranap') {
                    $getResume = DB::table('resume_pasien_ranap')
                        ->select('reg_periksa.no_rkm_medis',
                                'reg_periksa.umurdaftar',
                                'reg_periksa.almt_pj',
                                'reg_periksa.tgl_registrasi',
                                'reg_periksa.status_lanjut',
                                'kamar_inap.tgl_masuk',
                                'pasien.nm_pasien',
                                'pasien.tgl_lahir',
                                'pasien.alamat',
                                'pasien.jk as jenis_kelamin',
                                'pasien.pekerjaan',
                                'dokter.nm_dokter',
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
                        ->join('dokter','resume_pasien_ranap.kd_dokter','=','dokter.kd_dokter')
                        ->where('resume_pasien_ranap.no_rawat','=', $noRawat)
                        ->orderBy('reg_periksa.tgl_registrasi','asc')
                        ->orderBy('reg_periksa.status_lanjut','asc')
                        ->first();
                        if($getResume){
                            $getKamarInap = DB::table('kamar_inap')
                                ->select([
                                    'kamar_inap.tgl_keluar',
                                    'kamar_inap.jam_keluar',
                                    'kamar_inap.kd_kamar',
                                    'bangsal.nm_bangsal'
                                ])
                                ->join('kamar', 'kamar_inap.kd_kamar', '=', 'kamar.kd_kamar')
                                ->join('bangsal', 'kamar.kd_bangsal', '=', 'bangsal.kd_bangsal')
                                ->whereIn('kamar_inap.no_rawat', [$getResume->no_rawat])
                                ->orderByDesc('tgl_keluar')
                                ->orderByDesc('jam_keluar')
                                ->limit(1)
                                ->first();
                            $cekPasienKmrInap = DB::table('kamar_inap')
                                ->whereIn('kamar_inap.no_rawat', [$getResume->no_rawat])
                                ->count();
                        }else{
                            $getKamarInap = '';
                            $cekPasienKmrInap = '';
                        }
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
                        $getKamarInap = '';
                        $cekPasienKmrInap = '';
                }
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
                        'kamar.kd_bangsal', 'poliklinik.nm_poli', 'bangsal.nm_bangsal')
                ->join('reg_periksa','periksa_lab.no_rawat','=','reg_periksa.no_rawat')
                ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
                ->join('petugas','periksa_lab.nip','=','petugas.nip')
                ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
                ->join('dokter','periksa_lab.kd_dokter','=','dokter.kd_dokter')
                ->join('dokter as dokter_pj','periksa_lab.dokter_perujuk','=','dokter_pj.kd_dokter')
                ->leftJoin('kamar_inap','kamar_inap.no_rawat','=','reg_periksa.no_rawat')
                ->leftJoin('kamar','kamar_inap.kd_kamar','=','kamar.kd_kamar')
                ->leftJoin('bangsal','kamar.kd_bangsal','=','bangsal.kd_bangsal')
                ->leftJoin('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
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
                    'poliklinik.nm_poli',
                    'periksa_radiologi.nip',
                    'periksa_radiologi.kd_dokter as kd_dokter_pj',
                    'dokter_pj.nm_dokter as nm_dokter_pj',
                    'jns_perawatan_radiologi.nm_perawatan',
                    'pegawai.nama as nama_pegawai')
            ->join('reg_periksa','hasil_radiologi.no_rawat','=','reg_periksa.no_rawat')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('dokter','reg_periksa.kd_dokter','=','dokter.kd_dokter')
            ->leftJoin('kamar_inap','kamar_inap.no_rawat','=','reg_periksa.no_rawat')
            ->leftJoin('kamar','kamar_inap.kd_kamar','=','kamar.kd_kamar')
            ->leftJoin('bangsal','kamar.kd_bangsal','=','bangsal.kd_bangsal')
            ->leftJoin('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
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

            // AWAL MEDIS
            $awalMedis = DB::table('penilaian_medis_igd')
            ->select('penilaian_medis_igd.no_rawat',
                'pasien.nm_pasien',
                'pasien.tgl_lahir',
                'reg_periksa.no_rkm_medis',
                'dokter.nm_dokter',
                'pasien.jk',
                'penilaian_medis_igd.tanggal',
                'penilaian_medis_igd.kd_dokter',
                'penilaian_medis_igd.anamnesis',
                'penilaian_medis_igd.hubungan',
                'penilaian_medis_igd.keluhan_utama',
                'penilaian_medis_igd.rps',
                'penilaian_medis_igd.rpd',
                'penilaian_medis_igd.rpk',
                'penilaian_medis_igd.rpo',
                'penilaian_medis_igd.alergi',
                'penilaian_medis_igd.keadaan',
                'penilaian_medis_igd.gcs',
                'penilaian_medis_igd.kesadaran',
                'penilaian_medis_igd.td',
                'penilaian_medis_igd.nadi',
                'penilaian_medis_igd.rr',
                'penilaian_medis_igd.suhu',
                'penilaian_medis_igd.spo',
                'penilaian_medis_igd.bb',
                'penilaian_medis_igd.tb',
                'penilaian_medis_igd.kepala',
                'penilaian_medis_igd.mata',
                'penilaian_medis_igd.gigi',
                'penilaian_medis_igd.leher',
                'penilaian_medis_igd.thoraks',
                'penilaian_medis_igd.abdomen',
                'penilaian_medis_igd.genital',
                'penilaian_medis_igd.ekstremitas',
                'penilaian_medis_igd.ket_fisik',
                'penilaian_medis_igd.ket_lokalis',
                'penilaian_medis_igd.ekg',
                'penilaian_medis_igd.rad',
                'penilaian_medis_igd.lab',
                'penilaian_medis_igd.diagnosis',
                'penilaian_medis_igd.tata')
            ->join('reg_periksa','penilaian_medis_igd.no_rawat','=','reg_periksa.no_rawat')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('dokter','penilaian_medis_igd.kd_dokter','=','dokter.kd_dokter')
            ->where('penilaian_medis_igd.no_rawat','=', $noRawat)
            ->first();

            // SURAT KEMATIAN
            $getSudartKematian = DB::table('pasien_mati')
            ->select('pasien_mati.tanggal',
                'pasien_mati.jam',
                'pasien_mati.no_rkm_medis',
                'pasien.nm_pasien',
                'pasien.jk',
                'pasien.tmp_lahir',
                'pasien.tgl_lahir',
                'pasien.gol_darah',
                'pasien.stts_nikah',
                'pasien.umur',
                'pasien.alamat',
                'pasien.agama',
                'pasien_mati.keterangan',
                'pasien_mati.temp_meninggal',
                'pasien_mati.icd1',
                'pasien_mati.icd2',
                'pasien_mati.icd3',
                'pasien_mati.icd4',
                'pasien_mati.kd_dokter',
                'dokter.nm_dokter',
                'reg_periksa.no_rawat')
            ->join('pasien','pasien_mati.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('dokter','pasien_mati.kd_dokter','=','dokter.kd_dokter')
            ->join('reg_periksa','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->where('reg_periksa.no_rawat','=', $noRawat)
            ->first();

        } else {
            $getSetting = '';
            $jumlahData = '';
            $getSEP = '';
            $statusLanjut = '';
            $getResume = '';
            $getKamarInap= '';
            $cekPasienKmrInap= '';
            $bilingRalan = '';
            $getLaborat = '';
            $getRadiologi = '';
            $awalMedis= '';
            $getSudartKematian = '';
        }

        // VIEW
        return view('bpjs.cesmik', [
            'getSetting'=>$getSetting,
            'jumlahData'=>$jumlahData,
            'getSEP'=>$getSEP,
            'statusLanjut'=>$statusLanjut,
            'getResume'=>$getResume,
            'getKamarInap'=>$getKamarInap,
            'cekPasienKmrInap'=>$cekPasienKmrInap,
            'bilingRalan'=>$bilingRalan,
            'getLaborat'=>$getLaborat,
            'getRadiologi'=>$getRadiologi,
            'awalMedis'=>$awalMedis,
            'getSudartKematian'=>$getSudartKematian,
        ]);

    }
}

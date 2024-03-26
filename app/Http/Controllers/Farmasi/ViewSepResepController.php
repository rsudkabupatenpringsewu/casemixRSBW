<?php

namespace App\Http\Controllers\Farmasi;

use PDF;
use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class ViewSepResepController extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    function ViewBerkasSepResep(Request $request) {
        $getSetting = $this->cacheService->getSetting();
        $noRawat = $request->cariNoRawat;
        $noSep = $request->cariNoSep;
        $cekNorawat = DB::table('reg_periksa')
        ->select('status_lanjut')
        ->where('no_rawat', '=', $noRawat);
        $jumlahData = $cekNorawat->count();

        if ($jumlahData > 0) {
            $pasien = DB::table('reg_periksa')
                ->join('pasien', 'pasien.no_rkm_medis', '=', 'reg_periksa.no_rkm_medis')
                ->join('penjab', 'penjab.kd_pj', '=', 'reg_periksa.kd_pj')
                ->leftJoin('bridging_sep','bridging_sep.no_rawat','=','reg_periksa.no_rawat')
                ->where('bridging_sep.no_sep', '=', $noSep)
                ->where('reg_periksa.no_rawat', '=', $noRawat)
                ->select('pasien.no_rkm_medis', 'pasien.nm_pasien', 'bridging_sep.no_sep', 'reg_periksa.no_rawat', 'penjab.png_jawab');
            $getPasien = $pasien->first();

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

            $berkasResep = DB::table('piutang')
                ->select('piutang.nota_piutang',
                    'piutang.nm_pasien',
                    'resep_obat.no_rawat',
                    'petugas.nama as nama_petugas',
                    'piutang.tgltempo',
                    'piutang.tgl_piutang',
                    'resep_obat.no_resep',
                    'piutang.nip',
                    'piutang.no_rkm_medis',
                    'piutang.catatan',
                    'piutang.ongkir',
                    'piutang.uangmuka',
                    'piutang.sisapiutang',
                    'bangsal.nm_bangsal',
                    'resep_obat.kd_dokter',
                    'dokter.nm_dokter',
                    'resep_obat.tgl_peresepan')
                ->join('petugas','piutang.nip','=','petugas.nip')
                ->join('bangsal','piutang.kd_bangsal','=','bangsal.kd_bangsal')
                ->join('detailpiutang','piutang.nota_piutang','=','detailpiutang.nota_piutang')
                ->join('databarang','detailpiutang.kode_brng','=','databarang.kode_brng')
                ->join('jenis','databarang.kdjns','=','jenis.kdjns')
                ->join('kodesatuan','detailpiutang.kode_sat','=','kodesatuan.kode_sat')
                ->leftJoin('resep_obat','resep_obat.no_rawat','=','piutang.nota_piutang')
                ->join('dokter','resep_obat.kd_dokter','=','dokter.kd_dokter')
                ->where('piutang.nota_piutang','=', $noRawat)
                ->groupBy('piutang.nota_piutang')
                ->orderBy('piutang.tgl_piutang','asc')
                ->orderBy('piutang.nota_piutang','asc')
                ->get();
                foreach( $berkasResep as $itemresep){
                    $detailberkasResep = DB::table('detailpiutang')
                    ->select('detailpiutang.nota_piutang',
                        'detailpiutang.kode_brng',
                        'databarang.nama_brng',
                        'detailpiutang.kode_sat',
                        'kodesatuan.satuan',
                        'detailpiutang.h_jual',
                        'detailpiutang.jumlah',
                        'detailpiutang.subtotal',
                        'detailpiutang.dis',
                        'detailpiutang.bsr_dis',
                        'detailpiutang.total',
                        'detailpiutang.no_batch',
                        'detailpiutang.no_faktur',
                        'detailpiutang.aturan_pakai')
                    ->join('databarang','detailpiutang.kode_brng','=','databarang.kode_brng')
                    ->join('kodesatuan','detailpiutang.kode_sat','=','kodesatuan.kode_sat')
                    ->join('jenis','databarang.kdjns','=','jenis.kdjns')
                    ->where('detailpiutang.nota_piutang','=', $itemresep->nota_piutang)
                    ->orderBy('detailpiutang.kode_brng','asc')
                    ->get();
                    $itemresep->detailberkasResep = $detailberkasResep;
                }
        }
        $cekBerkas = DB::table('file_farmasi')
            ->select('jenis_berkas')
            ->where('no_rawat', $noRawat)
            ->get();

        return view('farmasi.view-berkas-sep-resep', [
            'noRawat'=>$noRawat,
            'cekBerkas'=>$cekBerkas,
            'noSep'=>$noSep,
            'jumlahData'=>$jumlahData,
            'getPasien'=>$getPasien,
            'getSEP'=>$getSEP,
            'berkasResep'=>$berkasResep,
            'getSetting'=>$getSetting,
        ]);
    }

    // UPLOAD BERKAS
    function UploadBerkasFarmasi(Request $request) {
        if ($request->hasFile('file_scan_farmasi')) {
            $file = $request->file('file_scan_farmasi');
            $no_rawatSTR = str_replace('/', '', $request->no_rawat);
            $path_file = 'FILE-SCAN-FARMASI' . '-' . $no_rawatSTR. '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('file_scan_farmasi/' . $path_file, file_get_contents($file));
            $cekBerkas = DB::table('file_farmasi')->where('no_rawat', $request->no_rawat)
                ->where('jenis_berkas', 'FILE-SCAN-FARMASI')
                ->exists();
            if (!$cekBerkas){
                DB::table('file_farmasi')->insert([
                    'no_rkm_medis' => $request->no_rkm_medis,
                    'no_rawat' => $request->no_rawat,
                    'nama_pasein' => $request->nama_pasein,
                    'jenis_berkas' => 'FILE-SCAN-FARMASI',
                    'file' => $path_file,
                ]);
            }
           return back()->with('successupload', 'Berhasil Menyimpan Data & Mengunggah File');
        }
    }

    // DOWNLOAD BERKAS RESEP
    function DonwloadSEPResep(Request $request){
        $cekBerkas = DB::table('file_farmasi')
            ->select('file')
            ->where('jenis_berkas', 'SEP-RESEP')
            ->where('no_rawat', $request->no_rawat)
            ->first();
        $filePath = public_path('storage/file_sepresep_farmasi/' . $cekBerkas->file);
        return Response::download($filePath, $cekBerkas->file);
    }
    // DOWNLOAD HASIL GABUNG
    function DonwloadHasilGabung(Request $request){
        $cekBerkas = DB::table('file_farmasi')
            ->select('file')
            ->where('jenis_berkas', 'HASIL-FARMASI')
            ->where('no_rawat', $request->no_rawat)
            ->first();
        $filePath = public_path('hasil_farmasi_pdf/' . $cekBerkas->file);
        return Response::download($filePath, $cekBerkas->file);
    }

}

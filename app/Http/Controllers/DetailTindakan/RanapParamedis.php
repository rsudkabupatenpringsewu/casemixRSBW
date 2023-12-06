<?php

namespace App\Http\Controllers\DetailTindakan;

use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RanapParamedis extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    function RanapParamedis(Request $request) {
        $action = '/ranap-paramedis';
        $penjab = $this->cacheService->getPenjab();
        $petugas = $this->cacheService->getPetugas();
        $kdPenjamin = ($request->input('kdPenjamin') == null) ? "" : explode(',', $request->input('kdPenjamin'));
        $kdPetugas = ($request->input('kdPetugas') == null) ? "" : explode(',', $request->input('kdPetugas'));
        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;

        $getRanapParamedis = $result = DB::table('pasien')
            ->select(
                'rawat_inap_pr.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'rawat_inap_pr.kd_jenis_prw',
                'jns_perawatan_inap.nm_perawatan',
                'rawat_inap_pr.nip',
                'petugas.nama',
                'rawat_inap_pr.tgl_perawatan',
                'rawat_inap_pr.jam_rawat',
                'penjab.png_jawab',
                DB::raw("IFNULL(
                    (
                        SELECT bangsal.nm_bangsal
                        FROM kamar_inap
                        INNER JOIN kamar ON kamar_inap.kd_kamar = kamar.kd_kamar
                        INNER JOIN bangsal ON kamar.kd_bangsal = bangsal.kd_bangsal
                        WHERE kamar_inap.no_rawat = rawat_inap_pr.no_rawat
                        LIMIT 1
                    ),
                    'Ruang Terhapus'
                ) AS ruang"),
                'rawat_inap_pr.material',
                'rawat_inap_pr.bhp',
                'rawat_inap_pr.tarif_tindakanpr',
                'rawat_inap_pr.kso',
                'rawat_inap_pr.menejemen',
                'rawat_inap_pr.biaya_rawat',
                'bayar_piutang.tgl_bayar'
            )
            ->join('reg_periksa', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('rawat_inap_pr', 'rawat_inap_pr.no_rawat', '=', 'reg_periksa.no_rawat')
            ->join('jns_perawatan_inap', 'rawat_inap_pr.kd_jenis_prw', '=', 'jns_perawatan_inap.kd_jenis_prw')
            ->join('petugas', 'rawat_inap_pr.nip', '=', 'petugas.nip')
            ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->join('bayar_piutang', 'bayar_piutang.no_rawat', '=', 'rawat_inap_pr.no_rawat')
            ->whereBetween('bayar_piutang.tgl_bayar',[$tanggl1, $tanggl2])
            ->where(function ($query) use ($kdPenjamin, $kdPetugas) {
                if ($kdPenjamin) {
                    $query->whereIn('penjab.kd_pj', $kdPenjamin);
                }
                if ($kdPetugas) {
                    $query->whereIn('petugas.nip', $kdPetugas);
                }
            })
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->orderByDesc('rawat_inap_pr.no_rawat')
            ->get();

        return view('detail-tindakan.ranap-paramedis', [
            'action'=> $action,
            'penjab'=> $penjab,
            'petugas'=> $petugas,
            'getRanapParamedis'=> $getRanapParamedis,
        ]);
    }

}

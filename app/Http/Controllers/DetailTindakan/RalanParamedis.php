<?php

namespace App\Http\Controllers\DetailTindakan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class RalanParamedis extends Controller
{
    function RalanParamedis(Request $request) {
        $cacheKeyPenjab = 'chache_penjamin';
        if (Cache::has($cacheKeyPenjab)) {
                $penjab = Cache::get($cacheKeyPenjab);
        } else {
            $penjab = DB::table('penjab')
                ->select('penjab.kd_pj', 'penjab.png_jawab')
                ->where('penjab.status','=','1')
                ->get();
            Cache::put($cacheKeyPenjab, $penjab, 720);
        }
        // $cacheKeyPetugas = 'chache_petugas1';
        // if (Cache::has($cacheKeyPenjab)) {
        //         $petugas = Cache::get($cacheKeyPetugas);
        // } else {
            $petugas = DB::table('petugas')
                ->select('petugas.nip', 'petugas.nama')
                ->where('petugas.status','=','1')
                ->get();
        //     Cache::put($cacheKeyPetugas, $petugas, 720);
        // }
        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
        $kdPenjamin = ($request->input('kdPenjamin') == null) ? "" : explode(',', $request->input('kdPenjamin'));
        $kdPetugas = ($request->input('kdPetugas') == null) ? "" : explode(',', $request->input('kdPetugas'));

        $RalanParamedis = DB::table('pasien')
            ->select('rawat_jl_pr.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'rawat_jl_pr.kd_jenis_prw',
                'jns_perawatan.nm_perawatan',
                'rawat_jl_pr.nip',
                'petugas.nama',
                'rawat_jl_pr.tgl_perawatan',
                'rawat_jl_pr.jam_rawat',
                'penjab.png_jawab',
                'poliklinik.nm_poli',
                'rawat_jl_pr.material',
                'rawat_jl_pr.bhp',
                'rawat_jl_pr.tarif_tindakanpr',
                'rawat_jl_pr.kso',
                'rawat_jl_pr.menejemen',
                'rawat_jl_pr.biaya_rawat',
                'bayar_piutang.tgl_bayar')
            ->join('reg_periksa','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('rawat_jl_pr','rawat_jl_pr.no_rawat','=','reg_periksa.no_rawat')
            ->join('jns_perawatan','rawat_jl_pr.kd_jenis_prw','=','jns_perawatan.kd_jenis_prw')
            ->join('petugas','rawat_jl_pr.nip','=','petugas.nip')
            ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
            ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
            ->join('bayar_piutang','reg_periksa.no_rawat','=','bayar_piutang.no_rawat')
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
            ->orderBy('rawat_jl_pr.no_rawat','desc')
            ->get();
        return view('detail-tindakan.ralan-paramedis',[
            'penjab'=> $penjab,
            'petugas'=> $petugas,
            'RalanParamedis'=> $RalanParamedis,
        ]);
    }
}

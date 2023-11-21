<?php

namespace App\Http\Controllers\DetailTindakan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class RalanDokter extends Controller
{
    function RalanDokter(Request $request) {
        $actionCari = '/ralan-dokter';
        $cacheKey = 'chache_penjamin';
        if (Cache::has($cacheKey)) {
                $penjab = Cache::get($cacheKey);
        } else {
            $penjab = DB::table('penjab')
                ->select('penjab.kd_pj', 'penjab.png_jawab')
                ->where('penjab.status','=','1')
                ->get();
            Cache::put($cacheKey, $penjab, 720);
        }
        $dokter = DB::table('dokter')
            ->select('dokter.kd_dokter', 'dokter.nm_dokter')
            ->where('dokter.status','=','1')
            ->get();

        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
        if($request->input('kdPenjamin') == null){
            $kdPenjamin = "";
        } else {
            $kdPenjamin = explode(',', $request->input('kdPenjamin') ?? '');
        }
        if($request->input('kdDokter') == null){
            $kdDokter = "";
        } else {
            $kdDokter = explode(',', $request->input('kdDokter') ?? '');
        }

        $RalanDokter = DB::table('pasien')
            ->select('rawat_jl_dr.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'rawat_jl_dr.kd_jenis_prw',
                'jns_perawatan.nm_perawatan',
                'rawat_jl_dr.kd_dokter',
                'dokter.nm_dokter',
                'rawat_jl_dr.tgl_perawatan',
                'rawat_jl_dr.jam_rawat',
                'penjab.png_jawab',
                'poliklinik.nm_poli',
                'rawat_jl_dr.material',
                'rawat_jl_dr.bhp',
                'rawat_jl_dr.tarif_tindakandr',
                'rawat_jl_dr.kso',
                'rawat_jl_dr.menejemen',
                'rawat_jl_dr.biaya_rawat',
                'bayar_piutang.tgl_bayar')
            ->join('reg_periksa','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('rawat_jl_dr','reg_periksa.no_rawat','=','rawat_jl_dr.no_rawat')
            ->join('dokter','rawat_jl_dr.kd_dokter','=','dokter.kd_dokter')
            ->join('jns_perawatan','rawat_jl_dr.kd_jenis_prw','=','jns_perawatan.kd_jenis_prw')
            ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
            ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
            ->join('bayar_piutang','reg_periksa.no_rawat','=','bayar_piutang.no_rawat')
            ->whereBetween('bayar_piutang.tgl_bayar',[$tanggl1, $tanggl2])
            ->where(function ($query) use ($kdPenjamin) {
                if ($kdPenjamin) {
                    $query->whereIn('penjab.kd_pj', $kdPenjamin);
                }
            })
            ->where(function ($query) use ($kdDokter) {
                if ($kdDokter) {
                    $query->whereIn('rawat_jl_dr.kd_dokter', $kdDokter);
                }
            })
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->orderBy('rawat_jl_dr.no_rawat','desc')
            ->get();

        return view('detail-tindakan.ralan-dokter',[
            'actionCari'=> $actionCari,
            'penjab'=> $penjab,
            'dokter'=> $dokter,
            'RalanDokter'=> $RalanDokter,
        ]);
    }
}

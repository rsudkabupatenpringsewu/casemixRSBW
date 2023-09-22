<?php

namespace App\Http\Controllers\Farmasi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class SepResepController extends Controller
{
    // 1 LIST PASIEN
    function ListPasienFarmasi(){
        $tanggl1 = date('Y-m-d');
        $tanggl2 = date('Y-m-d');
        $daftarPasien = DB::table('reg_periksa')
            ->select('reg_periksa.no_rkm_medis',
                'reg_periksa.no_rawat',
                'reg_periksa.status_bayar',
                'bridging_sep.no_sep',
                'pasien.nm_pasien',
                'bridging_sep.tglsep',
                'poliklinik.nm_poli')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->leftJoin('bridging_sep','bridging_sep.no_rawat','=','reg_periksa.no_rawat')
            ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
            ->where('reg_periksa.kd_pj','=', 'BPJ')
            ->whereBetween('reg_periksa.tgl_registrasi',[$tanggl1, $tanggl2])
            ->orderBy('bridging_sep.no_rawat', 'asc')
            ->get();
        return view('farmasi.listpasien', ['daftarPasien'=>$daftarPasien]);
    }
    // 2 CARI LIST PASIEN
    function CariListPasienFarmasi(Request $request){
        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
        $daftarPasien = DB::table('reg_periksa')
            ->select('reg_periksa.no_rkm_medis',
                'reg_periksa.no_rawat',
                'reg_periksa.status_bayar',
                'bridging_sep.no_sep',
                'pasien.nm_pasien',
                'bridging_sep.tglsep',
                'poliklinik.nm_poli')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->leftJoin('bridging_sep','bridging_sep.no_rawat','=','reg_periksa.no_rawat')
            ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
            ->where('reg_periksa.kd_pj','=', 'BPJ')
            ->whereBetween('reg_periksa.tgl_registrasi',[$tanggl1, $tanggl2])
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->orderBy('bridging_sep.no_rawat', 'asc')
            ->get();
        return view('farmasi.listpasien', ['daftarPasien'=>$daftarPasien]);
    }

}

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
            $downloadBerkas = DB::connection('db_con2')
                ->table('file_casemix')
                ->select('no_rawat')
                ->whereIn('no_rawat', $daftarPasien->pluck('no_rawat')->toArray())
                ->where('jenis_berkas', 'SEP-RESEP')
                ->get();

        session(['tgl1' => $tanggl1]);
        session(['tgl2' => $tanggl2]);
        return view('farmasi.listpasien', [
            'daftarPasien'=>$daftarPasien,
            'downloadBerkas'=>$downloadBerkas
        ]);
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
            $downloadBerkas = DB::connection('db_con2')
                ->table('file_farmasi')
                ->select('no_rawat')
                ->whereIn('no_rawat', $daftarPasien->pluck('no_rawat')->toArray())
                ->where('jenis_berkas', 'SEP-RESEP')
                ->get();

        session(['tgl1' => $request->tgl1]);
        session(['tgl2' => $request->tgl2]);
        session(['cariNomor' => $cariNomor]);
        return view('farmasi.listpasien', [
            'daftarPasien'=>$daftarPasien,
            'downloadBerkas'=>$downloadBerkas
        ]);
    }

}

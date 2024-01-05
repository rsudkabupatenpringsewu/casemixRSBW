<?php

namespace App\Http\Controllers\Bpjs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ListPasienRanap extends Controller
{
    function lisPaseinRanap(Request $request){
        $tanggl1 = date('Y-m-d');
        $tanggl2 = date('Y-m-d');
        $penjamnin = 'BPJ';

        $daftarPasien = DB::table('reg_periksa')
            ->select('reg_periksa.no_rkm_medis',
                'reg_periksa.no_rawat',
                'reg_periksa.status_bayar',
                'kamar_inap.tgl_masuk',
                'bridging_sep.no_sep',
                'bridging_sep.jnspelayanan',
                'pasien.nm_pasien',
                'poliklinik.nm_poli')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->leftJoin('bridging_sep','bridging_sep.no_rawat','=','reg_periksa.no_rawat')
            ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
            ->leftJoin('kamar_inap','kamar_inap.no_rawat','=','reg_periksa.no_rawat')
            ->whereBetween('kamar_inap.tgl_keluar',[$tanggl1, $tanggl2])
            ->where('reg_periksa.status_lanjut','=','Ranap')
            ->where('reg_periksa.kd_pj','=', $penjamnin)
            ->get();

        // GET ALL BERKAS
        $daftarPasien->map(function ($item) {
            $item->getAllBerkas = DB::connection('db_con2')
                ->table('file_casemix')
                ->select('jenis_berkas', 'file')
                ->where('no_rawat', $item->no_rawat)
                ->get();
        });

        session(['tgl1' => $tanggl1]);
        session(['tgl2' => $tanggl2]);
        session(['statusLanjut' => 'Ranap']);

        return view('bpjs.listpasien-ranap', [
            'daftarPasien'=>$daftarPasien,
            'penjamnin'=>$penjamnin,
            'tanggl1'=>$tanggl1,
            'tanggl2'=>$tanggl2,
        ]);
    }

    function cariListPaseinRanap(Request $request){
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
        $penjamnin = 'BPJ';

        $daftarPasien = DB::table('reg_periksa')
            ->select('reg_periksa.no_rkm_medis',
                    'reg_periksa.no_rawat',
                    'reg_periksa.status_bayar',
                    'kamar_inap.tgl_masuk',
                    'bridging_sep.no_sep',
                    'bridging_sep.jnspelayanan',
                    'pasien.nm_pasien',
                    'poliklinik.nm_poli')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->leftJoin('bridging_sep','bridging_sep.no_rawat','=','reg_periksa.no_rawat')
            ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
            ->leftJoin('kamar_inap','kamar_inap.no_rawat','=','reg_periksa.no_rawat')
            ->whereBetween('kamar_inap.tgl_keluar',[$tanggl1, $tanggl2])
            ->where('reg_periksa.status_lanjut','=','Ranap')
            ->where('reg_periksa.kd_pj','=', $penjamnin)
            ->get();

        // GET ALL BERKAS
        $daftarPasien->map(function ($item) {
            $item->getAllBerkas = DB::connection('db_con2')
                ->table('file_casemix')
                ->select('jenis_berkas', 'file')
                ->where('no_rawat', $item->no_rawat)
                ->get();
        });

        session(['tgl1' => $request->tgl1]);
        session(['tgl2' => $request->tgl2]);
        session(['statusLanjut' => 'Ranap']);

        return view('bpjs.listpasien-ranap', [
            'daftarPasien'=>$daftarPasien,
            'penjamnin'=>$penjamnin,
            'tanggl1'=>$tanggl1,
            'tanggl2'=>$tanggl2,
        ]);
    }
}

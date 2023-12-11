<?php

namespace App\Http\Controllers\AntrianPendaftaran;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AntrianPendaftaran extends Controller
{
    // LIST PENDAFTARAN
    // connection('db_con2')->
    function AntrianPendaftaran()  {
        $Pendaftaran = DB::connection('db_con2')->table('pendaftaran')
        ->select('kd_pendaftaran', 'nama_pendaftaran')
        ->get();

        return view('antrian.pendaftaran',[
            'Pendaftaran' => $Pendaftaran
        ]);
    }

    // LIST LOKET
        function AntrianLoket(Request $request) {
            $kdpendaftaran = $request->KdPendaftaran;

            $getLoket = DB::connection('db_con2')->table('loket')
                ->select('kd_loket', 'nama_loket', 'kd_pendaftaran')
                ->where('kd_pendaftaran','=', $kdpendaftaran)
                ->get();
                $getLoket->map(function ($item) {
                    $item->getDokter = DB::connection('db_con2')->table('list_dokter')
                        ->select('kd_dokter', 'nama_dokter')
                        ->where('kd_loket','=', $item->kd_loket)
                        ->get();
                        $item->getDokter->map(function ($item) {
                            $item->getPasien = DB::table('reg_periksa')
                            ->select('reg_periksa.no_reg', 'reg_periksa.no_rawat', 'pasien.nm_pasien', 'reg_periksa.kd_dokter')
                            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
                            ->where('reg_periksa.kd_dokter', '=', $item->kd_dokter)
                            ->where('reg_periksa.tgl_registrasi', date('Y-m-d'))
                            ->get();
                    });
                });
            return view('antrian.loket',[
                'getLoket'=>$getLoket,
            ]);
        }
}

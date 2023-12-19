<?php

namespace App\Http\Controllers\AntrianPendaftaran;

use Illuminate\Http\Request;
use App\Services\DayListService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AntrianPendaftaran extends Controller
{
    // LIST PENDAFTARAN
    function AntrianPendaftaran()  {
        $Pendaftaran = DB::table('pendaftaran')
            ->select('kd_pendaftaran', 'nama_pendaftaran')
            ->get();
            $Pendaftaran->map(function ($item){
                $item->getLoket = DB::table('loket')
                    ->select('kd_loket', 'nama_loket', 'kd_pendaftaran')
                    ->where('kd_pendaftaran','=', $item->kd_pendaftaran)
                    ->get();
            });
        return view('antrian.pendaftaran',[
            'Pendaftaran' => $Pendaftaran
        ]);
    }

    // DISPLAY ANTRIAN
    function DisplayAntrian() {
        return view('antrian.displayantrian');
    }

    // DISPLAY PETUGAS
    function DisplayPetugas() {
            return view('antrian.display-petugas');
    }

    // SETING ANTRIAN
    function SetingAntrian() {
        return view('antrian.setting-antrian');
    }
}

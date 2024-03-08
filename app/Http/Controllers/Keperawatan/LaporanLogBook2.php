<?php

namespace App\Http\Controllers\Keperawatan;

use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LaporanLogBook2 extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    public function getLookBook(Request $request) {
        $petugas = $this->cacheService->getPetugas();
        $kdPetugas = ($request->input('kdPetugas') == null) ? explode(',',session('auth')['id_user']) : explode(',', $request->input('kdPetugas'));
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;

        $getKegiatan = DB::connection('db_con2')->table('logbook_keperawatan')
            ->select('logbook_keperawatan.kd_kegiatan', 'logbook_keperawatan.user', DB::raw('COUNT(logbook_keperawatan.id_logbook) AS jumlah_id_logbook'))
            ->where('logbook_keperawatan.user', '22081999')
            ->whereBetween('logbook_keperawatan.tanggal', [$tanggl1, $tanggl2])
            ->groupBy('logbook_keperawatan.kd_kegiatan')
            ->get();
            $getKegiatan->map(function ($item) use ($tanggl1, $tanggl2) {
                $item->getPasien = DB::connection('db_con2')->table('logbook_keperawatan')
                    ->select('logbook_keperawatan.kd_kegiatan', 'logbook_keperawatan.no_rkm_medis', 'logbook_keperawatan.tanggal')
                    ->where('logbook_keperawatan.kd_kegiatan', $item->kd_kegiatan)
                    ->whereBetween('logbook_keperawatan.tanggal', [$tanggl1, $tanggl2])
                    ->get();
                    return $item;
            });



        return view('keperawatan.laporan-log-book2',[
            'petugas'=>$petugas,
            'getKegiatan' => $getKegiatan,
        ]);
    }
}

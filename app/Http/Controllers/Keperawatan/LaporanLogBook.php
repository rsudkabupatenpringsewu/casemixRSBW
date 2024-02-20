<?php

namespace App\Http\Controllers\Keperawatan;

use Illuminate\Http\Request;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LaporanLogBook extends Controller
{
    protected $cacheService;
    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }
    function getLookBook(Request $request) {
        $petugas = $this->cacheService->getPetugas();
        $kdPetugas = ($request->input('kdPetugas') == null) ? session('auth')['id_user'] : explode(',', $request->input('kdPetugas'));
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
        $getPasien = DB::connection('db_con2')->table('logbook_keperawatan')
            ->select('logbook_keperawatan.id_logbook', 'logbook_keperawatan.no_rkm_medis', 'logbook_keperawatan.tanggal')
            ->where('logbook_keperawatan.user', $kdPetugas)
            ->whereBetween('logbook_keperawatan.tanggal',[$tanggl1 , $tanggl2 ])
            ->groupBy('logbook_keperawatan.no_rkm_medis','logbook_keperawatan.tanggal')
            ->orderBy('logbook_keperawatan.tanggal','asc')
            ->get();
            $getPasien->map(function ($item) {
                $item->getLogPerawat = DB::connection('db_con2')->table('logbook_keperawatan')
                ->select('logbook_keperawatan.id_logbook', 'logbook_keperawatan.kd_kegiatan', 'rsbw_nm_kegiatan_keperawatan.nama_kegiatan', 'logbook_keperawatan.user', 'logbook_keperawatan.mandiri', 'logbook_keperawatan.supervisi')
                ->join('rsbw_nm_kegiatan_keperawatan','logbook_keperawatan.kd_kegiatan','=','rsbw_nm_kegiatan_keperawatan.kd_kegiatan')
                ->where('logbook_keperawatan.no_rkm_medis', $item->no_rkm_medis)
                ->where('logbook_keperawatan.tanggal', $item->tanggal)
                ->orderBy('logbook_keperawatan.kd_kegiatan','asc')
                ->get();
                return $item;
            });

        $getPetugas = DB::table('petugas')
            ->select('petugas.nip', 'petugas.nama')
            ->where('petugas.status', '=', '1')
            ->where('petugas.nip', $kdPetugas)
            ->first();

        return view('keperawatan.laporan-log-book',[
            'petugas'=>$petugas,
            'getPetugas'=>$getPetugas,
            'getPasien'=>$getPasien,
        ]);
    }
}

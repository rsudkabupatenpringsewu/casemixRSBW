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
        $kdPetugas = ($request->input('kdPetugas') == null) ? explode(',',session('auth')['id_user']) : explode(',', $request->input('kdPetugas'));
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;

        $getPetugas = DB::table('petugas')
            ->select('petugas.nip', 'petugas.nama')
            ->where('petugas.status', '=', '1')
            ->whereIn('petugas.nip', $kdPetugas)
            ->get();
            $getPetugas->map(function ($item) use ($tanggl1, $tanggl2) {
                $item->getPasien = DB::connection('db_con2')->table('logbook_keperawatan')
                    ->select('logbook_keperawatan.id_logbook', 'logbook_keperawatan.no_rkm_medis', 'logbook_keperawatan.tanggal')
                    ->where('logbook_keperawatan.user', $item->nip)
                    ->whereBetween('logbook_keperawatan.tanggal',[$tanggl1 , $tanggl2 ])
                    ->groupBy('logbook_keperawatan.no_rkm_medis','logbook_keperawatan.tanggal')
                    ->orderBy('logbook_keperawatan.tanggal','asc')
                    ->get();
                    $item->getPasien->map(function ($item) {
                         // Get Kegiatan Dasar
                        $item->getLogPerawat = DB::connection('db_con2')->table('logbook_keperawatan')
                        ->select('logbook_keperawatan.id_logbook', 'logbook_keperawatan.kd_kegiatan', 'rsbw_nm_kegiatan_keperawatan.nama_kegiatan', 'logbook_keperawatan.user', 'logbook_keperawatan.mandiri', 'logbook_keperawatan.supervisi')
                        ->join('rsbw_nm_kegiatan_keperawatan','logbook_keperawatan.kd_kegiatan','=','rsbw_nm_kegiatan_keperawatan.kd_kegiatan')
                        ->where('logbook_keperawatan.no_rkm_medis', $item->no_rkm_medis)
                        ->where('logbook_keperawatan.tanggal', $item->tanggal)
                        ->orderBy('logbook_keperawatan.kd_kegiatan','asc')
                        ->get();
                        // Get Kewenangan Khusus
                        $item->getKewenanganKhusus = DB::connection('db_con2')->table('logbook_keperawatan_kewenangankhusus')
                        ->select('logbook_keperawatan_kewenangankhusus.id_kewenangankhusus', 'logbook_keperawatan_kewenangankhusus.kd_kewenangan', 'rsbw_kewenangankhusus_keperawatan.nama_kewenangan' , 'logbook_keperawatan_kewenangankhusus.user', 'logbook_keperawatan_kewenangankhusus.mandiri', 'logbook_keperawatan_kewenangankhusus.supervisi', 'logbook_keperawatan_kewenangankhusus.tanggal')
                        ->join('rsbw_kewenangankhusus_keperawatan','logbook_keperawatan_kewenangankhusus.kd_kewenangan','=','rsbw_kewenangankhusus_keperawatan.kd_kewenangan')
                        ->where('logbook_keperawatan_kewenangankhusus.no_rkm_medis',$item->no_rkm_medis)
                        ->where('logbook_keperawatan_kewenangankhusus.tanggal',$item->tanggal)
                        ->orderBy('logbook_keperawatan_kewenangankhusus.kd_kewenangan','asc')
                        ->get();
                        return $item;
                    });
                $item->getKegiatanLain = DB::connection('db_con2')->table('logbook_keperawatan_kegiatanlain')
                    ->select('jenis_lookbook_kegiatan_lain.nama_kegiatan', 'logbook_keperawatan_kegiatanlain.judul', 'logbook_keperawatan_kegiatanlain.deskripsi', 'logbook_keperawatan_kegiatanlain.mandiri', 'logbook_keperawatan_kegiatanlain.supervisi', 'logbook_keperawatan_kegiatanlain.user', 'logbook_keperawatan_kegiatanlain.tanggal')
                    ->join('jenis_lookbook_kegiatan_lain','jenis_lookbook_kegiatan_lain.id_kegiatan','=','logbook_keperawatan_kegiatanlain.id_kegiatan')
                    ->where('logbook_keperawatan_kegiatanlain.user', $item->nip)
                    ->whereBetween('logbook_keperawatan_kegiatanlain.tanggal',[$tanggl1 , $tanggl2 ])
                    ->get();
                    return $item;
            });

        return view('keperawatan.laporan-log-book',[
            'petugas'=>$petugas,
            'getPetugas'=>$getPetugas,
        ]);
    }
}

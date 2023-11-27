<?php
// app/Services/CacheService.php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheService
{
    public function getPenjab()
    {
        $cacheKeyPenjab = 'cache_penjamin';
        if (Cache::has($cacheKeyPenjab)) {
            return Cache::get($cacheKeyPenjab);
        }
        $penjab = DB::table('penjab')
            ->select('penjab.kd_pj', 'penjab.png_jawab')
            ->where('penjab.status', '=', '1')
            ->get();
        Cache::put($cacheKeyPenjab, $penjab, 720);
        return $penjab;
    }

    public function getPetugas()
    {
        $cacheKeyPetugas = 'cache_petugas';
        if (Cache::has($cacheKeyPetugas)) {
            return Cache::get($cacheKeyPetugas);
        }
        $petugas = DB::table('petugas')
            ->select('petugas.nip', 'petugas.nama')
            ->where('petugas.status', '=', '1')
            ->get();
        Cache::put($cacheKeyPetugas, $petugas, 720);
        return $petugas;
    }
    public function getDokter()
    {
        $cacheKeyDokter = 'cache_dokter';
        if (Cache::has($cacheKeyDokter)) {
            $dokter = Cache::get($cacheKeyDokter);
        }
        $dokter = DB::table('dokter')
            ->select('dokter.kd_dokter', 'dokter.nm_dokter')
            ->where('dokter.status', '=', '1')
            ->get();
        Cache::put($cacheKeyDokter, $dokter, 720);
        return $dokter;
    }
}

<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PembayaranRalan extends Controller
{
    function PembayaranRanal() {
        $tanggl1 = date('Y-m-d');
        $tanggl2 = date('Y-m-d');

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
        // CORE QUERY
        $paymentRalan = DB::table('reg_periksa')
            ->select('reg_periksa.no_rawat',
                'reg_periksa.no_rkm_medis',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.status_bayar',
                'pasien.nm_pasien',
                'dokter.nm_dokter',
                'poliklinik.nm_poli')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->where('reg_periksa.status_lanjut', '=', 'Ralan')
            ->whereNotIn('reg_periksa.no_rawat', function ($query) {
                $query->select('piutang_pasien.no_rawat')->from('piutang_pasien');
            })
            ->where('reg_periksa.tgl_registrasi', $tanggl1)
            ->orderBy('reg_periksa.kd_dokter')
            ->orderBy('reg_periksa.tgl_registrasi')
            ->get();
            // NOMOR NOTA
            foreach ($paymentRalan as $nomornota) {
                $getNomorNota = DB::table('nota_jalan')
                    ->select('no_nota')
                    ->where('no_rawat', $nomornota->no_rawat)
                    ->get();
                    $nomornota->getNomorNota = $getNomorNota;
            }
            // REGISTRASI
            foreach ($paymentRalan as $registrasi) {
                $getRegistrasi = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $registrasi->no_rawat)
                    ->where('status','=','Registrasi')
                    ->get();
                    $registrasi->getRegistrasi = $getRegistrasi;
            }
            // Obat+Emb+Tsl / OBAT
            foreach ($paymentRalan as $obat) {
                $getObat = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $obat->no_rawat)
                    ->where('status','=','Obat')
                    ->get();
                    $obat->getObat = $getObat;
            }
            // RALAN DOKTER
            foreach ($paymentRalan as $ralandokter) {
                $getRalanDokter = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralandokter->no_rawat)
                    ->where('status','=','Ralan Dokter')
                    ->get();
                    $ralandokter->getRalanDokter = $getRalanDokter;
            }
            // RALAN PARAMEDIS
            foreach ($paymentRalan as $ralanparamedis) {
                $getRalanParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralanparamedis->no_rawat)
                    ->where('status','=','Ralan Paramedis')
                    ->get();
                    $ralanparamedis->getRalanParamedis = $getRalanParamedis;
            }
            // RALAN DOKTER PARAMEDIS
            foreach ($paymentRalan as $ralandokterparamedis) {
                $getRalanDrParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralandokterparamedis->no_rawat)
                    ->where('status','=','Ralan Dokter Paramedis')
                    ->get();
                    $ralandokterparamedis->getRalanDrParamedis = $getRalanDrParamedis;
            }
            // OPRASI
            foreach ($paymentRalan as $oprasi) {
                $getOprasi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $oprasi->no_rawat)
                    ->where('status','=','Operasi')
                    ->get();
                    $oprasi->getOprasi = $getOprasi;
            }
            // LABORAT
            foreach ($paymentRalan as $laborat) {
                $getLaborat = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $laborat->no_rawat)
                    ->where('status','=','Laborat')
                    ->get();
                    $laborat->getLaborat = $getLaborat;
            }
            // RADIOLOGI
            foreach ($paymentRalan as $radiologi) {
                $getRadiologi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $radiologi->no_rawat)
                    ->where('status','=','Radiologi')
                    ->get();
                    $radiologi->getRadiologi = $getRadiologi;
            }
            // TAMBAHAN
            foreach ($paymentRalan as $tambahan) {
                $getTambahan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $tambahan->no_rawat)
                    ->where('status','=','Tambahan')
                    ->get();
                    $tambahan->getTambahan = $getTambahan;
            }
            // POTONGAN
            foreach ($paymentRalan as $potongan) {
                $getPotongan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $potongan->no_rawat)
                    ->where('status','=','Potongan')
                    ->get();
                    $potongan->getPotongan = $getPotongan;
            }

        return view('laporan.pembayaranRalan', [
            'penjab'=> $penjab,
            'paymentRalan'=> $paymentRalan,
        ]);
    }

    // PENCARIAN
    function CariPembayaranRanal(Request $request) {
        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
        $kdPenjamin = explode(',', $request->input('kdPenjamin') ?? '');
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

        $penjamin = DB::table('penjab')
            ->select('penjab.kd_pj', 'penjab.png_jawab')
            ->where('penjab.status','=','1')
            ->whereIn('penjab.kd_pj', $kdPenjamin)
            ->get();
        $CaripaymentRalan = DB::table('reg_periksa')
            ->select('reg_periksa.no_rawat',
                'reg_periksa.no_rkm_medis',
                'reg_periksa.tgl_registrasi',
                'reg_periksa.status_bayar',
                'pasien.nm_pasien',
                'dokter.nm_dokter',
                'poliklinik.nm_poli')
            ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
            ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
            ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
            ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
            ->where('reg_periksa.status_lanjut', '=', 'Ralan')
            ->whereNotIn('reg_periksa.no_rawat', function ($query) {
                $query->select('piutang_pasien.no_rawat')->from('piutang_pasien');
            })
            ->whereBetween('reg_periksa.tgl_registrasi',[$tanggl1, $tanggl2])
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->orderBy('reg_periksa.kd_dokter')
            ->orderBy('reg_periksa.tgl_registrasi');
            if($request->input('kdPenjamin') == null){
                $paymentRalan = $CaripaymentRalan->get();
            }else{
                $paymentRalan = $CaripaymentRalan->whereIn('penjab.kd_pj', $kdPenjamin)->get();
            }
            // NOMOR NOTA
            foreach ($paymentRalan as $nomornota) {
                $getNomorNota = DB::table('nota_jalan')
                    ->select('no_nota')
                    ->where('no_rawat', $nomornota->no_rawat)
                    ->get();
                    $nomornota->getNomorNota = $getNomorNota;
            }
            // REGISTRASI
            foreach ($paymentRalan as $registrasi) {
                $getRegistrasi = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $registrasi->no_rawat)
                    ->where('status','=','Registrasi')
                    ->get();
                    $registrasi->getRegistrasi = $getRegistrasi;
            }
            // Obat+Emb+Tsl / OBAT
            foreach ($paymentRalan as $obat) {
                $getObat = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $obat->no_rawat)
                    ->where('status','=','Obat')
                    ->get();
                    $obat->getObat = $getObat;
            }
            // RALAN DOKTER
            foreach ($paymentRalan as $ralandokter) {
                $getRalanDokter = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralandokter->no_rawat)
                    ->where('status','=','Ralan Dokter')
                    ->get();
                    $ralandokter->getRalanDokter = $getRalanDokter;
            }
            // RALAN PARAMEDIS
            foreach ($paymentRalan as $ralanparamedis) {
                $getRalanParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralanparamedis->no_rawat)
                    ->where('status','=','Ralan Paramedis')
                    ->get();
                    $ralanparamedis->getRalanParamedis = $getRalanParamedis;
            }
            // RALAN DOKTER PARAMEDIS
            foreach ($paymentRalan as $ralandokterparamedis) {
                $getRalanDrParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralandokterparamedis->no_rawat)
                    ->where('status','=','Ralan Dokter Paramedis')
                    ->get();
                    $ralandokterparamedis->getRalanDrParamedis = $getRalanDrParamedis;
            }
            // OPRASI
            foreach ($paymentRalan as $oprasi) {
                $getOprasi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $oprasi->no_rawat)
                    ->where('status','=','Operasi')
                    ->get();
                    $oprasi->getOprasi = $getOprasi;
            }
            // LABORAT
            foreach ($paymentRalan as $laborat) {
                $getLaborat = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $laborat->no_rawat)
                    ->where('status','=','Laborat')
                    ->get();
                    $laborat->getLaborat = $getLaborat;
            }
            // RADIOLOGI
            foreach ($paymentRalan as $radiologi) {
                $getRadiologi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $radiologi->no_rawat)
                    ->where('status','=','Radiologi')
                    ->get();
                    $radiologi->getRadiologi = $getRadiologi;
            }
            // TAMBAHAN
            foreach ($paymentRalan as $tambahan) {
                $getTambahan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $tambahan->no_rawat)
                    ->where('status','=','Tambahan')
                    ->get();
                    $tambahan->getTambahan = $getTambahan;
            }
            // POTONGAN
            foreach ($paymentRalan as $potongan) {
                $getPotongan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $potongan->no_rawat)
                    ->where('status','=','Potongan')
                    ->get();
                    $potongan->getPotongan = $getPotongan;
            }

        return view('laporan.pembayaranRalan', [
            'penjab'=> $penjab,
            'penjamin'=> $penjamin,
            'paymentRalan'=>$paymentRalan,
        ]);

    }
}


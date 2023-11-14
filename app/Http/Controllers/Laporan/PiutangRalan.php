<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PiutangRalan extends Controller
{
    function PiutangRalan(){
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
        $piutangRalan = DB::table('reg_periksa')
            ->select('reg_periksa.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'reg_periksa.tgl_registrasi',
                'dokter.nm_dokter',
                'penjab.png_jawab',
                'piutang_pasien.uangmuka',
                'piutang_pasien.totalpiutang')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
            ->join('dokter','reg_periksa.kd_dokter','=','dokter.kd_dokter')
            ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
            ->join('piutang_pasien','piutang_pasien.no_rawat','=','reg_periksa.no_rawat')
            ->where('reg_periksa.status_lanjut','=','Ralan')
            ->whereBetween('reg_periksa.tgl_registrasi',[$tanggl1 , $tanggl2])
            ->orderBy('reg_periksa.tgl_registrasi','asc')
            ->get();
            // NOMOR NOTA
            foreach ($piutangRalan as $nomornota) {
                $getNomorNota = DB::table('nota_jalan')
                    ->select('no_nota')
                    ->where('no_rawat', $nomornota->no_rawat)
                    ->get();
                    $nomornota->getNomorNota = $getNomorNota;
            }
            // LABORAT
            foreach ($piutangRalan as $laborat) {
                $getLaborat = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $laborat->no_rawat)
                    ->where('status','=','Laborat')
                    ->get();
                    $laborat->getLaborat = $getLaborat;
            }
            // RADIOLOGI
            foreach ($piutangRalan as $radiologi) {
                $getRadiologi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $radiologi->no_rawat)
                    ->where('status','=','Radiologi')
                    ->get();
                    $radiologi->getRadiologi = $getRadiologi;
            }
            // Obat+Emb+Tsl / OBAT
            foreach ($piutangRalan as $obat) {
                $getObat = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $obat->no_rawat)
                    ->where('status','=','Obat')
                    ->get();
                    $obat->getObat = $getObat;
            }
            // RALAN DOKTER
            foreach ($piutangRalan as $ralandokter) {
                $getRalanDokter = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralandokter->no_rawat)
                    ->where('status','=','Ralan Dokter')
                    ->get();
                    $ralandokter->getRalanDokter = $getRalanDokter;
            }
            // RALAN DOKTER PARAMEDIS
            foreach ($piutangRalan as $ralandokterparamedis) {
                $getRalanDrParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralandokterparamedis->no_rawat)
                    ->where('status','=','Ralan Dokter Paramedis')
                    ->get();
                    $ralandokterparamedis->getRalanDrParamedis = $getRalanDrParamedis;
            }
            // RALAN PARAMEDIS
            foreach ($piutangRalan as $ralanparamedis) {
                $getRalanParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralanparamedis->no_rawat)
                    ->where('status','=','Ralan Paramedis')
                    ->get();
                    $ralanparamedis->getRalanParamedis = $getRalanParamedis;
            }
             // TAMBAHAN
             foreach ($piutangRalan as $tambahan) {
                $getTambahan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $tambahan->no_rawat)
                    ->where('status','=','Tambahan')
                    ->get();
                    $tambahan->getTambahan = $getTambahan;
            }
             // POTONGAN
             foreach ($piutangRalan as $potongan) {
                $getPotongan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $potongan->no_rawat)
                    ->where('status','=','Potongan')
                    ->get();
                    $potongan->getPotongan = $getPotongan;
            }
            // REGISTRASI
            foreach ($piutangRalan as $registrasi) {
                $getRegistrasi = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $registrasi->no_rawat)
                    ->where('status','=','Registrasi')
                    ->get();
                    $registrasi->getRegistrasi = $getRegistrasi;
            }
            // OPRASI
            foreach ($piutangRalan as $oprasi) {
                $getOprasi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $oprasi->no_rawat)
                    ->where('status','=','Operasi')
                    ->get();
                    $oprasi->getOprasi = $getOprasi;
            }
            // SUDAH DIBAYAR / DISKON / TIDAK TERBAYAR
            foreach ($piutangRalan as $sudahbayar) {
                $getSudahBayar = DB::table('bayar_piutang')
                    ->select('besar_cicilan', 'diskon_piutang', 'tidak_terbayar')
                    ->where('no_rawat', $sudahbayar->no_rawat)
                    ->get();
                    $sudahbayar->getSudahBayar = $getSudahBayar;
            }

        return view('laporan.piutangRalan',[
            'penjab'=> $penjab,
            'piutangRalan'=> $piutangRalan,
        ]);
    }
    function CariPiutangRalan(Request $request) {
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
        if ( $request->statusLunas == "Lunas") {
            $status = "Lunas";
        } elseif ( $request->statusLunas == "Belum Lunas") {
            $status = "Belum Lunas";
        }else{
            $status = "";
        }
        $CariPiutangRalan = DB::table('reg_periksa')
            ->select('reg_periksa.no_rawat',
                'reg_periksa.no_rkm_medis',
                'pasien.nm_pasien',
                'reg_periksa.tgl_registrasi',
                'dokter.nm_dokter',
                'penjab.png_jawab',
                'piutang_pasien.uangmuka',
                'piutang_pasien.totalpiutang')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->join('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
            ->join('dokter','reg_periksa.kd_dokter','=','dokter.kd_dokter')
            ->join('poliklinik','reg_periksa.kd_poli','=','poliklinik.kd_poli')
            ->join('piutang_pasien','piutang_pasien.no_rawat','=','reg_periksa.no_rawat')
            ->where('reg_periksa.status_lanjut','=','Ralan')
            ->whereBetween('reg_periksa.tgl_registrasi',[$tanggl1 , $tanggl2])
            ->where(function ($query) use ($status) {
                if ($status) {
                    $query->where('piutang_pasien.status', $status);
                }
            })
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->orderBy('reg_periksa.tgl_registrasi','asc');
            if($request->input('kdPenjamin') == null){
                $piutangRalan = $CariPiutangRalan->get();
            }else{
                $piutangRalan = $CariPiutangRalan->whereIn('penjab.kd_pj', $kdPenjamin)->get();
            }
            // NOMOR NOTA
            foreach ($piutangRalan as $nomornota) {
                $getNomorNota = DB::table('nota_jalan')
                    ->select('no_nota')
                    ->where('no_rawat', $nomornota->no_rawat)
                    ->get();
                    $nomornota->getNomorNota = $getNomorNota;
            }
            // LABORAT
            foreach ($piutangRalan as $laborat) {
                $getLaborat = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $laborat->no_rawat)
                    ->where('status','=','Laborat')
                    ->get();
                    $laborat->getLaborat = $getLaborat;
            }
            // RADIOLOGI
            foreach ($piutangRalan as $radiologi) {
                $getRadiologi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $radiologi->no_rawat)
                    ->where('status','=','Radiologi')
                    ->get();
                    $radiologi->getRadiologi = $getRadiologi;
            }
            // Obat+Emb+Tsl / OBAT
            foreach ($piutangRalan as $obat) {
                $getObat = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $obat->no_rawat)
                    ->where('status','=','Obat')
                    ->get();
                    $obat->getObat = $getObat;
            }
            // RALAN DOKTER
            foreach ($piutangRalan as $ralandokter) {
                $getRalanDokter = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralandokter->no_rawat)
                    ->where('status','=','Ralan Dokter')
                    ->get();
                    $ralandokter->getRalanDokter = $getRalanDokter;
            }
            // RALAN DOKTER PARAMEDIS
            foreach ($piutangRalan as $ralandokterparamedis) {
                $getRalanDrParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralandokterparamedis->no_rawat)
                    ->where('status','=','Ralan Dokter Paramedis')
                    ->get();
                    $ralandokterparamedis->getRalanDrParamedis = $getRalanDrParamedis;
            }
            // RALAN PARAMEDIS
            foreach ($piutangRalan as $ralanparamedis) {
                $getRalanParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $ralanparamedis->no_rawat)
                    ->where('status','=','Ralan Paramedis')
                    ->get();
                    $ralanparamedis->getRalanParamedis = $getRalanParamedis;
            }
            // TAMBAHAN
            foreach ($piutangRalan as $tambahan) {
                $getTambahan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $tambahan->no_rawat)
                    ->where('status','=','Tambahan')
                    ->get();
                    $tambahan->getTambahan = $getTambahan;
            }
            // POTONGAN
            foreach ($piutangRalan as $potongan) {
                $getPotongan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $potongan->no_rawat)
                    ->where('status','=','Potongan')
                    ->get();
                    $potongan->getPotongan = $getPotongan;
            }
            // REGISTRASI
            foreach ($piutangRalan as $registrasi) {
                $getRegistrasi = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $registrasi->no_rawat)
                    ->where('status','=','Registrasi')
                    ->get();
                    $registrasi->getRegistrasi = $getRegistrasi;
            }
            // OPRASI
            foreach ($piutangRalan as $oprasi) {
                $getOprasi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $oprasi->no_rawat)
                    ->where('status','=','Operasi')
                    ->get();
                    $oprasi->getOprasi = $getOprasi;
            }
            // SUDAH DIBAYAR / DISKON / TIDAK TERBAYAR
            foreach ($piutangRalan as $sudahbayar) {
                $getSudahBayar = DB::table('bayar_piutang')
                    ->select('besar_cicilan', 'diskon_piutang', 'tidak_terbayar')
                    ->where('no_rawat', $sudahbayar->no_rawat)
                    ->get();
                    $sudahbayar->getSudahBayar = $getSudahBayar;
            }

        return view('laporan.piutangRalan',[
            'penjab'=> $penjab,
            'piutangRalan'=> $piutangRalan,
        ]);

    }
}

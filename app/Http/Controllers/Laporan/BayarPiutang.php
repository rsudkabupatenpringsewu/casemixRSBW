<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class BayarPiutang extends Controller
{
    function CariBayarPiutang(Request $request) {
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
        $getBayarPiutang = DB::table('bayar_piutang')
        ->select('bayar_piutang.tgl_bayar',
            'bayar_piutang.no_rkm_medis',
            'pasien.nm_pasien',
            'bayar_piutang.besar_cicilan',
            'bayar_piutang.catatan',
            'bayar_piutang.no_rawat',
            'bayar_piutang.diskon_piutang',
            'bayar_piutang.tidak_terbayar',
            'reg_periksa.kd_pj',
            'penjab.png_jawab',
            'piutang_pasien.status',
            'piutang_pasien.uangmuka')
        ->join('pasien','bayar_piutang.no_rkm_medis','=','pasien.no_rkm_medis')
        ->leftJoin('reg_periksa','bayar_piutang.no_rawat','=','reg_periksa.no_rawat')
        ->leftJoin('penjab','reg_periksa.kd_pj','=','penjab.kd_pj')
        ->leftJoin('piutang_pasien','piutang_pasien.no_rawat','=','bayar_piutang.no_rawat')
        ->whereBetween('bayar_piutang.tgl_bayar', [$tanggl1 , $tanggl2])
        ->where(function ($query) use ($status) {
            if ($status) {
                $query->where('piutang_pasien.status', $status);
            }
        })
        ->orderBy('bayar_piutang.tgl_bayar','asc')
        ->orderBy('bayar_piutang.no_rkm_medis','asc');
        if($request->input('kdPenjamin') == null){
            $bayarPiutang = $getBayarPiutang->get();
        }else{
            $bayarPiutang = $getBayarPiutang->whereIn('reg_periksa.kd_pj', $kdPenjamin)->get();
        }

         // NOMOR NOTA
         foreach ($bayarPiutang as $nomornota) {
            $getNomorNota = DB::table('billing')
                ->select('nm_perawatan')
                ->where('no_rawat', $nomornota->no_rawat)
                ->where('no','=','No.Nota')
                ->get();
                $nomornota->getNomorNota = $getNomorNota;
        }
        // REGISTRASI
        foreach ($bayarPiutang as $registrasi) {
            $getRegistrasi = DB::table('billing')
                ->select('totalbiaya')
                ->where('no_rawat', $registrasi->no_rawat)
                ->where('status','=','Registrasi')
                ->get();
                $registrasi->getRegistrasi = $getRegistrasi;
        }
        // Obat+Emb+Tsl / OBAT
        foreach ($bayarPiutang as $obat) {
            $getObat = DB::table('billing')
                ->select('totalbiaya')
                ->where('no_rawat', $obat->no_rawat)
                ->where('status','=','Obat')
                ->get();
                $obat->getObat = $getObat;
        }
        // RALAN DOKTER / 1 Paket Tindakan
        foreach ($bayarPiutang as $ralandokter) {
            $getRalanDokter = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $ralandokter->no_rawat)
                ->where('status','=','Ralan Dokter')
                ->get();
                $ralandokter->getRalanDokter = $getRalanDokter;
        }
        // RALAN DOKTER PARAMEDIS / 2 Paket Tindakan
        foreach ($bayarPiutang as $ralandokterparamedis) {
            $getRalanDrParamedis = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $ralandokterparamedis->no_rawat)
                ->where('status','=','Ralan Dokter Paramedis')
                ->get();
                $ralandokterparamedis->getRalanDrParamedis = $getRalanDrParamedis;
        }
        // RALAN PARAMEDIS / 3 Paket Tindakan
        foreach ($bayarPiutang as $ralanparamedis) {
            $getRalanParamedis = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $ralanparamedis->no_rawat)
                ->where('status','=','Ralan Paramedis')
                ->get();
                $ralanparamedis->getRalanParamedis = $getRalanParamedis;
        }
        // RANAP DOKTER / 4 Paket Tindakan
        foreach ($bayarPiutang as $ranapdokter) {
            $getRanapDokter = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $ranapdokter->no_rawat)
                ->where('status','=','Ranap Dokter')
                ->get();
                $ranapdokter->getRanapDokter = $getRanapDokter;
        }
        // RANAP DOKTER PARAMEDIS / 5 Paket Tindakan
        foreach ($bayarPiutang as $ranapdrparamedis) {
            $getRanapDrParamedis = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $ranapdrparamedis->no_rawat)
                ->where('status','=','Ranap Dokter Paramedis')
                ->get();
                $ranapdrparamedis->getRanapDrParamedis = $getRanapDrParamedis;
        }
        // RANAP PARAMEDIS / 6 Ranap Paramedis
        foreach ($bayarPiutang as $ranapparamedis) {
            $getRanapParamedis = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $ranapparamedis->no_rawat)
                ->where('status','=','Ranap Paramedis')
                ->get();
                $ranapparamedis->getRanapParamedis = $getRanapParamedis;
        }
        // OPRASI
        foreach ($bayarPiutang as $oprasi) {
            $getOprasi = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $oprasi->no_rawat)
                ->where('status','=','Operasi')
                ->get();
                $oprasi->getOprasi = $getOprasi;
        }
        // LABORAT
        foreach ($bayarPiutang as $laborat) {
            $getLaborat = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $laborat->no_rawat)
                ->where('status','=','Laborat')
                ->get();
                $laborat->getLaborat = $getLaborat;
        }
        // RADIOLOGI
        foreach ($bayarPiutang as $radiologi) {
            $getRadiologi = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $radiologi->no_rawat)
                ->where('status','=','Radiologi')
                ->get();
                $radiologi->getRadiologi = $getRadiologi;
        }
        // TAMBAHAN
        foreach ($bayarPiutang as $tambahan) {
            $getTambahan = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $tambahan->no_rawat)
                ->where('status','=','Tambahan')
                ->get();
                $tambahan->getTambahan = $getTambahan;
        }
        // POTONGAN
        foreach ($bayarPiutang as $potongan) {
            $getPotongan = DB::table('billing')
                ->select('nm_perawatan', 'totalbiaya', 'status')
                ->where('no_rawat', $potongan->no_rawat)
                ->where('status','=','Potongan')
                ->get();
                $potongan->getPotongan = $getPotongan;
        }

        return view('laporan.bayarPiutang', [
            'penjab'=> $penjab,
            'bayarPiutang'=> $bayarPiutang,
        ]);
    }
}

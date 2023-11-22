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
            $piutangRalan->map(function ($item) {
                // NOMOR NOTA
                $item->getNomorNota = DB::table('nota_jalan')
                    ->select('no_nota')
                    ->where('no_rawat', $item->no_rawat)
                    ->get();
                // LABORAT
                $item->getLaborat = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Laborat')
                    ->get();
                // RADIOLOGI
                $item->getRadiologi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Radiologi')
                    ->get();
                // Obat+Emb+Tsl / OBAT
                $item->getObat = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Obat')
                    ->get();
                // RALAN DOKTER / 1 Paket Tindakan
                $item->getRalanDokter = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ralan Dokter')
                    ->get();
                // RALAN DOKTER PARAMEDIS / 2 Paket Tindakan
                $item->getRalanDrParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ralan Dokter Paramedis')
                    ->get();
                // RALAN PARAMEDIS / 3 Paket Tindakan
                $item->getRalanParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ralan Paramedis')
                    ->get();
                // TAMBAHAN
                $item->getTambahan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Tambahan')
                    ->get();
                // POTONGAN
                $item->getPotongan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Potongan')
                    ->get();
                // REGISTRASI
                $item->getRegistrasi = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Registrasi')
                    ->get();
                // OPERASI
                $item->getOprasi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Operasi')
                    ->get();
                // SUDAH DIBAYAR / DISKON / TIDAK TERBAYAR
                $item->getSudahBayar = DB::table('bayar_piutang')
                    ->select('besar_cicilan', 'diskon_piutang', 'tidak_terbayar')
                    ->where('no_rawat', $item->no_rawat)
                    ->get();
            });


        return view('laporan.piutangRalan',[
            'penjab'=> $penjab,
            'piutangRalan'=> $piutangRalan,
        ]);
    }
    function CariPiutangRalan(Request $request) {
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

        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;

        $status = ($request->statusLunas == "Lunas") ? "Lunas" : (($request->statusLunas == "Belum Lunas") ? "Belum Lunas" : "");
        $kdPenjamin = ($request->input('kdPenjamin') == null) ? "" : explode(',', $request->input('kdPenjamin'));

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
            ->where(function ($query) use ($status) {
                if ($status) {
                    $query->where('piutang_pasien.status', $status);
                }
            })
            ->where(function ($query) use ($kdPenjamin) {
                if ($kdPenjamin) {
                    $query->whereIn('penjab.kd_pj', $kdPenjamin);
                }
            })
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $cariNomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $cariNomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $cariNomor . '%');
            })
            ->orderBy('reg_periksa.tgl_registrasi','asc')
            ->get();
            $piutangRalan->map(function ($item) {
                // NOMOR NOTA
                $item->getNomorNota = DB::table('nota_jalan')
                    ->select('no_nota')
                    ->where('no_rawat', $item->no_rawat)
                    ->get();
                // LABORAT
                $item->getLaborat = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Laborat')
                    ->get();
                // RADIOLOGI
                $item->getRadiologi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Radiologi')
                    ->get();

                // Obat+Emb+Tsl / OBAT
                $item->getObat = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Obat')
                    ->get();
                // RALAN DOKTER / 1 Paket Tindakan
                $item->getRalanDokter = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ralan Dokter')
                    ->get();
                // RALAN DOKTER PARAMEDIS / 2 Paket Tindakan
                $item->getRalanDrParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ralan Dokter Paramedis')
                    ->get();
                // RALAN PARAMEDIS / 3  Paket Tindakan
                $item->getRalanParamedis = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ralan Paramedis')
                    ->get();
                // TAMBAHAN
                $item->getTambahan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Tambahan')
                    ->get();
                // POTONGAN
                $item->getPotongan = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Potongan')
                    ->get();
                // REGISTRASI
                $item->getRegistrasi = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Registrasi')
                    ->get();
                // OPERASI
                $item->getOprasi = DB::table('billing')
                    ->select('nm_perawatan', 'totalbiaya', 'status')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Operasi')
                    ->get();
                // SUDAH DIBAYAR / DISKON / TIDAK TERBAYAR
                $item->getSudahBayar = DB::table('bayar_piutang')
                    ->select('besar_cicilan', 'diskon_piutang', 'tidak_terbayar')
                    ->where('no_rawat', $item->no_rawat)
                    ->get();
            });

        return view('laporan.piutangRalan',[
            'penjab'=> $penjab,
            'piutangRalan'=> $piutangRalan,
        ]);

    }
}

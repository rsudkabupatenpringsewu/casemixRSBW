<?php

namespace App\Http\Controllers\Laporan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class BayarPiutang extends Controller
{
    function CariBayarPiutang(Request $request) {
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
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
        $kdPenjamin = explode(',', $request->input('kdPenjamin') ?? '');

        $status = ($request->statusLunas == "Lunas") ? "Lunas" : (($request->statusLunas == "Belum Lunas") ? "Belum Lunas" : "");
        $kdPenjamin = ($request->input('kdPenjamin') == null) ? "" : explode(',', $request->input('kdPenjamin'));

        $bayarPiutang = DB::table('bayar_piutang')
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
            ->where(function ($query) use ($kdPenjamin) {
                if ($kdPenjamin) {
                    $query->whereIn('penjab.kd_pj', $kdPenjamin);
                }
            })
            ->orderBy('bayar_piutang.tgl_bayar','asc')
            ->orderBy('bayar_piutang.no_rkm_medis','asc')
            ->get();
            $bayarPiutang->map(function ($item) {
                // NOMOR NOTA
                $item->getNomorNota = DB::table('billing')
                    ->select('nm_perawatan')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('no', '=', 'No.Nota')
                    ->get();
                // REGISTRASI
                $item->getRegistrasi = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Registrasi')
                    ->get();
                // Obat+Emb+Tsl / OBAT
                $item->getObat = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Obat')
                    ->get();
                // RALAN DOKTER / 1 Paket Tindakan
                $item->getRalanDokter = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ralan Dokter')
                    ->get();
                // RALAN DOKTER PARAMEDIS / 2 Paket Tindakan
                $item->getRalanDrParamedis = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ralan Dokter Paramedis')
                    ->get();
                // RALAN PARAMEDIS / 3 Paket Tindakan
                $item->getRalanParamedis = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ralan Paramedis')
                    ->get();
                // RANAP DOKTER / 4 Paket Tindakan
                $item->getRanapDokter = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ranap Dokter')
                    ->get();
                // RANAP DOKTER PARAMEDIS / 5 Paket Tindakan
                $item->getRanapDrParamedis = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ranap Dokter Paramedis')
                    ->get();
                // RANAP PARAMEDIS / 6 Ranap Paramedis
                $item->getRanapParamedis = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Ranap Paramedis')
                    ->get();
                // OPRASI
                $item->getOprasi = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Operasi')
                    ->get();
                // LABORAT
                $item->getLaborat = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Laborat')
                    ->get();
                // RADIOLOGI
                $item->getRadiologi = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Radiologi')
                    ->get();
                // TAMBAHAN
                $item->getTambahan = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Tambahan')
                    ->get();
                // POTONGAN
                $item->getPotongan = DB::table('billing')
                    ->select('totalbiaya')
                    ->where('no_rawat', $item->no_rawat)
                    ->where('status', '=', 'Potongan')
                    ->get();
                return $item;
            });


        return view('laporan.bayarPiutang', [
            'penjab'=> $penjab,
            'bayarPiutang'=> $bayarPiutang,
        ]);
    }
}

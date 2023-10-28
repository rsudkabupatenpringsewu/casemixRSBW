<?php

namespace App\Http\Controllers\Test;

use setasign\Fpdi\Fpdi;
use Spatie\PdfToImage\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
// TEST DR AAN
function Test(){
    $tanggl1 = date('Y-m-d');
    $tanggl2 = date('Y-m-d');
    $penjab = DB::table('penjab')
        ->select('penjab.kd_pj', 'penjab.png_jawab')
        ->where('penjab.status','=','1')
        ->get();
    $penjamin = '';
    // CORE QUERY
    $paymentRalan = DB::table('reg_periksa')
        ->select('reg_periksa.no_rawat', 'reg_periksa.no_rkm_medis', 'pasien.nm_pasien', 'reg_periksa.tgl_registrasi', 'dokter.nm_dokter', 'poliklinik.nm_poli')
        ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
        ->join('poliklinik', 'reg_periksa.kd_poli', '=', 'poliklinik.kd_poli')
        ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
        ->join('penjab', 'reg_periksa.kd_pj', '=', 'penjab.kd_pj')
        ->where('reg_periksa.status_lanjut', '=', 'Ralan')
        ->whereNotIn('reg_periksa.no_rawat', function ($query) {
            $query->select('piutang_pasien.no_rawat')->from('piutang_pasien');
        })
        ->where('reg_periksa.tgl_registrasi', '=', '2023-10-26')
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

    return view('test.test', [
        'penjab'=> $penjab,
        'penjamin'=> $penjamin,
        'paymentRalan'=>$paymentRalan,
    ]);
}


function TestCari(Request $request){
    $cariNomor = $request->cariNomor;
    $tanggl1 = $request->tgl1;
    $tanggl2 = $request->tgl2;
    $kdPenjamin = explode(',', $request->input('kdPenjamin') ?? '');

    $penjab = DB::table('penjab')
        ->select('penjab.kd_pj', 'penjab.png_jawab')
        ->where('penjab.status','=','1')
        ->get();
    $penjamin = DB::table('penjab')
        ->select('penjab.kd_pj', 'penjab.png_jawab')
        ->where('penjab.status','=','1')
        ->whereIn('penjab.kd_pj', $kdPenjamin)
        ->get();
    return view('test.test', [
        'penjab'=> $penjab,
        'penjamin'=> $penjamin,
    ]);
}

}

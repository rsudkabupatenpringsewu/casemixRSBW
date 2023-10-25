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
    return view('test.test', [
        'penjab'=> $penjab,
        'penjamin'=> $penjamin,
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

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
    $test = DB::table('reg_periksa')
    ->select('reg_periksa.no_reg', 'reg_periksa.no_rawat', 'reg_periksa.tgl_registrasi', 'reg_periksa.jam_reg')
    ->where('reg_periksa.tgl_registrasi','=','2023-11-22')
    ->get();

    return view('test.test', [
        'test'=>$test
    ]);
}

function TestCari(Request $request){
    $cariNomor = $request->cariNomor;
    $tanggl1 = $request->tgl1;
    $tanggl2 = $request->tgl2;
}

}

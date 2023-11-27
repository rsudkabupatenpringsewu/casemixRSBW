<?php

namespace App\Http\Controllers\Test;

use setasign\Fpdi\Fpdi;
use Spatie\PdfToImage\Pdf;
use Illuminate\Http\Request;
use App\Services\TestService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{

    protected $testService;
    public function __construct(TestService $testService)
    {
        $this->test = $testService;
    }
function Test(){
    $tanggl1 = date('Y-m-d');
    $tanggl2 = date('Y-m-d');

    $value = DB::table('penjab')
    ->select('penjab.kd_pj', 'penjab.png_jawab')
    ->where('penjab.status', '=', '1')
    ->get();
    $test = $this->test->Test($value);


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

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

    function Test(){

       $result = DB::connection('db_con2')
       ->table('file_casemix')
       ->select('file_casemix.id', 'file_casemix.no_rkm_medis', 'file_casemix.no_rawat', 'file_casemix.nama_pasein', 'file_casemix.jenis_berkas', 'file_casemix.file')
       ->paginate(500);
        return view('test.test', [
            'result' => $result,
        ]);
    }

    function TestDelete(Request $request) {
        DB::connection('db_con2')
        ->table('file_casemix')
        ->where('no_rawat', $yourNoRawatValue) // Replace $yourNoRawatValue with the actual value you want to match
        ->delete();

    }


    function TestCari(Request $request){
        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
    }

}

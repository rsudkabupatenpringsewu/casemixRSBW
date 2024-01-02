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
        // $tanggl1 = date('Y-m-d');
        // $tanggl2 = date('Y-m-d');
        // $getSeting = DB::table('setting')
        //     ->select('setting.nama_instansi', 'setting.alamat_instansi', 'setting.kabupaten', 'setting.propinsi', 'setting.kontak', 'setting.email', 'setting.aktifkan', 'setting.kode_ppk', 'setting.kode_ppkinhealth', 'setting.kode_ppkkemenkes', 'setting.wallpaper', 'setting.logo')
        //     ->get();

        return view('test.test');
    }

    function TestCari(Request $request){
        $cariNomor = $request->cariNomor;
        $tanggl1 = $request->tgl1;
        $tanggl2 = $request->tgl2;
    }

}

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
        $data = [
        ['id' =>	'', 'no_rkm_medis' =>	'362359'	, 'no_rawat' => '	2023/12/31/000008	', 'nama_pasein' => '	YULIAN SARI	', 'jenis_berkas' => '	HASIL	', 'file' => '	HASIL-20231231000008.pdf	'],
        ['id' =>	''	, 'no_rawat' => '	2023/12/31/000036	', 'nama_pasein' => '	RINAWATI	', 'jenis_berkas' => '	HASIL	', 'file' => '	HASIL-20231231000036.pdf	'],

        ];

        foreach ($data as $entry) {
            $existingEntry = DB::table('file_casemix')
            ->where('no_rawat', $entry['no_rawat'])
            ->where('jenis_berkas', $entry['jenis_berkas'])
            ->first();

            if (!$existingEntry) {
                DB::table('file_casemix')->insert($entry);
                echo "Data inserted for ID: " . $entry['no_rawat'] . "<br/>";
            } else {
                echo "Data already exists for ID: " . $entry['no_rawat'] . "<br/>";
            }
        }
    }

    function TestDelete(Request $request) {

    }
}

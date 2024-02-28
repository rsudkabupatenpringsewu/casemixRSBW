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
    function TestDelete(Request $request) {
        //   $data = [
            //     // ['kode_brng'=>'GU000003240', 'kd_bangsal' => 'DepRJ', 'stok_minimal_medis' =>750],
            //     // ['kode_brng'=>'B000007050', 'kd_bangsal' => 'DepRJ', 'stok_minimal_medis' =>720],
            // ];
            // foreach ($data as $row) {
            //     DB::table('stok_minimal_medis')->insert($row);
        // }
    }

    function Test(){
        // $getPenyakit = DB::table('diagnosa_pasien')
        //     ->select('penyakit.nm_penyakit',
        //             'diagnosa_pasien.kd_penyakit',
        //             DB::raw('COUNT(diagnosa_pasien.kd_penyakit) AS Jumlah'
        //     ))
        //     ->join('penyakit', 'diagnosa_pasien.kd_penyakit', '=', 'penyakit.kd_penyakit')
        //     ->join('reg_periksa', 'diagnosa_pasien.no_rawat', '=', 'reg_periksa.no_rawat')
        //     ->where('diagnosa_pasien.prioritas', '=', '1')
        //     ->where('reg_periksa.status_lanjut', '=', 'ranap')
        //     ->whereBetween('reg_periksa.tgl_registrasi',['2024-01-01','2024-02-06'])
        //     ->groupBy('diagnosa_pasien.kd_penyakit')
        //     ->orderBy('Jumlah', 'DESC')
        //     ->take(10)
        //     ->get();
        //     $getPenyakit->map(function ($item) {
        //         $item->getDokter = DB::table('reg_periksa')
        //         ->select('dokter.nm_dokter','reg_periksa.kd_dokter',  'penyakit.nm_penyakit', 'diagnosa_pasien.kd_penyakit', DB::raw('COUNT(reg_periksa.kd_dokter) AS Jumlah_yang_menangani_penyakit'))
        //         ->join('diagnosa_pasien', 'diagnosa_pasien.no_rawat', '=', 'reg_periksa.no_rawat')
        //         ->join('penyakit', 'diagnosa_pasien.kd_penyakit', '=', 'penyakit.kd_penyakit')
        //         ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
        //         ->where('diagnosa_pasien.kd_penyakit', $item->kd_penyakit)
        //         ->where('reg_periksa.status_lanjut', '=', 'ranap')
        //         ->where('diagnosa_pasien.prioritas', '=', '1')
        //         ->whereBetween('reg_periksa.tgl_registrasi',['2024-01-01','2024-02-06'])
        //         ->groupBy('reg_periksa.kd_dokter')
        //         ->orderBy('Jumlah_yang_menangani_penyakit', 'DESC')
        //         // ->take(5)
        //         ->get();
        //         return $item;
        //     });

        // return view('test.test', ['getPenyakit' => $getPenyakit]);

        $consid = '26519'; // Ganti dengan nilai cons-id Anda
        $secretKey = '3kB2D07001'; // Ganti dengan nilai secret key Anda
        $userKey = '5e51bb79a4c6abcacde7ab1c48362adc'; // Ganti dengan nilai user key Anda

        $tStamp = strval(time());

        $signature = hash_hmac('sha256', $consid . "&" . $tStamp, $secretKey, true);

        $encodedSignature = base64_encode($signature);

            $parameter1 = date("Y-m-d"); // Jika tidak ada parameter, gunakan tanggal saat ini

        $api_url = 'https://apijkn.bpjs-kesehatan.go.id/antreanrs/antrean/pendaftaran/tanggal/' . $parameter1;

        // Melakukan HTTP GET request menggunakan HTTP Client dari Laravel
        $response = Http::withHeaders([
            'X-cons-id' => $consid,
            'X-timestamp' => $tStamp,
            'X-signature' => $encodedSignature,
            'user_key' => $userKey,
            'Content-Type' => 'application/json;charset=utf-8'
        ])->get($api_url);

       // Mengembalikan hasil dalam bentuk JSON
        $encryptedData = $response->json();
        $decryptedData = $this->decryptResponse($encryptedData, $consid.$secretKey.$tStamp);

        return $this->decompressFromEncodedURIComponent($decryptedData);
    }

    private function decryptResponse($encryptedData, $encryptionKey)
    {
        // Lakukan dekripsi pada setiap nilai string dalam array
        array_walk_recursive($encryptedData, function (&$value) use ($encryptionKey) {
            $value = $this->stringDecrypt($encryptionKey, $value);
        });

        return $encryptedData;
    }

    private function stringDecrypt($key, $string)
    {
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);
        return $output;
    }

    private function decompressFromEncodedURIComponent($input){
        if ($input === null) {
            return "";
        }
        if ($input === "") {
            return null;
        }

        $input = str_replace(' ', "+", $input);

        return self::_decompress(
            $input,
            32,
            function($data) {
                $sub = substr($data->str, $data->index, 6);
                $sub = LZUtil::utf8_charAt($sub, 0);
                $data->index += strlen($sub);
                $data->end = strlen($sub) <= 0;
                return LZUtil::getBaseValue(LZUtil::$keyStrUriSafe, $sub);
            }
        );
    }


}

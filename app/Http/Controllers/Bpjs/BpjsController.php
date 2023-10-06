<?php

namespace App\Http\Controllers\Bpjs;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

class BpjsController extends Controller
{
    function claimBpjs(Request $request) {
        $cariNoSep = $request->cariNoSep;
        $cariNorawat = $request->cariNorawat;
        $pasien = DB::table('reg_periksa')
        ->join('pasien', 'pasien.no_rkm_medis', '=', 'reg_periksa.no_rkm_medis')
        ->join('penjab', 'penjab.kd_pj', '=', 'reg_periksa.kd_pj')
        ->leftJoin('bridging_sep','bridging_sep.no_rawat','=','reg_periksa.no_rawat')
        ->where('bridging_sep.no_sep', '=', $cariNoSep)
        ->where('reg_periksa.no_rawat', '=', $cariNorawat)
        ->select('pasien.no_rkm_medis', 'pasien.nm_pasien', 'bridging_sep.no_sep', 'reg_periksa.no_rawat', 'penjab.png_jawab');
        $getPasien = $pasien->first();

        return view('bpjs.ulploadFileClaim', [
            'getPasien'=>$getPasien,
        ]);
    }

    // UPLOAD FILE
    function inputClaimBpjs(Request $request){
        // Berkas INACBG
        if ($request->hasFile('file_inacbg')) {
            $file = $request->file('file_inacbg');
            $no_rawatSTR = str_replace('/', '', $request->no_rawat);
            $path_file = 'INACBG' . '-' . $no_rawatSTR. '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('file_inacbg/' . $path_file, file_get_contents($file));
            $cekBerkas = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $request->no_rawat)
                ->where('jenis_berkas', 'INACBG')
                ->exists();
            if (!$cekBerkas){
                DB::connection('db_con2')->table('file_casemix')->insert([
                    'no_rkm_medis' => $request->no_rkm_medis,
                    'no_rawat' => $request->no_rawat,
                    'nama_pasein' => $request->nama_pasein,
                    'jenis_berkas' => 'INACBG',
                    'file' => $path_file,
                ]);
            }
        }

        // Berkas INACBG
        if ($request->hasFile('file_scan')) {
            $file = $request->file('file_scan');
            $no_rawatSTR = str_replace('/', '', $request->no_rawat);
            $path_file = 'SCAN' . '-' . $no_rawatSTR. '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('file_scan/' . $path_file, file_get_contents($file));
            $cekBerkas = DB::connection('db_con2')->table('file_casemix')->where('no_rawat', $request->no_rawat)
                ->where('jenis_berkas', 'SCAN')
                ->exists();
            if (!$cekBerkas){
                DB::connection('db_con2')->table('file_casemix')->insert([
                    'no_rkm_medis' => $request->no_rkm_medis,
                    'no_rawat' => $request->no_rawat,
                    'nama_pasein' => $request->nama_pasein,
                    'jenis_berkas' => 'SCAN',
                    'file' => $path_file,
                ]);
            }
        }

        $redirectUrl = url('/casemix-home-cari');
        $csrfToken = Session::token();
        $cariNoSep = $request->no_sep;
        $cariNoRawat = $request->no_rawat;
        $redirectUrlWithToken = $redirectUrl . '?' . http_build_query(['_token' => $csrfToken, 'cariNorawat' => $cariNoSep, 'cariNorawat' => $cariNoRawat,]);
        return redirect($redirectUrlWithToken);
    }
}

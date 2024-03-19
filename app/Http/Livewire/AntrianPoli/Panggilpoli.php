<?php

namespace App\Http\Livewire\AntrianPoli;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Services\DayListService;
use Illuminate\Support\Facades\DB;

class Panggilpoli extends Component
{
    public $kd_ruang_poli;
    public function mount(Request $request)
    {
        $this->kd_ruang_poli = $request->kd_ruang_poli;
        $this->getPasien();
    }
    public function render()
    {
        $this->getPasien();
        return view('livewire.antrian-poli.panggilpoli');
    }
    public $getPasien;
    public function getPasien(){
        $dayList = DayListService::getDayList();
        $hari = $dayList[date('l')];
        $this->getPasien = DB::table('reg_periksa')
        ->select('reg_periksa.no_reg',
            'reg_periksa.no_rawat',
            'reg_periksa.no_rkm_medis',
            'reg_periksa.kd_dokter',
            'reg_periksa.kd_pj',
            'jadwal.hari_kerja',
            'jadwal.jam_mulai',
            'bw_ruangpoli_dokter.kd_ruang_poli',
            'bw_ruangpoli_dokter.nama_dokter',
            'pasien.nm_pasien',
            'bw_log_antrian_poli.status'
            )
        ->leftJoin('bw_log_antrian_poli','bw_log_antrian_poli.no_rawat','=','reg_periksa.no_rawat')
        ->join('bw_ruangpoli_dokter','reg_periksa.kd_dokter','=','bw_ruangpoli_dokter.kd_dokter')
        ->join('jadwal','bw_ruangpoli_dokter.kd_dokter','=','jadwal.kd_dokter')
        ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
        ->where('reg_periksa.tgl_registrasi', date('Y-m-d'))
        ->where('jadwal.hari_kerja', $hari)
        ->where('bw_ruangpoli_dokter.kd_ruang_poli', $this->kd_ruang_poli)
        ->orderBy('jadwal.jam_mulai','asc')
        ->orderBy('reg_periksa.no_reg','asc')
        ->orderBy('reg_periksa.jam_reg','asc')
        ->get();
    }
}

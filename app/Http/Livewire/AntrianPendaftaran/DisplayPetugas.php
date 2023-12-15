<?php

namespace App\Http\Livewire\AntrianPendaftaran;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Services\DayListService;
use Illuminate\Support\Facades\DB;

class DisplayPetugas extends Component
{
    public function mount(Request $request)
    {
        $this->kdLoket = $request->kdLoket;
        $this->getPasien();
    }

    public function render()
    {
        $this->getPasien();
        return view('livewire.antrian-pendaftaran.display-petugas');
    }

    private function getPasien() {
        $dayList = DayListService::getDayList();
        $hari = $dayList[date('l')];
        $this->getPasien = DB::table('reg_periksa')
            ->select('pasien.nm_pasien',
                'reg_periksa.no_rawat',
                'reg_periksa.no_rkm_medis',
                'reg_periksa.no_reg',
                'jadwal.jam_mulai',
                'jadwal.hari_kerja',
                'reg_periksa.kd_dokter',
                'list_dokter.nama_dokter',
                'log_antrian_loket.status')
            ->join('list_dokter','reg_periksa.kd_dokter','=','list_dokter.kd_dokter')
            ->join('loket','list_dokter.kd_loket','=','loket.kd_loket')
            ->join('jadwal','list_dokter.kd_dokter','=','jadwal.kd_dokter')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->leftJoin('log_antrian_loket','log_antrian_loket.no_rawat','=','reg_periksa.no_rawat')
            ->where('reg_periksa.tgl_registrasi', date('Y-m-d'))
            ->where('loket.kd_loket', $this->kdLoket)
            ->where('jadwal.hari_kerja', $hari)
            ->where('reg_periksa.kd_pj','=','BPJ')
            ->orderBy('jadwal.jam_mulai','asc')
            ->orderBy('reg_periksa.no_reg','asc')
            ->orderBy('reg_periksa.jam_reg','asc')
            ->get();
    }

    public function handleLog($kd_dokter, $no_rawat, $kdLoket, $type)
    {
        $status = ($type == 'ada') ? '0' : '1';
        DB::table('log_antrian_loket')->updateOrInsert(
            ['no_rawat' => $no_rawat],
            ['kd_loket' => $kdLoket, 'status' => $status]
        );
    }

}

<?php

namespace App\Http\Livewire\AntrianPoli;

use Livewire\Component;
use Illuminate\Http\Request;
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
        $this->getPasien = DB::table('bw_ruangpoli_dokter')
        ->select('bw_ruangpoli_dokter.kd_dokter', 'bw_ruangpoli_dokter.nama_dokter', 'bw_ruangpoli_dokter.kd_ruang_poli')
        ->where('bw_ruangpoli_dokter.kd_ruang_poli', $this->kd_ruang_poli)
        ->get();
    }
}

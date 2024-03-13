<?php

namespace App\Http\Livewire\AntrianPoli;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Services\DayListService;
use Illuminate\Support\Facades\DB;

class Displaypoli extends Component
{
    public $kd_display;
    public function mount(Request $request)
    {
        $this->kd_display = $request->kd_display;
        $this->getDisplay();
    }
    public function render()
    {
        $this->getDisplay();
        return view('livewire.antrian-poli.displaypoli');
    }
    public $getPoli;
    public $getPasien;
    // KIRI = 0
    // KANAN = 1
    public function getDisplay() {
        $dayList = DayListService::getDayList();
        $hari = $dayList[date('l')];
        $this->getPoli = DB::table('bw_ruang_poli')
            ->select('bw_ruang_poli.kd_ruang_poli',
                'bw_ruang_poli.nama_ruang_poli',
                'bw_ruang_poli.kd_display',
                'bw_ruang_poli.posisi_display_poli')
                ->where('bw_ruang_poli.kd_display', $this->kd_display)
                ->orderBy('bw_ruang_poli.posisi_display_poli','asc')
                ->get();
                $this->getPoli->map(function ($item) use ($hari) {
                    $item->getPasien = DB::table('bw_ruangpoli_dokter')
                    ->select('bw_ruangpoli_dokter.kd_dokter', 'bw_ruangpoli_dokter.nama_dokter', 'bw_ruangpoli_dokter.kd_ruang_poli')
                    ->where('bw_ruangpoli_dokter.kd_ruang_poli', $item->kd_ruang_poli)
                    ->get();
                });
    }
}

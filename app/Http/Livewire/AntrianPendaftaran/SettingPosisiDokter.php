<?php

namespace App\Http\Livewire\AntrianPendaftaran;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class SettingPosisiDokter extends Component
{
    public $getListDokter;
    public $getLoket;
    protected $listeners = ['mout'];  // Menerima Triger Dari SettingAntrianLoket

    public function mout() {
        $this->getListDokter();
        $this->getLoket();
    }
    public function render() {
        $this->getListDokter();
        $this->getLoket();
        return view('livewire.antrian-pendaftaran.setting-posisi-dokter');
    }
    private function getLoket() {
        $this->getLoket = DB::table('loket')
            ->select('loket.kd_loket', 'loket.nama_loket')
            ->get();
    }

    // GET LIST DOKTER
    private function getListDokter() {
        $this->getListDokter = DB::table('dokter')
            ->select('dokter.kd_dokter', 'dokter.nm_dokter', 'list_dokter.kd_loket')
            ->leftJoin('list_dokter','dokter.kd_dokter','=','list_dokter.kd_dokter')
            ->where('dokter.status','=','1')
            ->orderBy('dokter.kd_dokter','ASC')
            ->get();
    }

    // EDIT LOKET DOKTER
    public $confirmingEdit = false;
    public $selectedKdDokter;
    public $selectedNmDokter;
    public $selectedKdLoket;
    public function editLoketConfirm($kd_dokter, $nm_dokter, $kd_loket) {
        $this->confirmingEdit = true;
        $this->selectedKdDokter = $kd_dokter;
        $this->selectedNmDokter = $nm_dokter;
        $this->selectedKdLoket = $kd_loket;
    }
    public function editLoket() {
        try {
            DB::table('list_dokter')->updateOrInsert(
                ['kd_dokter' => $this->selectedKdDokter],
                ['nama_dokter' => $this->selectedNmDokter],
                ['kd_loket' => $this->selectedKdLoket]
            );
            $this->flashMessage('Posisi Dokter Dipindahkan Ke '.$this->selectedKdLoket, 'success', 'check');
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menghapus pendaftaran.', 'danger', 'ban');
        }
        $this->confirmingEdit = false;
    }
    public function cancelEdit() {
        $this->confirmingEdit = false;
    }

    // ALERT
    private function flashMessage($message, $color, $icon){
        Session::flash('message', $message);
        Session::flash('color', $color);
        Session::flash('icon', $icon);
    }
}

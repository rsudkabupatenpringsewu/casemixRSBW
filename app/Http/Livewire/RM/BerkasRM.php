<?php

namespace App\Http\Livewire\RM;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class BerkasRM extends Component
{
    public $status_lanjut = '';
    public $jenis_berkas = '';
    public $cari_nomor = '';
    public $tgl1;
    public $tgl2;
    public function mount() {
        $this->tgl1 = now()->format('Y-m-d');
        $this->tgl2 = now()->format('Y-m-d');
    }
    public function render()
    {
        $getBerkasPasien = DB::table('file_casemix')
            ->select('file_casemix.jenis_berkas', 'file_casemix.no_rkm_medis', 'file_casemix.no_rawat', 'reg_periksa.tgl_registrasi', 'reg_periksa.status_lanjut', 'pasien.nm_pasien', 'file_casemix.file')
            ->join('reg_periksa','file_casemix.no_rawat','=','reg_periksa.no_rawat')
            ->join('pasien','reg_periksa.no_rkm_medis','=','pasien.no_rkm_medis')
            ->whereBetween('reg_periksa.tgl_registrasi',[$this->tgl1 , $this->tgl2])
            ->when($this->jenis_berkas, function ($query) {
                return $query->where('file_casemix.jenis_berkas', $this->jenis_berkas);
            })
            ->when($this->status_lanjut, function ($query) {
                return $query->where('reg_periksa.status_lanjut', $this->status_lanjut);
            })
            ->where(function($query)  {
                $query->orWhere('reg_periksa.no_rawat', 'like', '%' . $this->cari_nomor . '%');
                $query->orWhere('reg_periksa.no_rkm_medis', 'like', '%' . $this->cari_nomor . '%');
                $query->orWhere('pasien.nm_pasien', 'like', '%' . $this->cari_nomor . '%');
            })
            ->get();
        return view('livewire.r-m.berkas-r-m', [
            'getBerkasPasien' => $getBerkasPasien,
        ]);
    }
}

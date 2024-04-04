<?php

namespace App\Http\Livewire\BrigingBpjs;

use Livewire\Component;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use App\Services\Bpjs\ReferensiBPJS;

class SepVclaim extends Component
{
    protected $referensi;
    public function __construct()
    {
        $this->referensi = new ReferensiBPJS;
    }

    public function mount()
    {
        $this->CariSepVclaim();
    }
    public function render()
    {
        $this->CariSepVclaim();
        return view('livewire.briging-bpjs.sep-vclaim');
    }

    // 1 ===================================================================================
    public $getSep;
    public $getSep2;
    public $getRegPeriksa;
    public $cari_no_rawat;
    public $cari_no_sep;
    public $getSetting;
    public function CariSepVclaim()
    {
        try {
            $caceService = DB::table('setting')
            ->select('setting.nama_instansi',
                'setting.kabupaten',
                'setting.propinsi')
            ->first();
            $data = json_decode($this->referensi->CariSepVclaim1($this->cari_no_sep));
            $data2 = json_decode($this->referensi->CariSepVclaim2($this->cari_no_sep));
            $responsesSep = $data->response;
            $responsesSep2 = $data2->response;
            $reg_periksa = DB::table('reg_periksa')
                ->select('dokter.nm_dokter', 'reg_periksa.no_rawat', 'pasien.nm_pasien', 'reg_periksa.umurdaftar', 'reg_periksa.no_reg', 'reg_periksa.status_lanjut', 'pasien.no_tlp')
                ->join('pasien', 'reg_periksa.no_rkm_medis', '=', 'pasien.no_rkm_medis')
                ->join('dokter', 'reg_periksa.kd_dokter', '=', 'dokter.kd_dokter')
                ->where('reg_periksa.no_rawat', $this->cari_no_rawat)
                ->first();

            $this->getSetting =  [[$caceService][0]];
            $this->getSep = [[$responsesSep][0]];
            $this->getSep2 = [[$responsesSep2][0]];
            $this->getRegPeriksa = [[$reg_periksa][0]];
        } catch (\Throwable $th) {
        }
    }

    // 2 ===================================================================================
    public function SimpanSep() {
            dd(
                $this->getSetting[0]['nama_instansi'],
                $this->getSep[0]['noSep'],
                $this->getSep[0]['tglSep'],
                $this->getSep[0]['peserta']['noKartu'],
                $this->getRegPeriksa[0]['no_rawat'],
                $this->getRegPeriksa[0]['no_rawat'],
            );
    }

}

<?php

namespace App\Http\Livewire\Bpjs;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SettingBpjs extends Component
{
    public function mount() {
        $this->getListCasemix();
    }
    public function render()
    {
        $this->getListCasemix();
        return view('livewire.bpjs.setting-bpjs', [
            'getDataListCasemix' => $this->loadDataCasemix,
        ]);
    }

    public $loadDataCasemix;
    public function getListCasemix() {
       $this->loadDataCasemix = DB::connection('db_con2')
            ->table('file_casemix')
            ->select('file_casemix.id',
                'file_casemix.no_rkm_medis',
                'file_casemix.no_rawat',
                'file_casemix.nama_pasein',
                'file_casemix.jenis_berkas',
                'file_casemix.file')
            ->get();
    }
}

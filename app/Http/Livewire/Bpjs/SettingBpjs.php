<?php

namespace App\Http\Livewire\Bpjs;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

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
    public $cariNomor = '';
    public function getListCasemix() {
        $cariNomor = $this->cariNomor;
        $this->loadDataCasemix = DB::connection('db_con2')
            ->table('file_casemix')
            ->select('file_casemix.id',
                'file_casemix.no_rkm_medis',
                'file_casemix.no_rawat',
                'file_casemix.nama_pasein',
                'file_casemix.jenis_berkas',
                'file_casemix.file')
            ->where(function($query) use ($cariNomor) {
                $query->orWhere('file_casemix.no_rkm_medis', $cariNomor );
                $query->orWhere('file_casemix.no_rawat', $cariNomor );
                $query->orWhere('file_casemix.nama_pasein', $cariNomor );
            })
            ->get();
    }

    // UPDATE
    public function deleteDataFile($id, $jenis_berkas, $file) {
        try {
            DB::connection('db_con2')
                ->table('file_casemix')
                ->where('id', $id)
                ->delete();
                $this->flashMessage('Data berhasil dihapus!', 'warning', 'check');
                switch ($jenis_berkas) {
                    case 'INACBG':
                        Storage::disk('public')->delete('file_inacbg/' . $file);
                        break;
                    case 'SCAN':
                        Storage::disk('public')->delete('file_scan/' . $file);
                        break;
                    case 'RESUMEDLL':
                        Storage::disk('public')->delete('resume_dll/' . $file);
                        break;
                    case 'HASIL':
                        unlink(public_path('hasil_pdf/'.$file));
                        break;
                    default:
                        break;
                }
        } catch (\Exception $e) {
            $this->flashMessage('Terjadi kesalahan saat menghapus data.', 'danger', 'ban');
        }

    }

    // ALLERT
    // ALLERT FUNTION
    private function flashMessage($message, $color, $icon){
        Session::flash('message', $message);
        Session::flash('color', $color);
        Session::flash('icon', $icon);
    }
}

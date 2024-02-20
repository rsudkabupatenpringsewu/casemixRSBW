<?php

namespace App\Http\Livewire\Keperawatan;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PengawasKeperawatan extends Component
{

    public $kodejnslb;
    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->cariPasien();
        $this->cariNamaKegiatan();
        $this->getLookBook();
        $this->kodejnslb =  $this->kodejnslb;
    }
    public function render()
    {
        $this->cariPasien();
        $this->cariNamaKegiatan();
        $this->getLookBook();
        $this->kodejnslb =  $this->kodejnslb;
        return view('livewire.keperawatan.pengawas-keperawatan');
    }

    // Get Pasien
    public $cari_nama_rm;
    public $getPasien;
    public function cariPasien() {
        $querypasien = $this->cari_nama_rm;
        $this->getPasien = DB::table('pasien')
        ->select('pasien.no_rkm_medis', 'pasien.nm_pasien', 'pasien.jk',  'pasien.no_tlp', 'pasien.tgl_lahir')
        ->where('pasien.no_rkm_medis',$this->cari_nama_rm)
        ->get();
    }

    // Get Jenis LookBook
    public $getLookBook;
    public function getLookBook() {
        $this->getLookBook = DB::connection('db_con2')->table('jenis_lookbook')
        ->select('kd_jesni_lb', 'nama_jenis_lb')
        ->get();
    }

    // Get Nama Kegiatan
    public $getKegiatan;
    public $cari_kode_kegiatan;
    public function cariNamaKegiatan() {
        $cariKode = $this->cari_kode_kegiatan;
        $this->getKegiatan = DB::connection('db_con2')->table('rsbw_nm_kegiatan_keperawatan')
        ->select('rsbw_nm_kegiatan_keperawatan.kd_kegiatan', 'rsbw_nm_kegiatan_keperawatan.nama_kegiatan', 'default_mandiri','default_supervisi')
        ->where('kd_jesni_lb', $this->kodejnslb)
        ->where(function ($query) use ($cariKode) {
            $query->orwhere('kd_kegiatan', 'LIKE', "%$cariKode%")
                ->orWhere('nama_kegiatan', 'LIKE', "%$cariKode%");
        })
        ->get();
    }

    // Simpan Kegiatan
    public $mandiri = [];
    public $dibawahsupervisi = [];
    public $tanggal;
    public function initializeCheckbox($namaKegiatan, $key, $default_mandiri)
    {
        if ($default_mandiri === false) {
            $this->$namaKegiatan[$key] = false;
        }else{
            $this->$namaKegiatan[$key] = true;
        }
    }
    public function simpanKegiatan($key, $kd_kegiatan, $user, $no_rkm_medis) {
        DB::connection('db_con2')->table('logbook_keperawatan')->insert([
            'kd_kegiatan' => $kd_kegiatan,
            'user' => $user,
            'no_rkm_medis' => $no_rkm_medis,
            'mandiri' => $this->mandiri[$key],
            'supervisi' => $this->dibawahsupervisi[$key],
            'tanggal' => $this->tanggal,
        ]);
        Session::flash('sucsess'.$key, 'Berhasil');
    }
}

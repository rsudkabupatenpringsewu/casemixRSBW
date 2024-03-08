<?php

namespace App\Http\Livewire\Keperawatan;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PengawasKeperawatan extends Component
{

    protected $listeners = ['render'];

    public $kodejnslb;
    public $tanggal;
    public function mount()
    {
        $this->tanggal = date('Y-m-d');
        $this->cariPasien();
        $this->cariNamaKegiatan();
        $this->cariKewenanganKhusus();
        $this->getLookBook();
        $this->kodejnslb =  $this->kodejnslb;
    }
    public function render()
    {
        $this->cariPasien();
        $this->cariNamaKegiatan();
        $this->cariKewenanganKhusus();
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

    // Get Nama Kegiatan Dasar
    public $mandiri = [];
    public $dibawahsupervisi = [];
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
        foreach ($this->getKegiatan as $key => $kegiatan) {
            $this->mandiri[$key] = $kegiatan->default_mandiri == 'false' ? false : true;
            $this->dibawahsupervisi[$key] = $kegiatan->default_supervisi == 'false' ? false : true;
        }
    }

    // Simpan Kegiatan Dasar
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

     // Get Nama Kegiatan Kewewnangan Khusus
    public $kw_mandiri = [];
    public $kw_dibawahsupervisi = [];
    public $getKewenanganKhusus;
    public $cari_kode_kewenagankhusus;
    public function cariKewenanganKhusus() {
        $cariKode = $this->cari_kode_kewenagankhusus;
        $this->getKewenanganKhusus = DB::connection('db_con2')->table('rsbw_kewenangankhusus_keperawatan')
        ->select('rsbw_kewenangankhusus_keperawatan.kd_kewenangan', 'rsbw_kewenangankhusus_keperawatan.nama_kewenangan', 'default_mandiri','default_supervisi')
        ->where('kd_jesni_lb', $this->kodejnslb)
        ->where(function ($query) use ($cariKode) {
            $query->orwhere('kd_kewenangan', 'LIKE', "%$cariKode%")
                ->orWhere('nama_kewenangan', 'LIKE', "%$cariKode%");
        })
        ->get();
        foreach ($this->getKewenanganKhusus as $key => $kegiatan) {
            $this->kw_mandiri[$key] = $kegiatan->default_mandiri == 'false' ? false : true;
            $this->kw_dibawahsupervisi[$key] = $kegiatan->default_supervisi == 'false' ? false : true;
        }
    }
    public function simpanKewenangan($key, $kd_kewenangan, $user, $no_rkm_medis) {
        DB::connection('db_con2')->table('logbook_keperawatan_kewenangankhusus')->insert([
            'kd_kewenangan' => $kd_kewenangan,
            'user' => $user,
            'no_rkm_medis' => $no_rkm_medis,
            'mandiri' => $this->kw_mandiri[$key],
            'supervisi' => $this->kw_dibawahsupervisi[$key],
            'tanggal' => $this->tanggal,
        ]);
        Session::flash('sucsess2'.$key, 'Berhasil');
    }
}

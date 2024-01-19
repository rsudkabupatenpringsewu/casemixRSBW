<?php

namespace App\Http\Livewire\Farmasi;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MinimalStokObat extends Component
{
    public $bangsal = 'DepRI';
    public $stok_minimal_medis;

    public function mount()
    {
        $this->bangsal = $this->bangsal;
    }

    public function render()
    {
        $getListObat = DB::table('bangsal')
        ->select('gudangbarang.stok',
            'databarang.nama_brng',
            'bangsal.nm_bangsal',
            'stok_minimal_medis.stok_minimal_medis',
            'stok_minimal_medis.kode_brng',
            'databarang.kdjns',
            'jenis.nama',
            'kodesatuan.satuan')
        ->join('gudangbarang','gudangbarang.kd_bangsal','=','bangsal.kd_bangsal')
        ->join('databarang','gudangbarang.kode_brng','=','databarang.kode_brng')
        ->join('stok_minimal_medis','stok_minimal_medis.kode_brng','=','databarang.kode_brng')
        ->join('jenis','databarang.kdjns','=','jenis.kdjns')
        ->join('kodesatuan','databarang.kode_sat','=','kodesatuan.kode_sat')
        ->where('bangsal.nm_bangsal','=','Depo Ranap')
        ->when($this->bangsal, function ($query) {
                return $query->where('bangsal.kd_bangsal', $this->bangsal);
        })
        ->orderBy('stok','asc')
        ->orderBy('nama_brng','asc')
        ->get();

        return view('livewire.farmasi.minimal-stok-obat',[
            'getListObat' => $getListObat,
        ]);
    }

    public function update($kd_brng)
    {
      return DB::table('stok_minimal_medis')
            ->where('kode_brng', $kd_brng)
            ->update(['stok_minimal_medis' => $this->stok_minimal_medis]);
    }
}

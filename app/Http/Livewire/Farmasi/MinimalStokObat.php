<?php

namespace App\Http\Livewire\Farmasi;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MinimalStokObat extends Component
{
    public $bangsal = '';
    public $stok_minimal_medis;

    public function mount()
    {
        $this->bangsal = $this->bangsal;
    }

    public function render()
    {
        $getListObat = DB::table('stok_minimal_medis')
        ->select('stok_minimal_medis.kode_brng as kode_brng',
            'databarang.nama_brng as nama_brng',
            'kodesatuan.satuan as satuan',
            'stok_minimal_medis.stok_minimal_medis',
            'gudangbarang.stok as stok',
            'bangsal.nm_bangsal as nm_bangsal')
        ->join('bangsal','stok_minimal_medis.kd_bangsal','=','bangsal.kd_bangsal')
        ->join('databarang','stok_minimal_medis.kode_brng','=','databarang.kode_brng')
        ->join('kodesatuan',function($join) {
            $join->on('databarang.kode_sat','=','kodesatuan.kode_sat')
            ->on('databarang.kode_satbesar','=','kodesatuan.kode_sat');
        })
        ->join('gudangbarang',function($join) {
            $join->on('bangsal.kd_bangsal','=','gudangbarang.kd_bangsal')
            ->on('databarang.kode_brng','=','gudangbarang.kode_brng');
        })
        ->when($this->bangsal, function ($query) {
                return $query->where('bangsal.kd_bangsal', $this->bangsal);
        })
        ->orderBy('kode_brng','asc')
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

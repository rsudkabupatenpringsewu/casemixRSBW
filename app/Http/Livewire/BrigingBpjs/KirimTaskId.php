<?php

namespace App\Http\Livewire\BrigingBpjs;

use Livewire\Component;
use App\Services\Bpjs\Referensi;
use Illuminate\Support\Facades\DB;

class KirimTaskId extends Component
{
    protected $Referensi;
    public function __construct() {
        $this->Referensi = new Referensi;
    }

    public $date;
    public $time;
    public function mount() {
        date_default_timezone_set('Asia/Jakarta');
        $this->date = date('Y-m-d');
        $this->time = date('H:i:s');
        $this->tanggal1 = date('Y-m-d');
        $this->tanggal2= date('Y-m-d');
        $this->getPasienMJKN();
    }
    public function render()
    {
        $this->getPasienMJKN();
        return view('livewire.briging-bpjs.kirim-task-id');
    }

    public $carinomor;
    public $tanggal1;
    public $tanggal2;
    public $getPasienMJKN;
    public function getPasienMJKN() {
        $cariKode = $this->carinomor;
        $this->getPasienMJKN = DB::table('referensi_mobilejkn_bpjs')
        ->select('referensi_mobilejkn_bpjs.nobooking',
            'referensi_mobilejkn_bpjs.no_rawat',
            'referensi_mobilejkn_bpjs.norm',
            'referensi_mobilejkn_bpjs.status',
            'referensi_mobilejkn_bpjs.validasi',
            'referensi_mobilejkn_bpjs.jampraktek',
            'pasien.nm_pasien')
        ->join('pasien','referensi_mobilejkn_bpjs.norm','=','pasien.no_rkm_medis')
        ->whereBetween('referensi_mobilejkn_bpjs.tanggalperiksa',[$this->tanggal1, $this->tanggal2])
        ->where(function ($query) use ($cariKode) {
            $query->orwhere('referensi_mobilejkn_bpjs.nobooking', 'LIKE', "%$cariKode%")
            ->orwhere('referensi_mobilejkn_bpjs.no_rawat', 'LIKE', "%$cariKode%")
            ->orwhere('referensi_mobilejkn_bpjs.norm', 'LIKE', "%$cariKode%");
        })
        ->get();
    }

    public $kodebooking;
    public $taskid;
    public $waktu;
    public $getCekin;
    public function cekinBPJS() {
        date_default_timezone_set('Asia/Jakarta');
        $timestamp_sec = strtotime($this->date.$this->time);
        $this->waktu = $timestamp_sec * 1000;
        $jayParsedAry = [
            "kodebooking" => $this->kodebooking, //"20240301000001",
            "taskid" => $this->taskid,
            "waktu" => $this->waktu
        ];
        try {
            $data = json_decode($this->Referensi->cekinBPJS(json_encode($jayParsedAry)));
            $this->getCekin = [$data->metadata];
        } catch (\Throwable $th) {
        }
    }


    // TESTTTT
    public $responses=[];
    public function Test() {
        $test = DB::table('referensi_mobilejkn_bpjs')
        ->select('referensi_mobilejkn_bpjs.nobooking', 'referensi_mobilejkn_bpjs.validasi')
        ->whereBetween('referensi_mobilejkn_bpjs.tanggalperiksa',['2024-03-01','2024-03-16'])
        ->get();
        foreach($test as $row){
            $timestamp_sec = strtotime($row->validasi);
            $waktu = $timestamp_sec * 1000;
            $jayParsedAry = [
                "kodebooking" => $row->nobooking.'111',
                "taskid" => '3',
                "waktu" => $waktu,
            ];
            $data = json_decode($this->Referensi->cekinBPJS(json_encode($jayParsedAry)));
            $data->metadata->kodebooking = $jayParsedAry['kodebooking'];
            $this->responses[] = $data;
        }
    }
}

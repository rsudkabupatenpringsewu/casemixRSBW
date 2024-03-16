<?php

namespace App\Http\Livewire\BrigingBpjs;

use Livewire\Component;
use App\Services\Bpjs\Referensi;

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
    }
    public function render()
    {
        return view('livewire.briging-bpjs.kirim-task-id');
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
}

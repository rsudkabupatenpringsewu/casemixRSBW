<?php

namespace App\Services\Bpjs;

use Bpjs\Bridging\Antrol\BridgeAntrol;
use Bpjs\Bridging\Vclaim\BridgeVclaim;

class Referensi
{
    protected $bridging;
    protected $antrol;

    public function __construct()
	{
		$this->bridging = new BridgeVclaim();
        $this->antrol = new BridgeAntrol();
	}

    public function getDiagnosa($kode)
	{
        try {
            $endpoint = 'referensi/diagnosa/'. $kode;
            return $this->bridging->getRequest($endpoint);
        } catch (\Throwable $th) {
            return [];
        }
	}

    public function getPoli($kode)
	{
        try {
            $endpoint = 'referensi/poli/'. $kode;
            return $this->bridging->getRequest($endpoint);
        } catch (\Throwable $th) {
            return [];
        }
	}

    public function getFasilitasKesehatan($parameter1, $parameter2)
	{
        try {
            $endpoint = 'referensi/faskes/'.$parameter1.'/'.$parameter2;
            return $this->bridging->getRequest($endpoint);
        } catch (\Throwable $th) {
            return [];
        }
	}

    public function cekinBPJS($data)
	{
            $endpoint = 'antrean/updatewaktu';
            return $this->antrol->postRequest($endpoint, $data, "POST");
	}
}

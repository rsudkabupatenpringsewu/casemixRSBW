<?php

namespace App\Http\Controllers\BriggingBpjs;

use Illuminate\Http\Request;
use App\Services\Bpjs\Referensi;
use App\Http\Controllers\Controller;

class KirimTaskId extends Controller
{
    function KirimTaskId() {
        return view('briging-bpjs.kirim-taskid');
    }

}

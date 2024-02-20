<?php

namespace App\Http\Controllers\Keperawatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengawasKeperawatan extends Controller
{
    function PengawasKeperawatan() {
        return view('keperawatan.keperawatan');
    }
}

<?php

namespace App\Http\Controllers\Test;

use setasign\Fpdi\Fpdi;
use Spatie\PdfToImage\Pdf;
use Illuminate\Http\Request;
use App\Services\TestService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{

    function Test(){
        $jsonData = '[
                {
                  "kode_brng": "GB000000983",
                  "stok_minimal_medis": "280"
                },
                {
                  "kode_brng": "GB000153",
                  "stok_minimal_medis": "250"
                },
                {
                  "kode_brng": "GB000076",
                  "stok_minimal_medis": "190"
                },
                {
                  "kode_brng": "GU000002414",
                  "stok_minimal_medis": "190"
                },
                {
                  "kode_brng": "GB000005876",
                  "stok_minimal_medis": "180"
                },
                {
                  "kode_brng": "GB000000981",
                  "stok_minimal_medis": "150"
                },
                {
                  "kode_brng": "GB000006230",
                  "stok_minimal_medis": "130"
                },
                {
                  "kode_brng": "B000007415",
                  "stok_minimal_medis": "110"
                },
                {
                  "kode_brng": "GB000120",
                  "stok_minimal_medis": "95"
                },
                {
                  "kode_brng": "GB000182",
                  "stok_minimal_medis": "90"
                },
                {
                  "kode_brng": "GB000063",
                  "stok_minimal_medis": "85"
                },
                {
                  "kode_brng": "AB000002213",
                  "stok_minimal_medis": "80"
                },
                {
                  "kode_brng": "B000006984",
                  "stok_minimal_medis": "75"
                },
                {
                  "kode_brng": "GB000000995",
                  "stok_minimal_medis": "100"
                },
                {
                  "kode_brng": "GB000002723",
                  "stok_minimal_medis": "70"
                },
                {
                  "kode_brng": "GB000051",
                  "stok_minimal_medis": "150"
                },
                {
                  "kode_brng": "GB000003030",
                  "stok_minimal_medis": "70"
                },
                {
                  "kode_brng": "GB000002490",
                  "stok_minimal_medis": "65"
                },
                {
                  "kode_brng": "B000007189",
                  "stok_minimal_medis": "65"
                },
                {
                  "kode_brng": "GB000043",
                  "stok_minimal_medis": "150"
                },
                {
                  "kode_brng": "B000007466",
                  "stok_minimal_medis": "60"
                },
                {
                  "kode_brng": "GB000000987",
                  "stok_minimal_medis": "60"
                },
                {
                  "kode_brng": "GB000002460",
                  "stok_minimal_medis": "55"
                },
                {
                  "kode_brng": "B000006474",
                  "stok_minimal_medis": "55"
                },
                {
                  "kode_brng": "GB000003220",
                  "stok_minimal_medis": "50"
                },
                {
                  "kode_brng": "B000006511",
                  "stok_minimal_medis": "50"
                },
                {
                  "kode_brng": "B000006382",
                  "stok_minimal_medis": "50"
                },
                {
                  "kode_brng": "GB000112",
                  "stok_minimal_medis": "50"
                },
                {
                  "kode_brng": "B000007242",
                  "stok_minimal_medis": "50"
                },
                {
                  "kode_brng": "GB000005899",
                  "stok_minimal_medis": "50"
                },
                {
                  "kode_brng": "GB000001337",
                  "stok_minimal_medis": "50"
                },
                {
                  "kode_brng": "GB000000839",
                  "stok_minimal_medis": "40"
                },
                {
                  "kode_brng": "GB000006033",
                  "stok_minimal_medis": "40"
                },
                {
                  "kode_brng": "GB000090",
                  "stok_minimal_medis": "40"
                },
                {
                  "kode_brng": "GB000118",
                  "stok_minimal_medis": "150"
                },
                {
                  "kode_brng": "GB000128",
                  "stok_minimal_medis": "100"
                },
                {
                  "kode_brng": "GB000078",
                  "stok_minimal_medis": "40"
                },
                {
                  "kode_brng": "GB000127",
                  "stok_minimal_medis": "40"
                },
                {
                  "kode_brng": "GU000005834",
                  "stok_minimal_medis": "40"
                },
                {
                  "kode_brng": "GU000001356",
                  "stok_minimal_medis": "35"
                },
                {
                  "kode_brng": "GB000140",
                  "stok_minimal_medis": "35"
                },
                {
                  "kode_brng": "GB000028",
                  "stok_minimal_medis": "35"
                },
                {
                  "kode_brng": "AB000002201",
                  "stok_minimal_medis": "35"
                },
                {
                  "kode_brng": "GB000202",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000007469",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000000990",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000179",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000040",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000131",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000003005",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000002345",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000191",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000006700",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000002540",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000007304",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000057",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000003665",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000006780",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000003131",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000000982",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000002388",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000091",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000001177",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000002527",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000059",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GU000669",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000183",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000015",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000000992",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000156",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000001839",
                  "stok_minimal_medis": "19"
                },
                {
                  "kode_brng": "B000006960",
                  "stok_minimal_medis": "19"
                },
                {
                  "kode_brng": "AB000002202",
                  "stok_minimal_medis": "19"
                },
                {
                  "kode_brng": "GB000126",
                  "stok_minimal_medis": "19"
                },
                {
                  "kode_brng": "B000007228",
                  "stok_minimal_medis": "19"
                },
                {
                  "kode_brng": "GB000006295",
                  "stok_minimal_medis": "18"
                },
                {
                  "kode_brng": "GU000001439",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GU000000964",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "B000007232",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000173",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000055",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000006767",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000006378",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000002941",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "B000007214",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000003240",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000007496",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000001747",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000031",
                  "stok_minimal_medis": "15"
                },
                {
                  "kode_brng": "GU000004058",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000001773",
                  "stok_minimal_medis": "15"
                },
                {
                  "kode_brng": "GB000003037",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000006313",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000006197",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000007152",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000006771",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "B000007276",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000754",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000047",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000210",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "B000007013",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000000928",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000006067",
                  "stok_minimal_medis": "15"
                },
                {
                  "kode_brng": "B000007302",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "B000006809",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000006719",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GU000788",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000006769",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000686",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000743",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000003383",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000002642",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000001552",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000000970",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000484",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "B000006647",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000003263",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000003085",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000000918",
                  "stok_minimal_medis": "35"
                },
                {
                  "kode_brng": "GU000001448",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000001560",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000003352",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000002907",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000141",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "B000007308",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000129",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000001386",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000001520",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000744",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000006224",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000001104",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000001178",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000007495",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000001076",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000003011",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000301",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000102",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000139",
                  "stok_minimal_medis": "6"
                },
                {
                  "kode_brng": "GB000001801",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000006281",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000006493",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "B000006463",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000001162",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000001751",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "B000007141",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000001983",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000745",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "B000007268",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000003112",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000145",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000026",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000007063",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000000936",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "GB000096",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000005942",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GU000001978",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "B000007041",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000000841",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "AU000006360",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GU000018",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "B000007483",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000106",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000001440",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000006178",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000000927",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "B000007471",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "GB000001039",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000003425",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000007477",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GU000196",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000003031",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "B000006484",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000397",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000003171",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000157",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "B000007404",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000002946",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000006419",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000002557",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GU000000873",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "B000006680",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000006282",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000003022",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000001500",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000006366",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "B000006855",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000002509",
                  "stok_minimal_medis": "40"
                },
                {
                  "kode_brng": "GU000001024",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000000926",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "GB000006119",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000000949",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000007470",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000069",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000001941",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "GU000001803",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "GB000002330",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000458",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GU000483",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GU000001570",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000003234",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "B000007322",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000006255",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000000885",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "GB000001828",
                  "stok_minimal_medis": "20"
                },
                {
                  "kode_brng": "GB000006275",
                  "stok_minimal_medis": "30"
                },
                {
                  "kode_brng": "B000007172",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "GB000003431",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000001434",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000001201",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "GB000001123",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000144",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000005943",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "B000007158",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000361",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "GB000001785",
                  "stok_minimal_medis": "5"
                },
                {
                  "kode_brng": "GU000452",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000808",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GB000002981",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000284",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000316",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000000980",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000004336",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000000922",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000000923",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000001079",
                  "stok_minimal_medis": "10"
                },
                {
                  "kode_brng": "GU000000888",
                  "stok_minimal_medis": "10"
                }
        ]';

        $barangArray = json_decode($jsonData, true);

        foreach ($barangArray as &$barangData) {
            $barangData['kd_bangsal'] = 'DepRI';
        }

        // DB::table('stok_minimal_medis')->insert($barangArray);


    }

    function TestDelete(Request $request) {

    }
}

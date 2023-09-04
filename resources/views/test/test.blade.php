@extends('..layout.layoutDashboard')
@section('title', 'Casemix Bpjs')

@section('konten')

    {{-- RADIOLOGIIII TESSSSSSSSSSSSSS ===================================== --}}
    {{-- @foreach ($getLaborat as $periksa)
        <p>No Rawat: {{ $periksa->no_rawat }}</p>
        <p>No Rekam Medis: {{ $periksa->no_rkm_medis }}</p>
        <p>Nama Pasien: {{ $periksa->nm_pasien }}</p>
        <p>Tgl Periksa: {{ $periksa->tgl_periksa }}</p>
        <p>Jam: {{ $periksa->jam }}</p>

        @foreach ($periksa->getPeriksaLab as $perawatan)
            <p>Kode Jenis Perawatan: {{ $perawatan->kd_jenis_prw }}</p>
            <p>Nama Perawatan: {{ $perawatan->nm_perawatan }}</p>

            @foreach ($perawatan->getDetailLab as $detail)
                <p> Pemeriksaan: {{ $detail->Pemeriksaan }} = {{ $detail->nilai }}</p>
            @endforeach
        @endforeach
        <hr>
    @endforeach --}}

    {{-- HOMECASEMIX ======================================--}}
    {{-- <div class="row">
        @foreach ($getPasien as $item)
            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                    <div class="card-header text-muted border-bottom-0">
                        Pasein
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-7">
                                <h4 class="lead"><b>{{ $item->nm_pasien }}</b></h4>
                                <p class="text-muted text-sm"><b> {{ $item->no_rkm_medis }}</b> </p>
                                <ul class="ml-4 mb-0 fa-ul text-muted">
                                    <li class="small"><span class="fa-li">
                                            <i class="fas fa-lg fa-building"></i></span>
                                        Alamat : {{ $item->alamat }}
                                    </li>
                                    <li class="small mt-2"><span class="fa-li">
                                            <i class="fas fa-lg fa-phone"></i></span>
                                        Telp : {{ $item->no_tlp }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex align-center">
                        @if (isset($cekBerkas[$item->no_rawat]))
                            @php $color = 'bg-success'; @endphp
                        @else
                            @php $color = 'bg-primary'; @endphp
                        @endif
                        <form action="{{url('cariNorawat-ClaimBpjs')}}" method="">
                        @csrf
                            <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                            <button href="#" class="btn btn-sm {{$color}}" target="">
                                <i class="fas fa-upload"> File Scan</i>
                            </button>
                        </form>
                        <form action="{{url('carinorawat-casemix')}}" method="" class="mx-2">
                        @csrf
                            <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                            <button href="#" class="btn btn-sm bg-primary">
                                <i class="fas fa-save"> Berkas Khanza</i>
                            </button>
                        </form>
                        <form action="{{url('test-cari')}}" method="" class="mx-2">
                        @csrf
                            <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                            <button href="#" class="btn btn-sm bg-primary">
                                <i class="fas fa-save"> Gabungkan</i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div> --}}

    {{-- TESTTT AWAL MEDIS======================================== --}}
    {{-- <div class="card card-primary">
        <div class="card-body">
            <div class="card py-4  d-flex justify-content-center align-items-center">
                <table border="0px" width="1000px">
                    <tr>
                        <td rowspan="3"> <img src="../img/rs.png" alt="Girl in a jacket"
                                width="90" height="75"></td>
                        <td class="text-center">
                            <h4>RS. BUMI WARAS </h4>
                        </td>
                        <td width="150px"></td>
                    </tr>
                    <tr class="text-center">
                        <td>Jln. Wolter Monginsidi No. 235 , Bandar Lampung, Lampung
                            (0721) 254589</td>
                        <td width="150px"></td>
                    </tr>
                    <tr class="text-center">
                        <td> E-mail : www.rsbumiwaras.co.id</td>
                        <td width="150px"></td>
                    </tr>
                </table>
                <div style="border: 1px solid #000;">
                    <table border="0px" width="1000px">
                        <tr>
                            <td class="text-center" style="background-color: rgb(236, 230, 197)"><h5>PENILAIAN AWAL MEDIS RAWAT INAP</h5></td>
                        </tr>
                    </table>
                    <table width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td width="181px"> No. RM</td>
                            <td width="252px">: {{$awalMedis->no_rkm_medis}}</td>
                            <td width="155px"> Jenis Kelamin</td>
                            @php
                                $jenisKelamin = ($awalMedis->jk == 'P') ? "Perempuan" : "Laki-laki";
                            @endphp
                            <td width="131px">: {{$jenisKelamin}}</td>
                            <td width="116px"> Tanggal</td>
                            <td width="165px">: {{ date('d/m/Y h:i:s', strtotime($awalMedis->tanggal)) }}</td>
                        </tr>
                        <tr>
                            <td>Nama Pasien</td>
                            <td>: {{$awalMedis->nm_pasien}}</td>
                            <td>Tanggal Lahir</td>
                            <td>: {{ date('d/m/Y', strtotime($awalMedis->tgl_lahir)) }}</td>
                            <td>Anamnesis</td>
                            <td>: {{$awalMedis->anamnesis}}</td>
                        </tr>
                    </table>
                    <table width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td width="500px">
                                I. RIWAYAT KESEHATAN
                                <p>Keluhan Utama : {{$awalMedis->keluhan_utama}}</p>
                            </td>
                            <td width="500px"></td>
                        </tr>
                    </table>
                    <table border="0px" width="1000px" class="" style="border-top: 1px solid #000;">
                        <tr>
                            <td width="500px" height="60px" style="vertical-align: top;">
                                Riwayat Penyakit Sekarang : {{$awalMedis->rps}}
                            </td>
                            <td width="500px"></td>
                        </tr>
                    </table>
                    <table width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td width="500px" height="50px" style="vertical-align: top;">
                                Riwayat Penyakit Dahulu : {{$awalMedis->rpd}}
                            </td>
                            <td width="500px" height="50px" style="vertical-align: top;">
                                Riwayat Penyakit dalam Keluarga : {{$awalMedis->rpk}}
                            </td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td width="500px" height="50px" style="vertical-align: top;">
                                Riwayat Pengobatan : {{$awalMedis->rpo}}
                            </td>
                            <td width="500px" height="50px" style="vertical-align: top;">
                                Riwayat Alergi : {{$awalMedis->alergi}}
                            </td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td>II. PEMERIKSAAN FISIK</td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td width="129px">Keadaan Umum</td>
                            <td width="269px">: {{$awalMedis->keadaan}}</td>
                            <td width="117px">Kesadaraan </td>
                            <td width="183px">: {{$awalMedis->kesadaran}}</td>
                            <td width="106px">GCS(E,V,M)</td>
                            <td width="195px">: {{$awalMedis->gcs}}</td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td class="text-center">
                                Tanda Vital :
                                TD : {{$awalMedis->td}}mmHg
                                N :{{$awalMedis->nadi}} x/m
                                R : {{$awalMedis->rr}} x/m
                                S : {{$awalMedis->suhu}}
                                SPO2 : {{$awalMedis->spo}} %
                                BB : {{$awalMedis->bb}} Kg
                                TB : {{$awalMedis->tb}}cm
                            </td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td width="129 px">Kepala</td>
                            <td width="148px">: {{$awalMedis->kepala}}</td>
                            <td width="117px">Thoraks</td>
                            <td width="106px">: {{$awalMedis->thoraks}}</td>
                            <td width="500px"></td>
                        </tr>
                        <tr>
                            <td>Mata</td>
                            <td>: {{$awalMedis->mata}}</td>
                            <td>Abdomen</td>
                            <td>: {{$awalMedis->abdomen}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Gigi & Mulut</td>
                            <td>: {{$awalMedis->gigi}}</td>
                            <td>Genital & Anus</td>
                            <td>: {{$awalMedis->genital}}</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Leher</td>
                            <td>: {{$awalMedis->leher}}</td>
                            <td>Ekstremitas</td>
                            <td>: {{$awalMedis->ekstremitas}}</td>
                            <td></td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td>III. STATUS LOKALIS</td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td height="200px" style="vertical-align: top;">{{$awalMedis->ket_lokalis}}</td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td height="80px" style="vertical-align: top;">Keterangan : {{$awalMedis->ket_fisik}}</td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td>IV. PEMERIKSAAN PENUNJANG</td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr height="50px">
                            <td width="330px" style="vertical-align: top;">EKG : {{$awalMedis->ekg}}</td>
                            <td width="330px" style="vertical-align: top;">Radiologi  : {{$awalMedis->rad}}</td>
                            <td width="330px" style="vertical-align: top;">Laboratorium : {{$awalMedis->lab}}</td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td>
                                V. DIAGNOSIS
                                <p>{{$awalMedis->diagnosis}}</p>
                            </td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr>
                            <td>
                                VI. TATALAKSANA
                                <p>{{$awalMedis->tata}}</p>
                            </td>
                        </tr>
                    </table>
                    <table  width="1000px" style="border-top: 1px solid #000;">
                        <tr class="text-center">
                            <td width="500px">Tanggal dan Jam </td>
                            <td width="500px">Nama Dokter dan Tanda Tangan </td>
                        </tr>
                        <tr class="text-center">
                            <td width="500px">{{ date('d/m/Y h:i:s', strtotime($awalMedis->tanggal)) }} WIB</td>
                            <td width="500px">
                                <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di ' .'RS. BUMI WARAS,' . ' Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $awalMedis->nm_dokter . ' ID ' . $awalMedis->kd_dokter . ' ' , 'QRCODE') }}"
                                    alt="barcode" width="80px" height="75px" />
                                    <br>
                                {{$awalMedis->nm_dokter}}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}




@endsection

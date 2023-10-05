@extends('..layout.layoutDashboard')
@section('title', 'Casemix Bpjs')

@section('konten')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header">
                    <h5 class="card-title"></h5>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    {{-- BERKAS SEP ============================================================= --}}
                    @if ($getSEPFisio)
                        <div class="card-body">
                            <div class="card p-4 d-flex justify-content-center align-items-center">
                                <table border="0px" width="1000px">
                                    <tr>
                                        <td rowspan="3"> <img src="../img/rs.png" alt="Girl in a jacket" width="90"
                                                height="75"></td>
                                        <td class="text-center">
                                            <h4>RS. BUMI WARAS </h4>
                                        </td>
                                        <td class="text-center" width="100px">
                                        </td>
                                    </tr>
                                    <tr class="text-center mr-5">
                                        <td>Jln. Wolter Monginsidi No. 235 , Bandar Lampung, Lampung
                                            (0721) 254589</td>
                                    </tr>
                                    <tr class="text-center">
                                        <td> E-mail : www.rsbumiwaras.co.id</td>
                                    </tr>
                                </table>
                                <hr width="1000px" class="mt-1 mb-0"
                                            style=" height:2px; border-top:1px solid black; border-bottom:2px solid black;">
                                <table border="0px" width="1000px">
                                    <tr class="text-center">
                                        <td colspan="0">
                                            <h5 class="mt-2">LEMBAR FORMULIR RAWAT JALAN <br/> LAYANAN KEDOKTERAN FISIK DAN REHABILITAS</h5>
                                        </td>
                                    </tr>
                                </table>
                                <div style="border:solid black 2px;">
                                    <table border="0px" width="985px" class="mx-1">
                                        <tr>
                                            <td><b>Data Pasien</b></td>
                                        </tr>
                                        <tr>
                                            <td width="250px">No.Rawat</td>
                                            <td>: {{$getSEPFisio->no_rawat}}</td>
                                        </tr>
                                        <tr>
                                            <td>No.RM</td>
                                            <td>: {{$getSEPFisio->no_rkm_medis}}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Pasien</td>
                                            <td>: {{$getSEPFisio->nm_pasien}}</td>
                                        </tr>
                                        <tr>
                                            <td>Poliklinik</td>
                                            <td>: {{$getSEPFisio->nm_poli}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div style="border:solid black 2px; margin-top: 10px">
                                    <table border="0px" width="985px" class="mx-1">
                                        <tr>
                                            <td><b>Diisi oleh Dokter</b></td>
                                        </tr>
                                        <tr>
                                            <td width="250px">Tanggal Pelayanan</td>
                                            <td>: {{$getSEPFisio->tgl_perawatan}}</td>
                                        </tr>
                                        <tr>
                                            <td>Anamnesa</td>
                                            <td>: {{$getSEPFisio->keluhan}}</td>
                                        </tr>
                                        <tr>
                                            <td>Diagnosa</td>
                                            <td>: {{$getSEPFisio->penilaian}}</td>
                                        </tr>
                                        <tr>
                                            <td>Pemeriksaan Fisik dan Uji Fungsi</td>
                                            <td>: {{$getSEPFisio->pemeriksaan}}</td>
                                        </tr>
                                        <tr>
                                            <td>Suhu Tubuh</td>
                                            <td>: {{$getSEPFisio->suhu_tubuh}}</td>
                                        </tr>
                                        <tr>
                                            <td>Tensi</td>
                                            <td>: {{$getSEPFisio->tensi}}</td>
                                        </tr>
                                        <tr>
                                            <td>Nadi</td>
                                            <td>: {{$getSEPFisio->nadi}}</td>
                                        </tr>
                                        <tr>
                                            <td>Anjuran</td>
                                            <td>: {{$getSEPFisio->instruksi}}</td>
                                        </tr>
                                        <tr>
                                            <td>Evaluasi</td>
                                            <td>: {{$getSEPFisio->evaluasi}}</td>
                                        </tr>
                                        <tr>
                                            <td>Tata Laksana KFR (ICD 9 CM)</td>
                                            <td>: {{$getSEPFisio->rtl}}</td>
                                        </tr>
                                    </table>
                                </div>
                                <table border="0px" width="1000px" class="mt-3" class="">
                                    <tr>
                                        <td width="250px" class="text-center">

                                        </td>
                                        <td width="150px"></td>
                                        <td width="250px" class="text-center">
                                            Dokter Penanggung Jawab
                                            <div class="barcode mt-1">
                                                <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di RS. BUMI WARAS, Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh dr. Sanjoto Santibudi, Sp.KFR ID ' . $getSEPFisio->kd_dokter . ' ' . $getSEPFisio->tgl_registrasi, 'QRCODE') }}"
                                                    alt="barcode" width="80px" height="75px" />
                                            </div>
                                            dr. Sanjoto Santibudi, Sp.KFR
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    @else
                        {{-- NULL --}}
                    @endif

                    <div class="card-footer">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

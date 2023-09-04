@extends('..layout.layoutDashboard')
@section('title', 'Casemix Bpjs')

@section('konten')
    <div class="row">
        <div class="col-md-12">

            @if (session('success'))
                @php
                    $cardColor = 'card-success';
                    $textCard = session('success');
                @endphp
            @else
                @php
                    $cardColor = 'card-primary';
                    $textCard = 'Casemix Bpjs';
                @endphp
            @endif

            <div class="card  {{ $cardColor }}">
                <div class="card-header">
                    <h5 class="card-title">{{ $textCard }}</h5>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">

                            </div>
                        </div>
                        @if (isset($_GET['cariNorawat']))
                            <div class="col-md-8">
                                <div class="form-group">
                                    @php
                                        $printNoRawat = isset($_GET['cariNorawat']) ? $_GET['cariNorawat'] : '';
                                        $cariNoSep = isset($_GET['cariNoSep']) ? $_GET['cariNoSep'] : '';
                                    @endphp
                                    {{-- <a href="{{ url('print-casemix', urlencode($printNoRawat)) }}" rel="noopener"
                                        class="btn btn-success float-right"><i class="fas fa-print"></i>
                                        Simpan PDF</a> --}}
                                    <form action="{{ url('/print-casemix') }}" method="">
                                        @csrf
                                        <input name="cariNorawat" value="{{ $printNoRawat }}" hidden>
                                        <input name="cariNoSep" value="{{ $cariNoSep }}" hidden>
                                        <button type="submit" class="btn btn-success float-right">
                                            <i class="fas fa-save"> Simpan PDF</i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="col-md-8">
                            </div>
                        @endif
                    </div>
                    @if ($jumlahData > 0)
                        {{-- BERKAS SEP ============================================================= --}}
                        @if ($getSEP)
                            <div class="card-body">
                                <div class="card p-4 d-flex justify-content-center align-items-center">
                                    <table width="990px" border="0px">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" width="250px"><img src="img/bpjs.png" width="250px"
                                                        class="" alt="">
                                                </th>
                                                <th class="text-center pr-5">
                                                    <h4><b>SURAT ELEGIBILITAS PESERTA</h4></b>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th class="text-center pr-5">
                                                    <h5><b>RS.BUMI WARAS</b></h5>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="4" class="text-right">
                                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($getSEP->no_sep, 'C39+') }}"
                                                        alt="barcode" width="300px" height="35px" />
                                                </th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <table width="990px" border="0px">
                                        <tr>
                                            <td width="150px">No. SEP</td>
                                            <td width="400px">: {{ $getSEP->no_sep }}</td>
                                            <td width="150px">No. Rawat</td>
                                            <td width="279px">: {{ $getSEP->no_rawat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Tgl. SEP</td>
                                            <td width="450px">: {{ date('d/m/Y', strtotime($getSEP->tglsep)) }}</td>
                                            <td>No. Reg</td>
                                            <td>: {{ $getSEP->no_reg }}</td>
                                        </tr>
                                        <tr>
                                            <td>No. Kartu</td>
                                            <td colspan="">: {{ $getSEP->no_kartu }} (MR: {{ $getSEP->nomr }})</td>
                                            <td>Peserta</td>
                                            <td>: {{ $getSEP->peserta }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama Peserta</td>
                                            <td>: {{ $getSEP->nama_pasien }}</td>
                                            <td>Jns Rawat</td>
                                            @php
                                                $jnsRawat = $getSEP->status_lanjut == 'Ranap' ? 'Rawat Inap' : 'Rawat Jalan';
                                            @endphp
                                            <td>: {{ $jnsRawat }}
                                            </td>
                                        </tr>
                                        <tr>
                                            @php
                                                $jnsKunjungan = $getSEP->tujuankunjungan == 0 ? '-Konsultasi dokter(Pertama)' : 'Kunjungan Kontrol(ulangan)';
                                            @endphp
                                            <td>Tgl. Lahir</td>
                                            <td>: {{ date('d/m/Y', strtotime($getSEP->tanggal_lahir)) }}
                                            </td>
                                            <td>Jns. Kunjungan</td>
                                            <td class="text-xs">: {{ $jnsKunjungan }}</td>
                                        </tr>
                                        <tr>
                                            @php
                                                $Prosedur = $getSEP->flagprosedur == 0 ? '-Prosedur Tidak Berkelanjutan' : ($getSEP->flagprosedur == 1 ? '- Prosedur dan Terapi Tidak Berkelanjutan' : '');
                                            @endphp
                                            <td style="vertical-align: top;">No. Telpon</td>
                                            <td style="vertical-align: top;">: {{ $getSEP->notelep }}</td>
                                            <td></td>
                                            <td class="text-xs">{{ $Prosedur }}</td>
                                        </tr>
                                        <tr>
                                            <td>Sub/Spesialis</td>
                                            <td>: {{ $getSEP->nmpolitujuan }}</td>
                                            <td>Poli Perujuk</td>
                                            <td>: -</td>
                                        </tr>
                                        <tr>
                                            <td>Dokter</td>
                                            <td>: {{ $getSEP->nmdpdjp }}</td>
                                            <td>Kls. Hak</td>
                                            <td>: Kelas {{ $getSEP->klsrawat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Fasker Perujuk</td>
                                            <td>: {{ $getSEP->nmppkrujukan }}</td>
                                            <td>Kls. Rawat</td>
                                            <td>: {{ $getSEP->klsrawat }}</td>
                                        </tr>
                                        <tr>
                                            <td>Diagnosa Awal</td>
                                            <td>: {{ $getSEP->nmdiagnosaawal }}</td>
                                            <td>Penjamin</td>
                                            <td>: BPJS Kesehatan</td>
                                        </tr>
                                        <tr>
                                            <td>Catatan</td>
                                            <td>: {{ $getSEP->catatan }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </table>
                                    <table width="990px" border="0px">
                                        <tr>
                                            <td class="text-xs">
                                                *Saya Menyetujui BPJS Kesehatan Menggunakan Informasi Medis Pasien jika
                                                diperlukan.
                                                <br>
                                                *SEP bukan sebagai bukti penjamin peserta <br>
                                                Catatan Ke 1 {{ date('Y-m-d H:i:s') }}

                                            </td>
                                            <td class="text-center" width="350px">
                                                Pasien/Keluarga Pasien <br>
                                                <div class="barcode">
                                                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di ' . $getSEP->nmppkpelayanan . ',' . ' Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $getSEP->nama_pasien . ' ID ' . $getSEP->no_kartu . ' ' . $getSEP->tglsep, 'QRCODE') }}"
                                                        alt="barcode" width="80px" height="75px" />
                                                </div>
                                                <b>{{ $getSEP->nama_pasien }}</b>
                                            </td>
                                        </tr>
                                    </table>

                                </div>
                            </div>
                        @else
                            {{-- NULL --}}
                        @endif

                        {{-- RESUME PASIEN ============================================================= --}}
                        @if ($getResume && $statusLanjut)
                            @if ($statusLanjut->status_lanjut == 'Ranap')
                                {{-- BERKAS RESUME RANAP --}}
                                <div class="card-body">
                                    <div class="card py-4  d-flex justify-content-center align-items-center">
                                        <table border="0px" width="1000px">
                                            <tr>
                                                <td rowspan="3"> <img src="../img/rs.png" alt="Girl in a jacket"
                                                        width="90" height="75"></td>
                                                <td class="text-center">
                                                    <h4>RS. BUMI WARAS </h4>
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Jln. Wolter Monginsidi No. 235 , Bandar Lampung, Lampung
                                                    (0721) 254589</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td> E-mail : www.rsbumiwaras.co.id</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td colspan="2">
                                                    <h4 class="mt-2"><b>RESUME MEDIS PASIEN</b></h4>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px">
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Nama Pasien</td>
                                                <td width="400px">: {{ $getResume->nm_pasien }}</td>
                                                <td width="100px">No. Rekam Medis</td>
                                                <td width="200px">: {{ $getResume->no_rkm_medis }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Umur</td>
                                                <td width="400px">: {{ $getResume->umurdaftar }} Th</td>
                                                <td width="100px">Ruang</td>
                                                <td width="200px">: {{ $getResume->kd_kamar }} |
                                                    {{ $getResume->nm_bangsal }}
                                                </td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Tgl Lahir</td>
                                                <td width="400px">:
                                                    {{ date('d-m-Y', strtotime($getResume->tgl_lahir)) }}
                                                </td>
                                                <td width="100px">Jenis Kelamin</td>
                                                @php
                                                    $jnsKelamin = $getResume->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki';
                                                @endphp
                                                <td width="200px">: {{ $jnsKelamin }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Pekerjaan</td>
                                                <td width="400px">: {{ $getResume->pekerjaan }}</td>
                                                <td width="100px">Tanggal Masuk</td>
                                                <td width="200px">:
                                                    {{ date('d-m-Y', strtotime($getResume->tgl_masuk)) }}
                                                </td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Alamat</td>
                                                <td width="400px">: {{ $getResume->almt_pj }}</td>
                                                <td width="100px">Tanggak Keluar</td>
                                                <td width="200px">:
                                                    {{ date('d-m-Y', strtotime($getResume->tgl_keluar)) }}
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Diagnosa Awal Masuk
                                                </td>
                                                <td style="vertical-align: top;"> : {{ $getResume->diagnosa_awal }}
                                                </td>
                                                <td width="250px"></td>
                                            </tr>
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Alasan Masuk Dirawat
                                                </td>
                                                <td style="vertical-align: top;"> : {{ $getResume->alasan }}</td>
                                                <td width="250px"></td>
                                            </tr>
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Keluhan Utama Riwayat
                                                    Penyakit
                                                </td>
                                                <td style="vertical-align: top;"> : {{ $getResume->keluhan_utama }}
                                                </td>
                                                <td width="250px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Pemeriksaan Fisik</td>
                                                <td style="vertical-align: top;"> :
                                                    {{ $getResume->pemeriksaan_fisik }}
                                                </td>
                                                <td width="250px"></td>
                                            </tr>
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Jalannya Penyakit
                                                    Selama
                                                    Perawatan
                                                </td>
                                                <td style="vertical-align: top;"> :
                                                    {{ $getResume->jalannya_penyakit }}
                                                </td>
                                                <td width="250px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Pemeriksaan Penunjang
                                                    Radiologi
                                                    Terpenting
                                                </td>
                                                <td style="vertical-align: top;"> :
                                                    {{ $getResume->pemeriksaan_penunjang }}
                                                </td>
                                                <td width="200px"></td>
                                            </tr>
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Pemeriksaan Penunjang
                                                    Laboratorium
                                                    Terpenting</td>
                                                <td style="vertical-align: top;"> : {{ $getResume->hasil_laborat }}
                                                </td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Tindakan/Operasi
                                                    Selama
                                                    Perawatan
                                                </td>
                                                <td style="vertical-align: top;"> :
                                                    {{ $getResume->tindakan_dan_operasi }}
                                                </td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Obat-obatan Selama
                                                    Perawatan
                                                </td>
                                                <td style="vertical-align: top;"> : {{ $getResume->obat_di_rs }}</td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px">Diagnosa Akhir</td>
                                                <td colspan="2"></td>
                                                <td width="80px" class="text-center">Kode ICD</td>
                                                <td width="20px"></td>
                                            </tr>
                                            <tr>
                                                <td width="250px">&nbsp; - Diagnosa Utama </td>
                                                <td>: {{ $getResume->diagnosa_utama }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_utama }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px">&nbsp; - Diagnosa Sekunder </td>
                                                <td>: 1. {{ $getResume->diagnosa_sekunder }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_sekunder }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 2. {{ $getResume->diagnosa_sekunder2 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_sekunder2 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 3. {{ $getResume->diagnosa_sekunder3 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_sekunder3 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 4. {{ $getResume->diagnosa_sekunder4 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_sekunder4 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px">&nbsp; - Prosedur/Tindakan Utama </td>
                                                <td>: {{ $getResume->prosedur_utama }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_prosedur_utama }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px">&nbsp; - Prosedur/Tindakan Sekunder </td>
                                                <td>: 1. {{ $getResume->prosedur_sekunder }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->prosedur_sekunder }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 2. {{ $getResume->prosedur_sekunder2 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_prosedur_sekunder2 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 3. {{ $getResume->prosedur_sekunder3 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_prosedur_sekunder3 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px">Alergi / Reaksi Obat</td>
                                                <td>: {{ $getResume->alergi }}</td>
                                                <td width="200px"></td>
                                            </tr>
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Diet Selama Perawatan
                                                </td>
                                                <td style="vertical-align: top;">: {{ $getResume->diet }}</td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Hasil Lab Yang Belum
                                                    Selesai
                                                    (Pending)
                                                </td>
                                                <td style="vertical-align: top;">: {{ $getResume->lab_belum }}</td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Instruksi/Anjuran Dan
                                                    Edukasi
                                                    (Follow
                                                    Up)
                                                </td>
                                                <td style="vertical-align: top;">: {{ $getResume->edukasi }}</td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="197px">Keadaan Pulang</td>
                                                <td width="370px">: {{ $getResume->keadaan }}</td>
                                                <td width="197px">Cara Keluar</td>
                                                <td width="235px">: {{ $getResume->cara_keluar }}</td>
                                            </tr>
                                            <tr>
                                                <td width="197px">Dilanjutkan</td>
                                                <td width="370px">: {{ $getResume->dilanjutkan }}</td>
                                                <td width="197px">Tanggal Kontrol</td>
                                                <td width="235px">:
                                                    {{ date('d-m-Y h:i', strtotime($getResume->kontrol)) }}
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Obat-obatan waktu
                                                    pulang
                                                </td>
                                                <td style="vertical-align: top;">: {{ $getResume->obat_pulang }}</td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3" class="">
                                            <tr>
                                                <td width="250px" class="text-center">
                                                    Dokter Penanggung Jawab
                                                    <div class="barcode mt-1">
                                                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di RS. BUMI WARAS, Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $getResume->nm_dokter . ' ID ' . $getResume->kd_dokter . ' ' . $getResume->tgl_keluar, 'QRCODE') }}"
                                                            alt="barcode" width="80px" height="75px" />
                                                    </div>
                                                    {{ $getResume->nm_dokter }}
                                                </td>
                                                <td width="150px"></td>
                                                <td width="250px" class="text-center">
                                                    Dokter Penanggung Jawab2
                                                    <div class="barcode mt-1">
                                                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di RS. BUMI WARAS, Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $getResume->nm_dokter . ' ID ' . $getResume->kd_dokter . ' ' . $getResume->tgl_keluar, 'QRCODE') }}"
                                                            alt="barcode" width="80px" height="75px" />
                                                    </div>
                                                    {{ $getResume->nm_dokter }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @else
                                {{-- BERKAS RESUME RALAN --}}
                                <div class="card-body">
                                    <div class="card py-4  d-flex justify-content-center align-items-center">
                                        <table border="0px" width="1000px">
                                            <tr>
                                                <td rowspan="3"> <img src="../img/rs.png" alt="Girl in a jacket"
                                                        width="90" height="75"></td>
                                                <td class="text-center">
                                                    <h4>RS. BUMI WARAS </h4>
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Jln. Wolter Monginsidi No. 235 , Bandar Lampung, Lampung
                                                    (0721) 254589</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td> E-mail : www.rsbumiwaras.co.id</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td colspan="2">
                                                    <h4 class="mt-2"><b>RESUME MEDIS</b></h4>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px">
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Nama Pasien</td>
                                                <td width="400px">: {{ $getResume->nm_pasien }}</td>
                                                <td width="100px">No. Rekam Medis</td>
                                                <td width="200px">: {{ $getResume->no_rkm_medis }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Umur</td>
                                                <td width="400px">: {{ $getResume->umurdaftar }} Th</td>
                                                <td width="100px">Ruang</td>
                                                <td width="200px">: {{ $getResume->nm_poli }} </td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Tgl Lahir</td>
                                                <td width="400px">:
                                                    {{ date('d-m-Y', strtotime($getResume->tgl_lahir)) }}
                                                </td>
                                                <td width="100px">Jenis Kelamin</td>
                                                @php
                                                    $jnsKelamin = $getResume->jk == 'P' ? 'Perempuan' : 'Laki-laki';
                                                @endphp
                                                <td width="200px">: {{ $jnsKelamin }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Pekerjaan</td>
                                                <td width="400px">: {{ $getResume->pekerjaan }}</td>
                                                <td width="100px">Tanggal Masuk</td>
                                                <td width="200px">:
                                                    {{ date('d-m-Y', strtotime($getResume->tgl_registrasi)) }}
                                                </td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="100px">Alamat</td>
                                                <td width="400px">: {{ $getResume->almt_pj }}</td>
                                                <td width="100px">Tanggak Keluar</td>
                                                <td width="200px">:
                                                    {{ date('d-m-Y', strtotime($getResume->tgl_registrasi)) }}
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">

                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Keluhan utama dari
                                                    riwayat
                                                    penyakit
                                                    yang positif</td>
                                                <td style="vertical-align: top;"> : {{ $getResume->keluhan_utama }}
                                                </td>
                                                <td width="250px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Jalannya Penyakit
                                                    Selama
                                                    Perawatan
                                                </td>
                                                <td style="vertical-align: top;"> :
                                                    {{ $getResume->jalannya_penyakit }}
                                                </td>
                                                <td width="250px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Pemeriksaan penunjang
                                                    yang
                                                    positif
                                                </td>
                                                <td style="vertical-align: top;"> :
                                                    {{ $getResume->pemeriksaan_penunjang }}
                                                </td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Hasil laboratorium
                                                    yang
                                                    positif
                                                </td>
                                                <td style="vertical-align: top;"> : {{ $getResume->hasil_laborat }}
                                                </td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px">Diagnosa Akhir</td>
                                                <td colspan="2"></td>
                                                <td width="80px" class="text-center">Kode ICD</td>
                                                <td width="20px"></td>
                                            </tr>
                                            <tr>
                                                <td width="250px">&nbsp; - Diagnosa Utama </td>
                                                <td>: {{ $getResume->diagnosa_utama }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_utama }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px">&nbsp; - Diagnosa Sekunder </td>
                                                <td>: 1. {{ $getResume->diagnosa_sekunder }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_sekunder }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 2. {{ $getResume->diagnosa_sekunder2 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_sekunder2 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 3. {{ $getResume->diagnosa_sekunder3 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_sekunder3 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 4. {{ $getResume->diagnosa_sekunder4 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_diagnosa_sekunder4 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px">&nbsp; - Prosedur/Tindakan Utama </td>
                                                <td>: {{ $getResume->prosedur_utama }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_prosedur_utama }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px">&nbsp; - Prosedur/Tindakan Sekunder </td>
                                                <td>: 1. {{ $getResume->prosedur_sekunder }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->prosedur_sekunder }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 2. {{ $getResume->prosedur_sekunder2 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_prosedur_sekunder2 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                            <tr>
                                                <td width="250px"></td>
                                                <td>&nbsp; 3. {{ $getResume->prosedur_sekunder3 }}</td>
                                                <td width="20px" class="text-right">(</td>
                                                <td width="80px" class="text-center">
                                                    {{ $getResume->kd_prosedur_sekunder3 }}
                                                </td>
                                                <td>)</td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Kondisi pasien pulang
                                                </td>
                                                <td style="vertical-align: top;"> : {{ $getResume->kondisi_pulang }}
                                                </td>
                                                <td width="200px"></td>
                                            </tr>
                                            <tr>
                                                <td width="250px" style="vertical-align: top;">Obat-obatan waktu
                                                    pulang/nasihat
                                                </td>
                                                <td style="vertical-align: top;"> : {{ $getResume->obat_pulang }}
                                                </td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3" class="">
                                            <tr>
                                                <td width="250px" class="text-center">

                                                </td>
                                                <td width="150px"></td>
                                                <td width="250px" class="text-center">
                                                    Dokter Penanggung Jawab2
                                                    <div class="barcode mt-1">
                                                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di RS. BUMI WARAS, Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $getResume->nm_dokter . ' ID ' . $getResume->kd_dokter . ' ' . $getResume->tgl_registrasi, 'QRCODE') }}"
                                                            alt="barcode" width="80px" height="75px" />
                                                    </div>
                                                    {{ $getResume->nm_dokter }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        @else
                            {{-- NULL --}}
                        @endif

                        {{-- RIANCIAN BIAYA ============================================================= --}}
                        @if ($bilingRalan)
                            <div class="card-body">
                                <div class="card py-3  d-flex justify-content-center align-items-center">
                                    <table width="1000px" border="0px">
                                        <tr>
                                            <td rowspan="4"> <img src="../img/rs.png" alt="Girl in a jacket"
                                                    width="90" height="75"></td>
                                            <td class="text-center">
                                                <h4>RS. BUMI WARAS </h4>
                                            </td>
                                        </tr>
                                        <tr class="text-center">
                                            <td>Jln. Wolter Monginsidi No. 235 , Bandar Lampung, Lampung
                                                (0721) 254589</td>
                                        </tr>
                                        <tr class="text-center">
                                            <td> E-mail : www.rsbumiwaras.co.id</td>
                                        </tr>
                                        <tr class="text-center">
                                            @php
                                                $jnsRawatNota = $statusLanjut->status_lanjut == 'Ranap' ? 'RAWAT INAP' : 'RAWAT JALAN';
                                            @endphp
                                            <td> RIANCIAN BIAYA {{ $jnsRawatNota }}</td>
                                        </tr>
                                    </table>
                                    <table border="0px" width="1000px" class="mt-3 text-xs">
                                        @php
                                            $totalBiaya = 0;
                                        @endphp
                                        @foreach ($bilingRalan as $item)
                                            <tr>
                                                <td width="150px">{{ $item->no }}</td>
                                                <td width="500px">{{ $item->nm_perawatan }}</td>
                                                <td width="100px">
                                                    @if ($item->biaya == 0)
                                                        {{-- Display an empty cell --}}
                                                    @else
                                                        {{ number_format($item->biaya, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                                <td width="85px">
                                                    @if ($item->jumlah == 0)
                                                        {{-- Display an empty cell --}}
                                                    @else
                                                        {{ $item->jumlah }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->totalbiaya == 0)
                                                        {{-- Display an empty cell --}}
                                                    @else
                                                        {{ number_format($item->totalbiaya, 0, ',', '.') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @php
                                                $totalBiaya += $item->totalbiaya;
                                            @endphp
                                        @endforeach
                                        <tr>
                                            <td>TOTAL TAGIHAN</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>{{ number_format($totalBiaya, 0, ',', '.') }}</b></td>
                                        </tr>
                                        <tr>
                                            <td>PPN</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>TAGIHAN + PPN</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>{{ number_format($totalBiaya, 0, ',', '.') }}</b></td>
                                        </tr>
                                        <tr>
                                            <td>DEPOSIT</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>EKSES</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td>SISA PIUTANG</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td><b>{{ number_format($totalBiaya, 0, ',', '.') }}</b></td>
                                        </tr>

                                    </table>
                                </div>
                            </div>
                        @else
                            {{-- NULL --}}
                        @endif

                        {{-- BERKAS LABORAT =============================================================  --}}
                        @if ($getLaborat)
                            <div class="card-body">
                                @foreach ($getLaborat as $periksa)
                                    <div class="card-body">
                                        <div class="card py-3  d-flex justify-content-center align-items-center">
                                            <table border="0px" width="1000px">
                                                <tr>
                                                    <td rowspan="4"> <img src="../img/rs.png" alt="Girl in a jacket"
                                                            width="90" height="75">
                                                    </td>
                                                    <td class="text-center">
                                                        <h4>RS. BUMI WARAS </h4>
                                                    </td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td>Jln. Wolter Monginsidi No. 235 , Bandar Lampung, Lampung
                                                        (0721)
                                                        254589</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td> E-mail : www.rsbumiwaras.co.id</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td colspan="">
                                                        <h5 class="mt-2">HASIL PEMERIKSAAN LABORATORIUM</h5>
                                                    </td>
                                                </tr>
                                            </table>
                                            <table border="0px" width="1000px">
                                                <tr style="vertical-align: top;">
                                                    <td width="130px">No.RM</td>
                                                    <td width="300px">: {{ $periksa->no_rkm_medis }}</td>
                                                    <td width="130px">No.Rawat </td>
                                                    <td width="200px">: {{ $periksa->no_rawat }}</td>
                                                </tr>
                                                <tr style="vertical-align: top;">
                                                    <td width="130px">Nama Pasien</td>
                                                    <td width="300px">: {{ $periksa->nm_pasien }}</td>

                                                    <td width="130px">Tgl. Periksa </td>
                                                    <td width="200px">:
                                                        {{ date('d-m-Y', strtotime($periksa->tgl_periksa)) }}
                                                    </td>
                                                </tr>
                                                <tr style="vertical-align: top;">
                                                    <td width="130px">JK/Umur </td>
                                                    <td width="300px">: {{ $periksa->jk }} / {{ $periksa->umur }}
                                                    </td>

                                                    <td width="130px">Jam Periksa </td>
                                                    <td width="200px">: {{ $periksa->jam }}</td>
                                                    </td>
                                                </tr>

                                                <tr style="vertical-align: top;">
                                                    <td width="130px">Alamat </td>
                                                    <td width="300px">: {{ $periksa->alamat }}</td>
                                                    @if ($statusLanjut->status_lanjut == 'Ranap')
                                                        <td width="130px">Kamar </td>
                                                        <td width="200px">: {{ $periksa->nm_bangsal }}</td>
                                                    @else
                                                        <td width="130px">Poli </td>
                                                        <td width="200px">: {{ $periksa->nm_poli }}</td>
                                                    @endif
                                                </tr>
                                                <tr style="vertical-align: top;">
                                                    <td width="130px"> Dokter Pengirim </td>
                                                    <td width="300px">: {{ $periksa->nm_dokter_pj }} </td>
                                                    <td width="130px"> </td>
                                                    <td width="200px"></td>
                                                </tr>
                                            </table>
                                            <table border="1px" width="1000px" class="mt-2">
                                                <tr>
                                                    <td width="220px" class="text-center">Pemeriksaan</td>
                                                    <td width="130px" class="text-center">Hasil</td>
                                                    <td width="200px" class="text-center">Satuan</td>
                                                    <td width="200px" class="text-center">Nilai Rujukan</td>
                                                    <td width="200px" class="text-center">Keterangan</td>
                                                </tr>
                                                @foreach ($periksa->getPeriksaLab as $perawatan)
                                                    <tr>
                                                        <td colspan="5">- {{ $perawatan->nm_perawatan }}</td>
                                                    </tr>
                                                    @foreach ($perawatan->getDetailLab as $detail)
                                                        <tr>
                                                            <td width="220px"> &emsp;{{ $detail->Pemeriksaan }}</td>
                                                            <td width="130px" class="text-center">
                                                                {{ $detail->nilai }}
                                                            </td>
                                                            <td width="130px" class="text-center">
                                                                {{ $detail->satuan }}
                                                            </td>
                                                            <td width="130px" class="text-center">
                                                                {{ $detail->nilai_rujukan }}
                                                            </td>
                                                            <td width="130px">{{ $detail->keterangan }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </table>

                                            <table border="0px" width="1000px" class="mt-2">
                                                <tr>
                                                    <td class="text-xs"><b>Catatan :</b> Jika ada keragu-raguan
                                                        pemeriksaan,
                                                        diharapkan
                                                        segera menghubungi laboratorium</td>
                                                </tr>
                                            </table>

                                            <table border="0px" width="1000px">
                                                <tr>
                                                    <td width="250px" class="text-center">
                                                        Penanggung Jawab
                                                        <div class="barcode mt-1">
                                                            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di RS. BUMI WARAS, Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $periksa->nm_dokter . ' ID ' . $periksa->kd_dokter . ' ' . $periksa->tgl_periksa, 'QRCODE') }}"
                                                                alt="barcode" width="80px" height="75px" />
                                                        </div>
                                                        {{ $periksa->nm_dokter }}
                                                    </td>
                                                    <td width="150px"></td>
                                                    <td width="250px" class="text-center">
                                                        Hasil : {{ date('d-m-Y', strtotime($periksa->tgl_periksa)) }}
                                                        <br>
                                                        Petugas Laboratorium
                                                        <div class="barcode mt-1">
                                                            <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di RS. BUMI WARAS, Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $periksa->nama_petugas . ' ID ' . $periksa->nip . ' ' . $periksa->tgl_periksa, 'QRCODE') }}"
                                                                alt="barcode" width="80px" height="75px" />
                                                        </div>
                                                        {{ $periksa->nama_petugas }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            {{-- NULL --}}
                        @endif

                        {{-- BERKSA RADIOLOGI =============================================================  --}}
                        @if ($getRadiologi)
                            @foreach ($getRadiologi as $item)
                                <div class="card-body">
                                    <div class="card py-3  d-flex justify-content-center align-items-center">
                                        <table border="0px" width="1000px">
                                            <tr>
                                                <td rowspan="4"> <img src="../img/rs.png" alt="Girl in a jacket"
                                                        width="90" height="75"></td>
                                                <td class="text-center">
                                                    <h4>RS. BUMI WARAS </h4>
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <td>Jln. Wolter Monginsidi No. 235 , Bandar Lampung, Lampung
                                                    (0721)
                                                    254589</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td> E-mail : www.rsbumiwaras.co.id</td>
                                            </tr>
                                            <tr class="text-center">
                                                <td colspan="">
                                                    <h5 class="mt-2">HASIL PEMERIKSAAN RADIOLOGI</h5>
                                                </td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px">
                                            <tr style="vertical-align: top;">
                                                <td width="130px">No.RM</td>
                                                <td width="300px">: {{ $item->no_rkm_medis }}</td>
                                                <td width="130px">Penanggung Jawab</td>
                                                <td width="200px">: {{ $item->nm_dokter_pj }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">Nama Pasien</td>
                                                <td width="300px">: {{ $item->nm_pasien }}</td>
                                                <td width="130px">Dokter Pengirim</td>
                                                <td width="200px">: {{ $item->nm_dokter }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">JK/Umur </td>
                                                <td width="300px">: {{ $item->jk }} | {{ $item->umur }}</td>
                                                <td width="130px">Tgl.Pemeriksaan</td>
                                                <td width="200px">:
                                                    {{ date('d-m-Y', strtotime($item->tgl_periksa)) }}
                                                </td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">Alamat </td>
                                                <td width="300px">: {{ $item->alamat }}</td>
                                                <td width="130px">Jam Pemeriksaan</td>
                                                <td width="200px">: {{ $item->jam }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">No.Periksa </td>
                                                <td width="300px">: {{ $item->no_rawat }}</td>
                                                @if ($statusLanjut->status_lanjut == 'Ranap')
                                                    <td width="130px">Kamar </td>
                                                    <td width="200px">: {{ $item->kd_kamar }} |
                                                        {{ $item->nm_bangsal }}
                                                    </td>
                                                @else
                                                    <td width="130px">Poli </td>
                                                    <td width="200px">: {{ $item->nm_poli }}
                                                    </td>
                                                @endif
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">Pemeriksaan </td>
                                                <td width="300px">: {{ $item->nm_perawatan }}</td>
                                                <td width="130px"></td>
                                                <td width="200px"></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-4">
                                            <tr>
                                                <td width="500px">
                                                    {!! nl2br(e($item->hasil)) !!}
                                                </td>
                                                <td></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-3">
                                            <tr>
                                                <td width="250px" class="text-center">
                                                    Penanggung Jawab
                                                    <div class="barcode mt-1">
                                                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di RS. BUMI WARAS, Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $item->nm_dokter_pj . ' ID ' . $item->kd_dokter_pj . ' ' . $item->tgl_periksa, 'QRCODE') }}"
                                                            alt="barcode" width="80px" height="75px" />
                                                    </div>
                                                    {{ $item->nm_dokter_pj }}
                                                </td>
                                                <td width="150px"></td>
                                                <td width="250px" class="text-center">
                                                    Periksa : {{ date('d-m-Y', strtotime($item->tgl_periksa)) }} <br>
                                                    Petugas Laboratorium
                                                    <div class="barcode mt-1">
                                                        <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di RS. BUMI WARAS, Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $item->nama_pegawai . ' ID ' . $item->nip . ' ' . $item->tgl_periksa, 'QRCODE') }}"
                                                            alt="barcode" width="80px" height="75px" />
                                                    </div>
                                                    {{ $item->nama_pegawai }}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- NULL --}}
                        @endif

                        {{-- AWAL MEDIS ============================================================= --}}
                        @if ($awalMedis)
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
                        @else
                            {{-- NULL --}}
                        @endif


                        {{-- ERROR HANDLING ============================================================= --}}
                    @else
                        <div class="card-body">
                            <div class="card p-4 d-flex justify-content-center align-items-center">

                            </div>
                        </div>
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

@extends('..layout.layoutDashboard')
@section('title', 'Farmasi')

@section('konten')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h5 class="card-title"></h5>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if ($jumlahData > 0)
                        <div class="card-body">
                            <form action="{{ url('/print-sep-resep') }}" method="">
                                @csrf
                                <input name="cariNoRawat" value="{{$noRawat}}" hidden>
                                <input name="cariNoSep" value="{{$noSep}}" hidden>
                                <button type="submit" class="btn btn-success float-right">
                                    <i class="fas fa-save"> Simpan PDF</i>
                                </button>
                            </form>
                        </div>
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
                                                Catatan Ke 1 {{ date('d/m/Y', strtotime($getSEP->tglsep)) }}

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

                        {{-- BERKAS FARMASI (RESEP) --}}
                        @if ($berkasResep)
                            @foreach ($berkasResep as $itemresep)
                                <div class="card-body">
                                    <div class="card p-4 d-flex justify-content-center align-items-center">
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
                                        </table>
                                        <hr width="1000px"
                                            style=" height:2px; border-top:1px solid black; border-bottom:2px solid black;">
                                        <table border="0px" width="1000px">
                                            <tr style="vertical-align: top;">
                                                <td width="130px">Nama Pasien</td>
                                                <td width="870px">: {{ $itemresep->nm_pasien }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">No.RM</td>
                                                <td width="870px">: {{ $itemresep->no_rkm_medis }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">No.Rawat</td>
                                                <td width="870px">: {{ $itemresep->no_rawat }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">Penanggung</td>
                                                <td width="870px">: {{ $itemresep->png_jawab }}</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">Pemberi Resep</td>
                                                <td width="870px">: -</td>
                                            </tr>
                                            <tr style="vertical-align: top;">
                                                <td width="130px">No. Resep</td>
                                                <td width="870px">: {{ $itemresep->no_resep }}</td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-2">
                                            @php
                                                $no = 1;
                                                $totalResep = 0;
                                            @endphp
                                            @foreach ($itemresep->detailberkasResep as $itemresep)
                                                <tr>
                                                    <td width="30px" class="text-center">{{ $no++ }}</td>
                                                    <td width="500px">{{ $itemresep->nama_brng }}</td>
                                                    <td width="100px" class="text-center">{{ $itemresep->jml }}</td>
                                                    <td width="150px">{{ $itemresep->kode_sat }}</td>
                                                    <td>Rp. {{ number_format($itemresep->total, 2, ',', '.') }}</td>
                                                </tr>
                                                @php
                                                    $totalResep += $itemresep->total; // Menambahkan nilai $itemresep->total ke dalam total
                                                @endphp
                                            @endforeach
                                            <tr>
                                                <td></td>
                                                <td><b>TOTAL :</b></td>
                                                <td></td>
                                                <td></td>
                                                <td><b>Rp. {{ number_format($totalResep, 2, ',', '.') }}</b></td>
                                            </tr>
                                        </table>
                                        <table border="0px" width="1000px" class="mt-4" class="">
                                            <tr>
                                                <td width="250px" class="text-center">

                                                </td>
                                                <td width="150px"></td>
                                                <td width="250px" class="text-center">
                                                    <p>Bandar Lampung, {{ date('Y-m-d') }}</p>
                                                    <br class="mt-4">
                                                    <p><b>PETUGAS</b></p>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
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

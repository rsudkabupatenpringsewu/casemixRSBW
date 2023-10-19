<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pritn Berkas</title>
</head>
<style>
    body {
        font-family: Arial, sans-serif;
    }

    .text-xs {
        font-size: 8px;
        /* Adjust font size for paragraphs */
    }

    .h3 {
        font-size: 18px;
        font-weight: 700;
    }

    .h4 {
        font-size: 14px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10px;
        /* Adjust font size for tables */
    }

    .text-right {
        text-align: right;
    }

    .text-center {
        text-align: center;
    }

    .mt-1 {
        margin-top: 10px;
    }

    .mt-0 {
        margin-top: 0px;
    }

    .mb-0 {
        margin-bottom: 0px;
    }

    .mx-1 {
        margin: 5px 8px;
    }

    .card-body {
        page-break-after: always;
    }

    .card-body:last-child {
        page-break-after: auto;
    }
</style>

<body>
    @if ($jumlahData > 0)
        {{-- BERKAS SEP ============================================================= --}}
        @if ($getSEP)
            <div class="card-body">
                <div class="card p-4 d-flex justify-content-center align-items-center">
                    <table width="700px">
                        <thead>
                            <tr>
                                <th rowspan="2" width="150px"><img src="{{ public_path('img/bpjs.png') }}"
                                        width="150px" class="mt-0" alt="">
                                </th>
                                <th class="text-center">
                                    <span class="h3">SURAT ELEGIBILITAS PESERTA</span>
                                </th>
                            </tr>
                            <tr>
                                <th class="text-center">
                                    <span class="h3">RS.BUMI WARAS</span>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="4" class="text-right">
                                    <img class="mt-2"
                                        src="data:image/png;base64,{{ DNS1D::getBarcodePNG($getSEP->no_sep, 'C39+') }}"
                                        alt="barcode" width="200px" height="30px" />
                                </th>
                            </tr>
                        </thead>
                    </table>
                    <table width="700px" class="mt-2">
                        <tr>
                            <td width="144px">No. SEP</td>
                            <td width="250px">: {{ $getSEP->no_sep }}</td>
                            <td width="144px">No. Rawat</td>
                            <td width="150px">: {{ $getSEP->no_rawat }}</td>
                        </tr>
                        <tr>
                            <td>Tgl. SEP</td>
                            <td>: {{ date('d/m/Y', strtotime($getSEP->tglsep)) }}</td>
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
                    <table width="700px">
                        <tr>
                            <td class="text-xs">
                                *Saya Menyetujui BPJS Kesehatan Menggunakan Informasi Medis Pasien jika
                                diperlukan.
                                <br>
                                *SEP bukan sebagai bukti penjamin peserta <br>
                                Catatan Ke 1 {{ date('d/m/Y', strtotime($getSEP->tglsep)) }}

                            </td>
                            <td class="text-center" width="220px">
                                Pasien/Keluarga Pasien <br>
                                <div class="barcode mt-1">
                                    <img src="data:image/png;base64,{{ DNS2D::getBarcodePNG('Dikeluarkan di ' . $getSEP->nmppkpelayanan . ',' . ' Kabupaten/Kota Bandar Lampung Ditandatangani secara elektronik oleh ' . $getSEP->nama_pasien . ' ID ' . $getSEP->no_kartu . ' ' . $getSEP->tglsep, 'QRCODE') }}"
                                        alt="barcode" width="55px" height="55px" />
                                </div>
                                <b class="mt-1">{{ $getSEP->nama_pasien }}</b>
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
                        <table width="700px">
                            <tr>
                                <td rowspan="5"> <img src="{{ public_path('img/rs.png') }}" alt="Girl in a jacket"
                                        width="90" height="75">
                                </td>
                                <td class="text-center">
                                    <span class="h3">RS. BUMI WARAS </span>
                                </td>
                                <td class="text-center" width="100px">
                                </td>
                            </tr>
                            <tr class="text-center">
                                <td class="pr-4">Jln. Wolter Monginsidi No. 235 , Bandar Lampung, Lampung</td>
                            </tr>
                            <tr class="text-center">
                                <td class="pr-4">(0721)254589</td>
                            </tr>
                            <tr class="text-center">
                                <td class="pr-4">www.rsbumiwaras.co.id</td>
                            </tr>
                        </table>
                        <hr width="700px"
                            style=" height:2px; border-top:1px solid black; border-bottom:2px solid black;">
                        <table width="700px">
                            <tr style="vertical-align: top;">
                                <td width="130px">Nama Pasien</td>
                                <td width="530px">: {{ $itemresep->nm_pasien }}</td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td width="130px">No.RM</td>
                                <td>: {{ $itemresep->no_rkm_medis }}</td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td width="130px">No.Rawat</td>
                                <td>: {{ $itemresep->no_rawat }}</td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td width="130px">Penanggung</td>
                                <td>: {{ $itemresep->png_jawab }}</td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td width="130px">Pemberi Resep</td>
                                <td>: -</td>
                            </tr>
                            <tr style="vertical-align: top;">
                                <td width="130px">No. Resep</td>
                                <td>: {{ $itemresep->no_resep }}</td>
                            </tr>
                        </table>
                        <table width="700px" class="mt-1">
                            @php
                                $no = 1;
                                $totalResep = 0;
                            @endphp
                            @foreach ($itemresep->detailberkasResep as $itemresep)
                                <tr>
                                    <td width="30px" class="text-center">{{ $no++ }}</td>
                                    <td width="350px">{{ $itemresep->nama_brng }}</td>
                                    <td width="50px" class="text-center">{{ $itemresep->jml }}</td>
                                    <td width="80px">{{ $itemresep->kode_sat }}</td>
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
                        <table width="700px" class="mt-1">
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
    @endif
</body>

</html>

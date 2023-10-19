@foreach ($berkasResep as $itemresep)
    <div class="card-body">
        <div class="card p-4 d-flex justify-content-center align-items-center">
            <table border="0px" width="1000px">
                <tr>
                    <td rowspan="4"> <img src="../img/rs.png" alt="Girl in a jacket" width="90" height="75">
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
            <hr width="1000px" style=" height:2px; border-top:1px solid black; border-bottom:2px solid black;">
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

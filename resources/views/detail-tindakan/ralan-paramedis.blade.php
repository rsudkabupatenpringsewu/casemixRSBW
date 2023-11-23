@extends('..layout.layoutDashboard')
@section('title', 'Ralan Pamedis')

@section('konten')
    <div class="card">
        <div class="card-body">
            @include('detail-tindakan.component.cari-ralan-paramedis')
            <table class="table table-sm table-bordered table-striped table-responsive text-xs" style="white-space: nowrap;"
                id="tableToCopy">
                <tbody>
                    <tr>
                        <th>No.</th>
                        <th>No.Rawat</th>
                        <th>No.R.M.</th>
                        <th>Nama Pasien</th>
                        <th>Kd.Tnd</th>
                        <th>Perawatan/Tindakan</th>
                        <th>NIP</th>
                        <th>Paramedis Yang Menangani</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Cara Bayar</th>
                        <th>Ruangan</th>
                        <th>Jasa Sarana</th>
                        <th>Paket BHP</th>
                        <th>JM</th>
                        <th>KSO</th>
                        <th>Menejemen</th>
                        <th>Total</th>
                    </tr>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($RalanParamedis as $item)
                        <tr>
                            <td>{{$no++}}</td>
                            <td>{{$item->no_rawat}}</td>
                            <td>{{$item->no_rkm_medis}}</td>
                            <td>{{$item->nm_pasien}}</td>
                            <td>{{$item->kd_jenis_prw}}</td>
                            <td>{{$item->nm_perawatan}}</td>
                            <td>{{$item->nip}}</td>
                            <td>{{$item->nama}}</td>
                            <td>{{$item->tgl_perawatan}}</td>
                            <td>{{$item->jam_rawat}}</td>
                            <td>{{$item->png_jawab}}</td>
                            <td>{{$item->nm_poli}}</td>
                            <td>{{$item->material}}</td>
                            <td>{{$item->bhp}}</td>
                            <td>{{$item->tarif_tindakanpr}}</td>
                            <td>{{$item->kso}}</td>
                            <td>{{$item->menejemen}}</td>
                            <td>{{$item->biaya_rawat}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

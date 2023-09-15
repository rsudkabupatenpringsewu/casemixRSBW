@extends('..layout.layoutDashboard')
@section('title', 'Pasein Rawat Inap')

@section('konten')
    <div class="row">
        <div class="col-md-12 card">
            <label for="" class="label mt-3">Cari berdasarkan tanggal pulang</label>
            <form action="{{ url('/cari-list-pasein-ranap') }}" action="POST">
                @csrf
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <input type="date" name="tgl1" class="form-control form-control-xs"
                                    value="{{ request('tgl1', now()->format('Y-m-d')) }}">
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <input type="date" name="tgl2" class="form-control form-control-xs"
                                    value="{{ request('tgl2', now()->format('Y-m-d')) }}">
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-md btn-primary">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="card">
                <div class="card-header">
                    @php
                        $penjab = $penjamnin === 'BPJ' ? 'BPJS' : '';
                    @endphp
                    <h3 class="card-title">List Pasien <b>{{ $penjab }}</b> Berdasarkan Tanggal Pulang, Dari Tanggal: <b>{{ date('d/m/Y', strtotime( $tanggl1)) }}</b>
                        sampai <b>{{ date('d/m/Y', strtotime( $tanggl2)) }} Rawat Inap</b></h3>
                </div>
                <table class="card-body table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>RM</th>
                            <th>No.Rawat</th>
                            <th>No.Sep</th>
                            <th>Pasein</th>
                            <th>Bayar</th>
                            <th>Asal</th>
                            <th>Tgl Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarPasien as $item)
                            <tr>
                                @php
                                    $matchingBerks = $downloadBerkas->where('no_rawat', $item->no_rawat);
                                    $matchingBerksInacbg = $cekTerkirimInacbg->where('no_sep', $item->no_sep);
                                @endphp
                                <td class="text-center">
                                    @if ($matchingBerks->isNotEmpty())
                                        @foreach ($matchingBerks as $berks)
                                            <a href="{{ url('hasil_pdf/' . $berks->file) }}" download class="text-success">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endforeach
                                    @else
                                        <form action="{{ url('casemix-home-cari') }}" method="">
                                            @csrf
                                            <input name="cariNorawat" value="{{ $item->no_sep }}" hidden>
                                            <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                                            <button class="" style="background: none; border: none;">
                                                <i class="nav-icon fas fa-receipt"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                                <td>{{ $item->no_rkm_medis }}</td>
                                <td>{{ $item->no_rawat }}</td>
                                <td>{{ $item->no_sep }}</td>
                                <td>
                                    {{ $item->nm_pasien }} &nbsp;
                                    @if ($matchingBerksInacbg->isNotEmpty())
                                        <span class="text-success"><i class="fas fa-check"></i></span>
                                    @else
                                        <span class="text-danger"><i class="fas fa-pen-nib"></i></span>
                                    @endif
                                </td>
                                <td>{{ $item->status_bayar }}</td>
                                <td>{{ $item->nm_poli }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->tgl_masuk)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
@endsection

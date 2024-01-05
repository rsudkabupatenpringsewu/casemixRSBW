@extends('..layout.layoutDashboard')
@section('title', 'Pasein Rawat Inap')

@section('konten')
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="nav-icon fas fa-receipt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Total List Pasien</b></span>
                    <span class="info-box-number">
                        <h4>{{ $daftarPasien->count() }}</h4>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-check"></i></i></span>
                <div class="info-box-content">
                    <span class="info-box-text"><b>Total Yang Sudah Terbundling</b></span>
                    <span class="info-box-number">
                        <h4>
                            {{ $daftarPasien->flatMap->getAllBerkas->count()}}
                        </h4>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-pen-nib"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text"><b>Total Yang Belum Terbundling</b></span>
                    <span class="info-box-number">
                        <h4>
                            {{ abs($daftarPasien->flatMap->getAllBerkas->count() - $daftarPasien->count()) }}
                        </h4>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-12 card">
            <label for="" class="label mt-2">Cari berdasarkan tanggal pulang</label>
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
                    <h3 class="card-title">List Pasien <b>{{ $penjab }}</b> Berdasarkan <b>Tanggal Pulang</b>, Dari Tanggal:
                        <b>{{ date('d/m/Y', strtotime($tanggl1)) }}</b>
                        sampai <b>{{ date('d/m/Y', strtotime($tanggl2)) }} Rawat Inap</b>
                    </h3>
                </div>
                <table class="card-body table table-bordered table-hover">
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
                            <th>Act</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($daftarPasien as $key => $item)
                           @php
                               $colortr = $item->jnspelayanan == '1' ? '' : 'text-danger';
                           @endphp
                            <tr class="{{$colortr}} color-palette">
                                <td class="text-center">
                                    @forelse ($item->getAllBerkas->where('jenis_berkas', 'HASIL') as $berkas)
                                        <a href="{{ url('hasil_pdf/' . $berkas->file) }}" download class="text-success">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    @empty
                                        <form action="{{ url('casemix-home-cari') }}" method="">
                                            @csrf
                                            <input name="cariNorawat" value="{{ $item->no_sep }}" hidden>
                                            <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                                            <button type="submit" style="background: none; border: none;">
                                                <i class="nav-icon fas fa-receipt"></i>
                                            </button>
                                        </form>
                                    @endforelse
                                </td>
                                <td>{{ $item->no_rkm_medis }}</td>
                                <td>{{ $item->no_rawat }}</td>
                                <td>{{ $item->no_sep }}</td>
                                <td>{{ $item->nm_pasien }}</td>
                                <td class="text-center">
                                    @if ($item->status_bayar === 'Sudah Bayar')
                                        <a href="#" class="" data-toggle="tooltip" data-placement="top"
                                            title="Sudah Bayar" style="color: inherit;">
                                            <i class="text-success nav-icon fas fa-check"></i>
                                        </a>
                                    @else
                                        <a class="" href="#" data-toggle="tooltip" data-placement="top"
                                            title="Belum Bayar" style="color: inherit;">
                                            <i class="nav-icon fas fa-dollar-sign"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $item->nm_poli }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->tgl_masuk)) }}</td>
                                {{-- <td>
                                    <div class="badge-group d-flex justify-content-around text-default">
                                        <a data-toggle="modal" data-target="#updateModal{{ $key }}"
                                            href="#"><i class="fas fa-folder"></i></a>
                                    </div>
                                    <div class="modal fade" id="updateModal{{ $key }}" tabindex="-1"
                                        role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <b>{{ $item->nm_pasien }}</b>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body justify-content-between">
                                                    <table class="card-body table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>Jenis Berkas</th>
                                                                <th>Download</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if ($item->getAllBerkas)
                                                                @foreach ($item->getAllBerkas as $berkas)
                                                                    @php
                                                                        switch ($berkas->jenis_berkas) {
                                                                            case 'INACBG':
                                                                                $jenis_berkas = 'Berkas INACBG';
                                                                                $link_download = 'storage/file_inacbg/';
                                                                                break;
                                                                            case 'SCAN':
                                                                                $jenis_berkas = 'Berkas Scan Casemix';
                                                                                $link_download = 'storage/file_scan/';
                                                                                break;
                                                                            case 'RESUMEDLL':
                                                                                $jenis_berkas = 'Berkas Keluaran Khanza';
                                                                                $link_download = 'storage/resume_dll/';
                                                                                break;
                                                                            case 'HASIL':
                                                                                $jenis_berkas = 'Berkas Yang Sudah Digabungkan';
                                                                                $link_download = 'hasil_pdf/';
                                                                                break;
                                                                            default:
                                                                                $jenis_berkas = '';
                                                                                $link_download = '';
                                                                                break;
                                                                        }
                                                                    @endphp
                                                                    <tr>
                                                                        <td>{{ $jenis_berkas }}</td>
                                                                        <td width="50px" class="text-center"><a
                                                                                href="{{ url($link_download . $berkas->file) }}"
                                                                                download class="text-primary">
                                                                                <i class="fas fa-download"></i>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

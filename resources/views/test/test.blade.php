@extends('..layout.layoutDashboard')
@section('title', 'Casemix Bpjs')

@section('konten')
    <form action="{{ url('/test-cari') }}" action="">
        @csrf
        <div class="row">
            <div class="col-md-2">
                <div class="input-group">
                    <select class="form-control" name="kelasKamar" id="">
                        @foreach ($kelasKamar as $item)
                            <option>{{$item->kelas}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="input-group">
                    <select class="form-control" name="penjab" id="">
                            <option>BPJS</option>
                            <option>NON BPJS</option>
                    </select>
                </div>
            </div>
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
    <table class="table border">
        <thead>
            <tr>
                <th>No Rawat</th>
                <th>nm_pasien</th>
                <th>kelas</th>
                <th>kd_pj</th>
                <th>png_jawab</th>
                <th>trf_kamar</th>
                <th>alamat</th>
                <th>tgl_masuk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cariKelas as $item)
                <tr>
                    <td scope="row">{{ $item->no_rawat }}</td>
                    <td scope="row">{{ $item->nm_pasien }}</td>
                    <td scope="row">{{ $item->kelas }}</td>
                    <td scope="row">{{ $item->kd_pj }}</td>
                    <td scope="row">{{ $item->png_jawab }}</td>
                    <td scope="row">{{ $item->trf_kamar }}</td>
                    <td scope="row">{{ $item->alamat }}</td>
                    <td scope="row">{{ $item->tgl_masuk }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

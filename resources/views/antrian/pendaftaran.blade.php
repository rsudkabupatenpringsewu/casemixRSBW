@extends('..layout.layoutDashboard')
@section('title', 'Pendaftaran')

@section('konten')
    <table class="table">
        <thead>
            <tr>
                <th>KODE</th>
                <th>NAMA</th>
                <th>LIHAT LOKET</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Pendaftaran as $item)
                <tr>
                    <td>{{$item->kd_pendaftaran}}</td>
                    <td>{{$item->nama_pendaftaran}}</td>
                    <td>
                        <form action="{{ url('cari-loket') }}" method="">
                            @csrf
                            <input name="KdPendaftaran" value="{{ $item->kd_pendaftaran }}" hidden>
                            <button class="" style="background: none; border: none;">
                                <i class="nav-icon fas fa-search"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

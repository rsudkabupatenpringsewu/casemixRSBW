@extends('..layout.layoutDashboard')
@section('title', 'Bayar Piutang')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="card">
        <div class="card-body">
            <table class="table table-sm table-bordered table-striped table-responsive mb-3" style="white-space: nowrap;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>No. Rekam Medis</th>
                        <th>No. Rawat</th>
                        <th>Nama Pasien</th>
                        <th>Jenis Berkas</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($result as $row)
                        <tr>
                            <td>{{ $row->id }}</td>
                            <td>{{ $row->no_rkm_medis }}</td>
                            <td>{{ $row->no_rawat }}</td>
                            <td>{{ $row->nama_pasein }}</td>
                            <td>{{ $row->jenis_berkas }}</td>
                            <td>{{ $row->file }}</td>
                            <td>{{ $row->file }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <nav aria-label="Page navigation example">
                {{ $result->appends(request()->input())->links('pagination::bootstrap-4') }}
            </nav>
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush

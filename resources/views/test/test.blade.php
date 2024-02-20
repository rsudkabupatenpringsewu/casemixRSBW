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
                        <th>nm_penyakit</th>
                        <th>Dokter Yang Menangani</th>
                        <th>Jumlah Pasien</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($getPenyakit as $item)
                        <tr>
                            <td>{{ $item->nm_penyakit }}</td>
                            <td>
                                <table class="table table-xs" style="white-space: nowrap;">
                                    <tbody>
                                        <tr>
                                            <td>Dokter</td>
                                            <td>nm_dokter</td>
                                            <td>Jumlah</td>
                                        </tr>
                                        @foreach ($item->getDokter as $detail)
                                        <tr>
                                            <td>{{ $detail->kd_dokter }}</td>
                                            <td>{{ $detail->nm_dokter }}</td>
                                            <td>{{ $detail->Jumlah_yang_menangani_penyakit }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td>{{ $item->Jumlah }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush

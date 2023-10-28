@extends('..layout.layoutDashboard')
@section('title', 'TESTING')

@section('konten')
    @include('test.component.form-search')
    {{-- OUTPUT --}}
    @if ($penjamin)
        @foreach ($penjamin as $item)
            <table>
                <tr>
                    <td>
                        {{ $item->png_jawab }}
                    </td>
                </tr>
            </table>
        @endforeach
    @endif

    <table class="table table-responsive">
        <tbody>
            <tr>
                <td>no_rawat</td>
                <td>no_nota</td>
                <td>no_rkm_medis</td>
                <td>nm_pasien</td>
                <td>nm_poli</td>
                <td>Registrasi</td>
                <td>Obat+Emb+Tsl</td>
                <td>nm_dokter</td>
            </tr>

            @foreach ($paymentRalan as $item)
                <tr>
                    <td>{{ $item->no_rawat }}</td>
                    <td>
                        @foreach ($item->getNomorNota as $detail)
                            {{ $detail->no_nota }}
                        @endforeach
                    </td>
                    <td>{{ $item->no_rkm_medis }}</td>
                    <td>{{ $item->nm_pasien }}</td>
                    <td>{{ $item->nm_poli }}</td>
                    <td>
                        {{ $item->getRegistrasi->sum('totalbiaya') }}
                    </td>
                    <td>
                        {{ $item->getObat->sum('totalbiaya') }}
                    </td>
                    <td>{{ $item->nm_dokter }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

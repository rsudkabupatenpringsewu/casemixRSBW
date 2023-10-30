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

    <table class="table table-responsive text-xs" style="white-space: nowrap;">
        <tbody>
            <tr>
                <th>no_rawat</th>
                <th>no_nota</th>
                <th>no_rkm_medis</th>
                <th>nm_pasien</th>
                <th>nm_poli</th>
                <th>Registrasi</th>
                <th>Obat+Emb+Tsl</th>
                <th>Paket Tindakan</th>
                <th>Operasi</th>
                <th>Laborat</th>
                <th>Radiologi</th>
                <th>Tambahan</th>
                <th>Potongan</th>
                <th>Total</th>
                <th>nm_dokter</th>
                <th>nm_dokter</th>
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
                    <td>
                        {{ $item->getRalanDokter->sum('totalbiaya') +
                            $item->getRalanParamedis->sum('totalbiaya') +
                            $item->getRalanDrParamedis->sum('totalbiaya') }}
                    </td>
                    <td>
                        {{ $item->getOprasi->sum('totalbiaya') }}
                    </td>
                    <td>
                        {{ $item->getLaborat->sum('totalbiaya') }}
                    </td>
                    <td>
                        {{ $item->getRadiologi->sum('totalbiaya') }}
                    </td>
                    <td>
                        {{ $item->getTambahan->sum('totalbiaya') }}
                    </td>
                    <td>
                        {{ $item->getPotongan->sum('totalbiaya') }}
                    </td>
                    <td>
                        {{-- TOTAL --}}
                        {{ $item->getRegistrasi->sum('totalbiaya') +
                            $item->getObat->sum('totalbiaya') +
                            $item->getRalanDokter->sum('totalbiaya') +
                            $item->getRalanParamedis->sum('totalbiaya') +
                            $item->getRalanDrParamedis->sum('totalbiaya') +
                            $item->getOprasi->sum('totalbiaya') +
                            $item->getLaborat->sum('totalbiaya') +
                            $item->getRadiologi->sum('totalbiaya') +
                            $item->getTambahan->sum('totalbiaya') +
                            $item->getPotongan->sum('totalbiaya') }}
                    </td>
                    <td>{{ $item->nm_dokter }}</td>
                    <td>{{ $item->status_bayar }}</td>
                </tr>
            @endforeach
            <tr class="font-weight-bold">
                <td colspan="5">Total</td>
                <td>
                    {{ $paymentRalan->sum(function ($item) {
                        return $item->getRegistrasi->sum('totalbiaya');
                    }) }}
                </td>
                <td>
                    {{ $paymentRalan->sum(function ($item) {
                        return $item->getObat->sum('totalbiaya');
                    }) }}
                </td>
                <td>
                    {{ $paymentRalan->sum(function ($item) {
                        return $item->getRalanDokter->sum('totalbiaya') +
                            $item->getRalanParamedis->sum('totalbiaya') +
                            $item->getRalanDrParamedis->sum('totalbiaya');
                    }) }}
                </td>
                <td>
                    {{ $paymentRalan->sum(function ($item) {
                        return $item->getOprasi->sum('totalbiaya');
                    }) }}
                </td>
                <td>
                    {{ $paymentRalan->sum(function ($item) {
                        return $item->getLaborat->sum('totalbiaya');
                    }) }}
                </td>
                <td>
                    {{ $paymentRalan->sum(function ($item) {
                        return $item->getRadiologi->sum('totalbiaya');
                    }) }}
                </td>
                <td>
                    {{ $paymentRalan->sum(function ($item) {
                        return $item->getTambahan->sum('totalbiaya');
                    }) }}
                </td>
                <td>
                    {{ $paymentRalan->sum(function ($item) {
                        return $item->getPotongan->sum('totalbiaya');
                    }) }}
                </td>
                <td>
                    {{ $paymentRalan->sum(function ($item) {
                        return $item->getRegistrasi->sum('totalbiaya') +
                            $item->getObat->sum('totalbiaya') +
                            $item->getRalanDokter->sum('totalbiaya') +
                            $item->getRalanParamedis->sum('totalbiaya') +
                            $item->getRalanDrParamedis->sum('totalbiaya') +
                            $item->getOprasi->sum('totalbiaya') +
                            $item->getLaborat->sum('totalbiaya') +
                            $item->getRadiologi->sum('totalbiaya') +
                            $item->getTambahan->sum('totalbiaya') +
                            $item->getPotongan->sum('totalbiaya');
                    }) }}
                </td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>
@endsection

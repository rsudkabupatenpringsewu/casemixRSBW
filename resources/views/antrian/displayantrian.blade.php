@extends('layout.layoutpendaftaran')
@section('title', 'PENDAFTARAN 1')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="d-flex justify-content-between align-items-center container-fluid mt-3">
        <img src="/img/rs.png" width="140px" height="110px" alt="" srcset="">
        <div class="pricing-header ">
            <h1 class="display-4 font-weight-bold">Antrian Sidik Jari BPJS</h1>
        </div>
        <img src="/img/bpjs.png" width="280px" height="50px" alt="" srcset="">
    </div>
    <hr>
    @livewire('antrian-pendaftaran.display-antrian')

@endsection
@push('scripts')
    @livewireScripts
@endpush

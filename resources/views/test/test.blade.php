@extends('..layout.layoutDashboard')
@section('title', 'Bayar Piutang')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="card">
        <div class="card-body">
            @livewire('laporan.bayar-piutang')
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush

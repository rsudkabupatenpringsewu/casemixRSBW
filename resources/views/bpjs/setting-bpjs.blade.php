@extends('..layout.layoutDashboard')
@section('title', 'List File Bundling')
@push('styles')
    @livewireStyles
@endpush
@section('konten')
    <div class="card">
        <div class="card-body">
            @livewire('bpjs.setting-bpjs')
        </div>
    </div>
@endsection
@push('scripts')
    @livewireScripts
@endpush

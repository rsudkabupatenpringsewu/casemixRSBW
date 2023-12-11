@extends('..layout.layoutDashboard')
@section('title', 'Loket')

@section('konten')
    @php
        $md = count($getLoket) > 2 ? 4 : 6;
    @endphp
    <div class="container mt-4">
        <div class="row">
            @foreach ($getLoket as $item)
                <div class="col-md-{{ $md }} mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="card-">{{ $item->nama_loket }}</h1>
                            @foreach ($item->getDokter as $item)
                                @foreach ($item->getPasien as $item)
                                    <p class="card-text">
                                        {{ $item->no_reg }}. {{ $item->nm_pasien }}
                                    </p>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@extends('..layout.layoutDashboard')
@section('title', 'Farmasi')

@section('konten')
    <div class="row">
        @include('farmasi.component.upload-berkas-farmasi')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Berkas Khanza</h3>
                </div>
                <div class="card-body">
                    @if ($jumlahData > 0)
                        <div class="card-body">
                            <form action="{{ url('/print-sep-resep') }}" method="">
                                @csrf
                                <input name="cariNoRawat" value="{{ $noRawat }}" hidden>
                                <input name="cariNoSep" value="{{ $noSep }}" hidden>
                                <button type="submit" class="btn btn-success float-right">
                                    <i class="fas fa-save"> Save pdf</i>
                                </button>
                            </form>
                        </div>
                        {{-- BERKAS SEP ============================================================= --}}
                        @if ($getSEP)
                            @include('farmasi.component.berkas-sep')
                        @else
                            {{-- NULL --}}
                        @endif

                        {{-- BERKAS FARMASI (RESEP) --}}
                        @if ($berkasResep)
                            @include('farmasi.component.berkas-resep')
                        @else
                            {{-- NULL --}}
                        @endif
                        {{-- ERROR HANDLING ============================================================= --}}
                    @else
                        <div class="card-body">
                            <div class="card p-4 d-flex justify-content-center align-items-center">

                            </div>
                        </div>
                    @endif
                    <div class="card-footer">
                        <div class="row">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

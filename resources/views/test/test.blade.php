@extends('..layout.layoutDashboard')
@section('title', 'Casemix Bpjs')

@section('konten')

{{-- RADIOLOGIIII TESSSSSSSSSSSSSS --}}
    {{-- @foreach ($getLaborat as $periksa)
        <p>No Rawat: {{ $periksa->no_rawat }}</p>
        <p>No Rekam Medis: {{ $periksa->no_rkm_medis }}</p>
        <p>Nama Pasien: {{ $periksa->nm_pasien }}</p>
        <p>Tgl Periksa: {{ $periksa->tgl_periksa }}</p>
        <p>Jam: {{ $periksa->jam }}</p>

        @foreach ($periksa->getPeriksaLab as $perawatan)
            <p>Kode Jenis Perawatan: {{ $perawatan->kd_jenis_prw }}</p>
            <p>Nama Perawatan: {{ $perawatan->nm_perawatan }}</p>

            @foreach ($perawatan->getDetailLab as $detail)
                <p> Pemeriksaan: {{ $detail->Pemeriksaan }} = {{ $detail->nilai }}</p>
            @endforeach
        @endforeach
        <hr>
    @endforeach --}}



{{-- HOMECASEMIX --}}

<div class="row">
    @foreach ($getPasien as $item)
        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
            <div class="card bg-light d-flex flex-fill">
                <div class="card-header text-muted border-bottom-0">
                    Pasein
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-7">
                            <h4 class="lead"><b>{{ $item->nm_pasien }}</b></h4>
                            <p class="text-muted text-sm"><b> {{ $item->no_rkm_medis }}</b> </p>
                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                <li class="small"><span class="fa-li">
                                        <i class="fas fa-lg fa-building"></i></span>
                                    Alamat : {{ $item->alamat }}
                                </li>
                                <li class="small mt-2"><span class="fa-li">
                                        <i class="fas fa-lg fa-phone"></i></span>
                                    Telp : {{ $item->no_tlp }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-center">
                    @if(isset($cekBerkas[$item->no_rawat]))
                        @php $color = 'bg-success'; @endphp
                    @else
                        @php $color = 'bg-primary'; @endphp
                    @endif
                    <form action="{{url('cariNorawat-ClaimBpjs')}}" method="">
                    @csrf
                        <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                        <button href="#" class="btn btn-sm {{$color}}" target="">
                            <i class="fas fa-upload"> File Scan</i>
                        </button>
                    </form>
                    <form action="{{url('carinorawat-casemix')}}" method="" class="mx-2">
                    @csrf
                        <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                        <button href="#" class="btn btn-sm bg-primary">
                            <i class="fas fa-save"> Berkas Khanza</i>
                        </button>
                    </form>
                    <form action="{{url('test-cari')}}" method="" class="mx-2">
                    @csrf
                        <input name="cariNorawat" value="{{ $item->no_rawat }}" hidden>
                        <button href="#" class="btn btn-sm bg-primary">
                            <i class="fas fa-save"> Gabungkan</i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection

<div>
    <div class="mt-4 container-fluid">
        <div class="row justify-content-center">
            @foreach ($getPoli as $item)
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header text-center bg-success">
                            <h2 class="my-0"><a class="link " href="">
                                    <h1 class="font-weight-bold text-white">{{ $item->nama_ruang_poli }}</h1>
                                </a></h2>
                        </div>
                        <table class="table font-weight-bold">
                            @if ($item->getPasien->isEmpty())
                                <div class="container d-flex justify-content-center align-items-center"
                                    style="height: 300px">
                                    <h1 class="font-weight-bold">Tidak Ada Antrian</h1>
                                </div>
                            @else
                                @foreach ($item->getPasien as $item)
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">
                                                <h3 class="font-weight-bold">Nomor Registrasi</h3>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="text-center display-2 font-weight-bold">
                                                {{ $item->nama_dokter }}
                                            </th>
                                        </tr>
                                        <tr>
                                    </thead>
                                @endforeach
                            @endif
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

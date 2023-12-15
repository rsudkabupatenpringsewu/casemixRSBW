<div>
    <div class="mt-4">
        <div class="row justify-content-center" wire:poll.1000ms>
            @php
                $md = count($getLoket) > 2 ? 4 : 6;
            @endphp
            @foreach ($getLoket as $item)
                <div class="col-md-{{ $md }} mb-4">
                    <div class="card">
                        <div class="card-header text-center bg-success">
                            <h2 class="my-0"><a class="link " href="">
                                    <h1 class="font-weight-bold text-white">{{ $item->nama_loket }}</h1>
                                </a></h2>
                        </div>
                        <table class="table font-weight-bold">
                            @foreach ($item->getPasien as $item)
                                <thead>
                                    <tr>
                                        <th colspan="3" class="text-center">
                                            <h3 class="font-weight-bold">Nomor Registrasi</h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-center display-2 font-weight-bold">
                                            {{ $item->no_reg }}</th>
                                    </tr>
                                    <tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th colspan="3" class="text-center">
                                            <h3 class="font-weight-bold">{{ $item->nm_pasien }}</h3>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-center">
                                            <h4 class="font-weight-bold">{{ $item->nama_dokter }}</h4>
                                        </th>
                                    </tr>
                                    <tr>
                                        <td class="text-center">
                                            <h3 class="font-weight-bold">Jam Mulai : {{ $item->jam_mulai }}</h3>
                                        </td>
                                    </tr>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

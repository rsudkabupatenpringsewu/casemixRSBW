<div>
    <div id="dokter">
        <div class="card-header bg-primary">
            <h4 class="card-title w-100">
                <a class="d-block w-100 text-white" data-toggle="collapse" href="#collapseDokter">
                    <i class="fas fa-plus"></i> Setting Posisi Dokter
                </a>
            </h4>
        </div>
        <div class="card-body">
            <div id="collapseDokter" class="collapse show" data-parent="#dokter">
                @if (Session::has('message'))
                    <div class="alert alert-{{ Session::get('color') }} alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <i class="icon fas fa-{{ Session::get('icon') }}"></i> {{ Session::get('message') }}!
                    </div>
                @endif
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kd Dokter</th>
                            <th>Nama</th>
                            <th class="text-center">Lokasi Dokter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($getListDokter as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->kd_dokter }}</td>
                                <td>{{ $item->nm_dokter }}</td>
                                <td class="text-center">
                                    @foreach ($getLoket as $keyLoket => $data)
                                        @php
                                            $typeBtn = $data->kd_loket == $item->kd_loket ? 'btn-primary' : 'btn-outline-primary';
                                        @endphp
                                        <button type="button" class="btn {{ $typeBtn }} btn-xs mx-1"
                                            wire:click.prevent="editLoketConfirm('{{ $item->kd_dokter }}', '{{ $item->nm_dokter }}', '{{ $data->kd_loket }}')">
                                            {{ $data->nama_loket }}
                                        </button>
                                    @endforeach
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if ($confirmingEdit)
        <div class="modal fade show" tabindex="-100" role="dialog" style="padding-right: 17px; display: block;"
            aria-modal="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4>Anda Yakin Ingin Menginput Atau Merubah posisi dokter?</h4>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" wire:click="cancelEdit()">Tidak !</button>
                            <button type="button" class="btn btn-primary" wire:click="editLoket()">Ya !</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div>
    <div class="card">
        <div class="card-body">
            <section class="content ">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <select class="form-control" name="bangsal" id="bangsal" wire:model="bangsal">
                                    <option value="DepRI">Depo Rawat Inap</option>
                                    <option value="DepRJ">Depo Rawat Jalan</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <div class="input-group-append">
                                    <button wire:click="render" class="btn btn-md btn-primary">
                                        <span>
                                            <span wire:loading.remove>
                                                <i class="fa fa-search"></i>
                                            </span>
                                            <span wire:loading>
                                                <span class="spinner-grow spinner-grow-sm" role="status"
                                                    aria-hidden="true"></span> Mencari...
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 10px">No</th>
                        <th>Kd Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok Tersedia</th>
                        <th contenteditable="true">Stok Minimal</th>
                        <th>Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $listObat = $getListObat->sortByDesc(function($item) {
                            return $item->stok < $item->stok_minimal_medis;
                        });
                        $counter = 1;
                    @endphp
                    @foreach ($listObat as $key => $item)
                        @php
                            $color_tr = $item->stok < $item->stok_minimal_medis ? 'bg-danger' : '';
                        @endphp
                        <tr>
                            <td class="{{ $color_tr }}">{{$counter++}}</td>
                            <td>{{ $item->kode_brng }}</td>
                            <td>{{ $item->nama_brng }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>
                                {{ $item->stok_minimal_medis }}
                                <div class="badge-group-sm float-right">
                                    <a data-toggle="modal" data-target="#updateModal{{ $item->kode_brng }}"
                                       class="text-xs" href="#"><i class="fas fa-edit"></i></a>
                                </div>
                                <div class="modal fade" id="updateModal{{ $item->kode_brng }}" tabindex="-1"
                                    role="dialog" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="updateModalLabel{{ $key }}">Edit
                                                    Stok Minimal Barang <b>{{ $item->kode_brng }}</b></h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input wire:model.defer="stok_minimal_medis" type="number"
                                                    class="form-control" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    wire:click="update('{{ $item->kode_brng }}')"
                                                    data-dismiss="modal">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $item->satuan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

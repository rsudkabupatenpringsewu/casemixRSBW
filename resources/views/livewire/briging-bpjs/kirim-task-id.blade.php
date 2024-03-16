<div>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Cekin / Kirim TaskId</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row mt-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <input type="test" class="form-control" wire:model.lazy="kodebooking">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <select class="form-control" wire:model.lazy="taskid">
                            <option selected>Pilih task id</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="date" class="form-control" wire:model.lazy="date">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <input type="time" class="form-control"wire:model.lazy="time">
                        {{ $time }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" wire:click="cekinBPJS()">Submit</button>
                    </div>
                </div>
            </div>
            <div class="row">
                @if ($getCekin)
                    @foreach ($getCekin as $item)
                        @if (is_object($item))
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    @if ($item->code == 200)
                                        <sapan class="text-success">Terkirim !</sapan><br>
                                    @else
                                        <sapan class="text-danger">Gagal !</sapan><br>
                                    @endif
                                </li>
                                <li class="list-group-item">code : {{ $item->code }}</li>
                                <li class="list-group-item">status : {{ $item->message }}</li>
                            </ul>
                        @endif
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

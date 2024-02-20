@extends('..layout.layoutDashboard')
@section('title', 'Keperawatan')
@section('konten')
    <div class="card">
        <div class="card-body">
            <form action="{{ url('/laporan-logbook-keperawatan') }}">
                @csrf
                <div class="row">
                    <div class="col-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <button type="button"
                                    class="btn btn-default form-control form-control-xs d-flex justify-content-between"
                                    data-toggle="modal" data-target="#modal-lg2">
                                    <p>Pilih Petugas</p>
                                    <p><i class="nav-icon fas fa-user-nurse"></i></p>
                                </button>
                            </div>
                            <div class="modal fade" id="modal-lg2">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Pilih Petugas</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <select multiple="multiple" size="10" name="duallistbox2[]">
                                                @foreach ($petugas as $item)
                                                    <option value="{{ $item->nip }}">{{ $item->nama }}</option>
                                                @endforeach
                                            </select>
                                            <input type="hidden" name="kdPetugas">
                                            <script>
                                                var demo1 = $('select[name="duallistbox2[]"]').bootstrapDualListbox();
                                                $('form').submit(function(e) {
                                                    e.preventDefault();
                                                    $('input[name="kdPetugas"]').val($('select[name="duallistbox2[]"]').val().join(','));
                                                    this.submit();
                                                });
                                            </script>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <input type="date" name="tgl1" class="form-control form-control-xs"
                                    value="{{ request('tgl1', now()->format('Y-m-d')) }}">
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <input type="date" name="tgl2" class="form-control form-control-xs"
                                    value="{{ request('tgl2', now()->format('Y-m-d')) }}">
                                <div class="input-group-append">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="input-group input-group-xs">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-md btn-primary">
                                        <i class="fa fa-search"></i> Cari
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <table class="table table-bordered" id="tableToCopy">
                <thead>
                    <tr>
                        <th width="100px">No. </th>
                        <th width="200px">No. Rekam Medis</th>
                        <th class="text-center">Log Book Kegiatan {{$getPetugas->nama}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($getPasien as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->no_rkm_medis }}</td>
                            <td class="p-0">
                                <table class="table table-sm table-hover text-xs" id="tableToCopy">
                                    <thead>
                                        <tr>
                                            <th colspan="4" class="text-center">{{ $item->tanggal }}</th>
                                        </tr>
                                        <tr>
                                            <th width="100px">Kode Kegiatan</th>
                                            <th>Nama Kegiatan</th>
                                            <th width="100px" class="text-center">Mandiri</th>
                                            <th width="100px" class="text-center">Dibawah_Supervisi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($item->getLogPerawat as $data)
                                            <tr>
                                                <td>{{ $data->kd_kegiatan }}</td>
                                                <td>{{ $data->nama_kegiatan }}</td>
                                                <td class="text-center">
                                                    @if ($data->mandiri == 1)
                                                        <i class="fas fa-check"></i>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($data->supervisi == 1)
                                                        <i class="fas fa-check"></i>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
            </table>
        </div>
    </div>
@endsection

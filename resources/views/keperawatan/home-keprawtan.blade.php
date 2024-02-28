@extends('..layout.layoutDashboard')
@section('title', 'Menu Keperawatan')
@section('konten')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Menu</h3>
                </div>
                <div class="card-body p-3">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>1</h3>
                                        <h5>Input Tindakan Keperawatan Dasar</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="nav-icon fas fa-user-nurse"></i>
                                    </div>
                                    <a href="{{ url('logbook-keperawatan') }}" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>2</sup></h3>
                                        <h5>Kewenangan Khusus Keperawatan</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="nav-icon fas fa-hospital-user"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                            <div class="col-lg-4 col-6">
                                <div class="small-box bg-primary">
                                    <div class="inner">
                                        <h3>3</h3>
                                        <h5>Input Pelaksanaan Kegiatan Lain</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="nav-icon fas fa-file-medical"></i>
                                    </div>
                                    <a href="#" class="small-box-footer">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

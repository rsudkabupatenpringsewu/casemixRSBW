<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>RSBW | @yield('title')</title>
    <link rel="icon" href="/img/rs.ico" type="image/x-icon">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
    <link rel="stylesheet" href="/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css" />
    <link rel="stylesheet" href="/dist/css/adminlte.min.css" />
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css" />
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css" />
    <script src="/js/plotly-latest.min.js"></script> {{-- CHART  --}}
    <script src="/plugins/jquery/jquery.min.js"></script>
    {{-- DUALIS --}}
    <link rel="stylesheet" href="/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
    <script src="/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    {{-- TEST --}}
    <style>
        u {
            border-bottom: 2px solid black;
            /* Ketebalan garis bawah */
            text-decoration: none;
            /* Menghilangkan garis bawah default */
            display: inline-block;
            /* Membuat elemen menjadi blok inline */
            position: relative;
        }
    </style>
    @stack('styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @php
            $getSeting = DB::table('setting')->select('setting.nama_instansi', 'setting.logo')->first();
        @endphp
        <!-- Preloader -->
        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="/img/rs.png" height="50" width="60" />
        </div> --}}

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Navbar Search -->

                <li class="nav-item dropdown">
                    <a class="nav-link text-lg" data-toggle="dropdown" href="#">
                        <i class="far fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" tabindex="-1" href="#">Action</a>
                        <a class="dropdown-item" tabindex="-1" href="#">Another action</a>
                        <a class="dropdown-item" tabindex="-1" href="#">Something else here</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" tabindex="-1" href="{{ route('logout') }}">
                            <i class='fas fa-sign-out-alt'></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- INI MENUUU SAMPING -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link">
                <img src="data:image/png;base64,{{ base64_encode($getSeting->logo) }}" alt="Logo"
                    class="brand-image img-circle elevation-3" style="opacity: 0.8" />
                <span class="brand-text font-weight-light">{{ $getSeting->nama_instansi }}</span>
            </a>

            <!-- INI MENUUU SAMPING -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/img/user.jpg" class="img-circle elevation-2" alt="User Image" />
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">
                            @if (session()->has('user'))
                                @php
                                    $auth = session('user');
                                @endphp
                                {{ $auth->nama }}
                            @endif
                        </a>
                    </div>
                </div>
                <nav class="mt-2 sidebar-nav">
                    <ul id="sidebarnav" class="nav nav-pills nav-sidebar flex-column" data-widget="treeview"
                        role="menu" data-accordion="false">
                        {{-- MENU HOME --}}
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Home
                                    {{-- <span class="right badge badge-danger">New</span> --}}
                                </p>
                            </a>
                        </li>
                        {{-- MENU KEUANGAN --}}
                        <li class="nav-header user-panel"></li>
                        <li class="nav-header">Transaksi</li>
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-credit-card"></i>
                                <p>
                                    Keuangan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/returObat') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Retur Obat</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/pembayaran-ralan') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Pembayaran Ralan</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/piutang-ralan') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Piutang Ralan</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/cari-bayar-piutang') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bayar Piutang</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/cari-bayar-umum') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Bayar Umum</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- MENU DETAIL TINDAKAN --}}
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-hospital-user"></i>
                                <p class="class="btn btn-app">
                                    Detail Tindakan <span class="text-xs">(Asuransi)</span>
                                </p>
                                <i class="right fas fa-angle-left"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ralan-dokter') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ralan Dokter</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ralan-paramedis') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ralan Paramedis</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ralan-dokter-paramedis') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ralan Dokter Paramedis</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/operasi-and-vk') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Operasi & VK</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ranap-dokter') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ranap Dokter</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ranap-paramedis') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ranap Paramedis</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ranap-dokter-paramedis') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ranap Dokter Paramedis</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/periksa-radiologi') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Periksa Radiologi</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- DETAIL TINDAKAN UMUM --}}
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-hospital-user"></i>
                                <p class="class="btn btn-app">
                                    Detail Tindakan <span class="text-xs">(Umum)</span>
                                </p>
                                <i class="right fas fa-angle-left"></i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('/ralan-dokter-umum')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ralan Dokter <span class="text-xs">(um)</span></p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{url('/ralan-paramedis-umum')}}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ralan Paramedis <span class="text-xs">(um)</span></p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ralan-dokter-paramedis-umum') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ralan Dokter Paramedis <span class="text-xs">(um)</span></p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/operasi-and-vk-umum') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Operasi & VK <span class="text-xs">(um)</span></p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ranap-dokter-umum') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ranap Dokter <span class="text-xs">(um)</span></p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ranap-paramedis-umum') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ranap Paramedis <span class="text-xs">(um)</span></p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/ranap-dokter-paramedis-umum') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ranap Dokter Paramedis <span class="text-xs">(um)</span></p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/periksa-radiologi-umum') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Periksa Radiologi <span class="text-xs">(um)</span></p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- MENU CASEMIX --}}
                        <li class="nav-header user-panel"></li>
                        <li class="nav-header">Gabung Berkas - Tools</li>
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-hospital"></i>
                                <p>
                                    Case-mix
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/list-pasein-ralan') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Pasien Ralan</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/list-pasein-ralan2') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Pasien Ralan 2</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/list-pasein-ranap') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Pasien Ranap</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/data-inacbg') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Inacbg</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('/casemix-home') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Gabung Berkas</p>
                                    </a>
                                </li>
                            </ul>
                            @if (session('obat') === 'true')
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('/setting-bpjs-casemix') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Setting Casemix</p>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                        {{-- MENU FARMASI --}}
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-mortar-pestle"></i>
                                <p>
                                    Farmasi
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            @if (session('obat') === 'true')
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('list-pasien-farmasi') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Piutang Obat & Alkes</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('minimal-stok-obat') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Stok Minimal Obat</p>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                        {{-- MENU BRIGING BPJS--}}
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    Bridging BPJS
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('kirim-taskid-bpjs') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Cekin / Kirim TaskID
                                            <span class="badge badge-info right">dev</span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('sep-vclaim') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>
                                            Sep V-Claim
                                            <span class="badge badge-info right">dev</span>
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header user-panel"></li>
                        <li class="nav-header">Pelayanan - RM</li>
                        {{-- MENU ANTRIAN --}}
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-user"></i>
                                <p>
                                    Antrian Loket
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('antrian-pendaftaran') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Pendaftaran</p>
                                    </a>
                                </li>
                            </ul>
                            @if (session('edit_registrasi') === 'true')
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('setting-antrian') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Setting Antrian</p>
                                        </a>
                                    </li>
                                </ul>
                            @endif
                        </li>
                        {{-- ANTRIAN POLI --}}
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-layer-group"></i>
                                <p>
                                    Antrian Poli
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('antrian-poli') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>List Display</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('setting-antrian-poli') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Setting Poli</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('jadwal-dokter') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Jadwal Dokter</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- MENU RM --}}
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-file"></i>
                                <p>
                                    E-Rekam Medis
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('berkas-rm') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Berkas Pasien BPJS</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        {{-- MENU KEPERAWATAN --}}
                        <li class="nav-item">{{-- menu-open --}}
                            <a href="#" class="nav-link">{{-- active --}}
                                <i class="nav-icon fas fa-user-nurse"></i>
                                <p>
                                    Keperawatan
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('home-keperawatan') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Kegiatan Keperawtan</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item mt-5">
                        </li>
                        <li class="nav-item mt-5">
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <!-- INI MENUUU SAMPING -->

        <!-- KONTENT UTAMA -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">@yield('title')</h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">@yield('title')</a></li>
                            </ol>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            @yield('konten')
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- KONTENT UTAMA -->

        <footer class="main-footer">
            <strong>Template &copy; By
                <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    @stack('scripts')
    <script src="/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/plugins/chart.js/Chart.min.js"></script>
    <script src="/plugins/sparklines/sparkline.js"></script>
    <script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
    <script src="/plugins/moment/moment.min.js"></script>
    <script src="/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <script src="/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <script src="/plugins/summernote/summernote-bs4.min.js"></script>
    <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <script src="/dist/js/adminlte.js"></script>
    <script src="/dist/js/pages/dashboard.js"></script>
    <script src="/js/sidebarmenu.js"></script>
    <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    {{-- DUALIST --}}
    {{-- TEST --}}


    <script>
        $(document).ready(function() {
            $('.product-image-thumb').on('click', function() {
                var $image_element = $(this).find('img')
                $('.product-image').prop('src', $image_element.attr('src'))
                $('.product-image-thumb.active').removeClass('active')
                $(this).addClass('active')
            })
        })
        $(function() {
            bsCustomFileInput.init();
        });

        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    @include('layout.component.allert')
</body>

</html>

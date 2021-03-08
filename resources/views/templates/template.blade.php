@php
$emptyProducts = \App\Models\Product::where('stock', 0)->get();
$requestProducts = \App\Models\ProductCameOut::where('status', 'Proses')->get();
$division = \App\Models\Division::findOrFail(\Auth::user()->division_id);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>SILASKAR | {{ $division->name }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    {{-- <link href="https://semantic-ui.com/dist/semantic.min.css" rel="stylesheet" /> --}}

    @yield('style')
    <style>
        html body .content-wrapper {
            background-image: url("http://silaskar.dev.com/images/LOGO-PN-AMBON-45.png");
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            /* opacity: .3; */
        }

    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-user-circle"></i>
                        {{-- <img width="32" src="https://ui-avatars.com/api/?name={{ \Auth::user()->name }}"
                            class="img-circle elevation-2" alt="User Image"> --}}
                        <span class="">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('profile') }}" class="dropdown-item">
                            <i class="fas fa-user-alt mr-2"></i> Profil
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}" class="dropdown-item">
                            <i class="fas fa-power-off mr-2"></i> Logout
                        </a>
                        <div class="dropdown-divider"></div>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ url('/') }}" class="brand-link bg-white">
                <img src="{{ asset('images/LOGO-PN-AMBON.png') }}" alt="PNA LOGO"
                    class="brand-image ml-5 img-circle elevation-3" style="opacity: 1">
                <span class="brand-text font-weight-bold">SILASKAR</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="https://ui-avatars.com/api/?background=c92434&color=fff&name={{ \Auth::user()->name }}"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info text-light">
                        <p class="mb-0">{{ Auth::user()->name }}</p>
                        <span class="badge badge-success d-block">{{ Auth::user()->division->name }}</span>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard') }}"
                                class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">DATA MASTER</li>
                        <li class="nav-item">
                            <a href="{{ route('product') }}"
                                class="nav-link {{ request()->is('product') || request()->is('product/create') || request()->is('product/*/edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Barang
                                    @if (count($emptyProducts) > 0)
                                        <span class="right badge badge-danger">{{ count($emptyProducts) }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        @if (\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2)
                            <li class="nav-item">
                                <a href="{{ route('user') }}"
                                    class="nav-link {{ request()->is('user') || request()->is('user/create') || request()->is('user/*/edit') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        User
                                    </p>
                                </a>
                            </li>
                        @endif
                        <li class="nav-header">DATA TRANSAKSI</li>
                        @if (\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2)
                            <li class="nav-item">
                                <a href="{{ route('incoming-product') }}"
                                    class="nav-link {{ request()->is('incoming-product') || request()->is('incoming-product/create') || request()->is('incoming-product/*/edit') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-arrow-down"></i>
                                    <p>
                                        Pengadaan Barang
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('product-came-out') }}"
                                    class="nav-link {{ request()->is('product-came-out') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-arrow-up"></i>
                                    {{-- <i class="nav-icon fas fa-exchange-alt fa-rotate-90"></i> --}}
                                    <p>
                                        Permintaan Barang
                                        @if (count($requestProducts) > 0)
                                            <span
                                                class="right badge badge-warning">{{ count($requestProducts) }}</span>
                                        @endif
                                    </p>
                                </a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('request-product') }}"
                                    class="nav-link {{ request()->is('request-product') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-exchange-alt fa-rotate-90"></i>
                                    <p>
                                        Pengadaan Barang

                                    </p>
                                </a>
                            </li>
                        @endif
                        @if (\Auth::user()->division_id == 1 || \Auth::user()->division_id == 2)
                            <li class="nav-header">LAPORAN</li>

                            <li class="nav-item">
                                <a href="{{ route('report-in') }}"
                                    class="nav-link {{ request()->is('report-in') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-pdf"></i>
                                    <p>
                                        Laporan Pengadaan
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('report-out') }}"
                                    class="nav-link {{ request()->is('report-out') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-file-pdf"></i>
                                    <p>
                                        Laporan Permintaan
                                    </p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"> @yield('page') </h1>
                        </div>
                        {{-- <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v2</li>
                            </ol>
                        </div><!-- /.col --> --}}
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
                <!--/. container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 <a href="https://pn-ambon.go.id/" target="_blank">Pengadilan Negeri
                    Ambon</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0.0
            </div>
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/dist/js/adminlte.js') }}"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="{{ asset('assets/dist/js/demo.js') }}"></script>

    <!-- PAGE PLUGINS -->
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>

    <!-- PAGE SCRIPTS -->

    <script src="{{ asset('assets/dist/js/pages/dashboard2.js') }}"></script>
    @yield('script')
</body>

</html>

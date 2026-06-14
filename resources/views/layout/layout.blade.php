<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>@yield('title', 'Sistem Informasi Perpustakaan')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('assets/images/favicon.png') }}">

    <link rel="stylesheet"
        href="{{ asset('assets/plugins/pg-calendar/css/pignose.calendar.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('assets/plugins/chartist/css/chartist.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css') }}">

    <link rel="stylesheet"
        href="{{ asset('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}">

    <link rel="stylesheet"
        href="{{ asset('assets/css/style.css') }}">

</head>

<body>

    <!-- Preloader -->

    <div id="preloader">

        <div class="loader">

            <svg class="circular" viewBox="25 25 50 50">

                <circle
                    class="path"
                    cx="50"
                    cy="50"
                    r="20"
                    fill="none"
                    stroke-width="3"></circle>

            </svg>

        </div>

    </div>

    <!-- Main Wrapper -->

    <div id="main-wrapper">

        <!-- NAV HEADER -->

        <div class="nav-header">

            <div class="brand-logo">

                <a href="{{ Auth::check() && Auth::user()->role == 'admin' ? route('dashboard') : route('user.dashboard') }}">

                    <b class="logo-abbr">

                        <img src="{{ asset('assets/images/logo.png') }}" alt="">

                    </b>

                    <span class="brand-title">

                        <h4 class="text-white mt-2 ml-2">

                            Perpustakaan

                        </h4>

                    </span>

                </a>

            </div>

        </div>

        <!-- HEADER -->

        <div class="header">

            <div class="header-content clearfix">

                <div class="nav-control">

                    <div class="hamburger">

                        <span class="toggle-icon">

                            <i class="icon-menu"></i>

                        </span>

                    </div>

                </div>

                @auth

                <div class="float-right mr-4 mt-3">

                    <span class="mr-3 font-weight-bold">

                        Halo,
                        {{ Auth::user()->name }}

                    </span>

                    <form
                        action="{{ route('logout') }}"
                        method="POST"
                        style="display:inline;">

                        @csrf

                        <button
                            class="btn btn-danger btn-sm">

                            Logout

                        </button>

                    </form>

                </div>

                @endauth

            </div>

        </div>

        <!-- SIDEBAR -->

        <div class="nk-sidebar">

            <div class="nk-nav-scroll">

                <ul class="metismenu" id="menu">

                    @auth

                    @if(Auth::user()->role == 'admin')

                    <!-- ADMIN -->

                    <li>

                        <a href="{{ route('dashboard') }}">

                            <i class="icon-speedometer menu-icon"></i>

                            <span class="nav-text">

                                Dashboard

                            </span>

                        </a>

                    </li>

                    <li>

                        <a class="has-arrow" href="javascript:void(0)">

                            <i class="icon-grid menu-icon"></i>

                            <span class="nav-text">

                                Master

                            </span>

                        </a>

                        <ul>

                            <li>

                                <a href="{{ route('kategori.index') }}">

                                    Data Kategori

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('buku.index') }}">

                                    Data Buku

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('anggota.index') }}">

                                    Data Anggota

                                </a>

                            </li>

                        </ul>

                    </li>

                    <li>

                        <a class="has-arrow" href="javascript:void(0)">

                            <i class="icon-book-open menu-icon"></i>

                            <span class="nav-text">

                                Transaksi

                            </span>

                        </a>

                        <ul>

                            <li>

                                <a href="{{ route('peminjaman.index') }}">

                                    Peminjaman

                                </a>

                            </li>

                            <li>

                                <a href="{{ route('pengembalian.index') }}">

                                    Pengembalian

                                </a>

                            </li>

                        </ul>

                    </li>

                    @else

                    <!-- USER -->

                    <li>

                        <a href="{{ route('user.dashboard') }}">

                            <i class="icon-speedometer menu-icon"></i>

                            <span class="nav-text">

                                Dashboard

                            </span>

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('user.buku') }}">

                            <i class="icon-book-open menu-icon"></i>

                            <span class="nav-text">

                                Daftar Buku

                            </span>

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('user.riwayat') }}">

                            <i class="icon-notebook menu-icon"></i>

                            <span class="nav-text">

                                Riwayat Peminjaman

                            </span>

                        </a>

                    </li>

                    @endif

                    @endauth

                </ul>

            </div>

        </div>

        <!-- CONTENT -->

        <div class="content-body">

            <div class="container-fluid">

                @yield('content')

            </div>

        </div>

        <!-- FOOTER -->

        <div class="footer">

            <div class="copyright">

                <p>

                    © {{ date('Y') }} Sistem Informasi Perpustakaan Mini

                </p>

            </div>

        </div>

    </div>

    <!-- JS -->

    <script src="{{ asset('assets/plugins/common/common.min.js') }}"></script>

    <script src="{{ asset('assets/js/custom.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/tables/js/jquery.dataTables.min.js') }}"></script>

    <script src="{{ asset('assets/plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>

    @yield('scripts')

</body>

</html>
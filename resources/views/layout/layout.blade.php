<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>@yield('title', 'Sistem Informasi Perpustakaan')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon_io/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon_io/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon_io/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/images/favicon_io/site.webmanifest') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon_io/favicon.ico') }}">

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

    <!-- MIDNIGHT SLATE THEME - CUSTOM CSS OVERRIDE -->
    <style>
        /* 1. GLOBAL BODY & TEXT */
        body,
        html,
        #main-wrapper,
        .content-body {
            background-color: #0F172A !important;
            color: #F8FAFC !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        div,
        a,
        label,
        td,
        th,
        li {
            color: inherit;
        }

        .text-muted {
            color: #94A3B8 !important;
        }

        /* 2. NAVBAR, SIDEBAR, & FOOTER */
        .nav-header,
        .header,
        .nk-sidebar {
            background-color: #1E293B !important;
            border-bottom: 1px solid #334155 !important;
        }

        .nk-sidebar {
            border-right: 1px solid #334155 !important;
        }

        .footer {
            border-top: 1px solid #334155 !important;
            background-color: #0F172A !important;
        }

        /* Header Navbar Dropdown & Text */
        .header .btn-light,
        .nav-header .brand-title h4 {
            color: #F8FAFC !important;
            background: transparent !important;
            border: none !important;
        }

        .hamburger .toggle-icon i {
            color: #F8FAFC !important;
        }

        /* Sidebar Links & Icons */
        .nk-sidebar .metismenu a {
            color: #94A3B8 !important;
        }

        .nk-sidebar .metismenu i {
            color: #94A3B8 !important;
        }

        .nk-sidebar .metismenu a:hover,
        .nk-sidebar .metismenu a:focus,
        .nk-sidebar .metismenu a[aria-expanded="true"] {
            color: #3B82F6 !important;
        }

        .nk-sidebar .metismenu a:hover i,
        .nk-sidebar .metismenu a:focus i,
        .nk-sidebar .metismenu a[aria-expanded="true"] i {
            color: #3B82F6 !important;
        }

        /* Active Sidebar Link Highlight - From Tugas 2 */
        .nk-sidebar .metismenu li.active>a {
            background-color: #0F172A !important;
            color: #3B82F6 !important;
            border-radius: 6px !important;
            border: none !important;
        }

        .nk-sidebar .metismenu li.active>a i {
            color: #3B82F6 !important;
        }

        /* Header Profile Dropdown Menu */
        .dropdown-menu {
            background-color: #1E293B !important;
            border: 1px solid #334155 !important;
        }

        .dropdown-item {
            color: #F8FAFC !important;
        }

        .dropdown-item:hover {
            background-color: #334155 !important;
            color: #3B82F6 !important;
        }

        .dropdown-divider {
            border-top: 1px solid #334155 !important;
        }

        /* 3. CARDS & WIDGETS */
        .card {
            background-color: #1E293B !important;
            border: 1px solid #334155 !important;
            box-shadow: none !important;
        }

        .card-header,
        .card-footer {
            background-color: #0F172A !important;
            border-bottom: 1px solid #334155 !important;
        }

        .card-title,
        .card-body {
            color: #F8FAFC !important;
        }

        .card.bg-primary,
        .card.bg-success,
        .card.bg-warning,
        .card.bg-danger,
        .card.bg-info,
        .card.bg-dark {
            background-color: #1E293B !important;
            border: 1px solid #334155 !important;
        }

        .card.bg-primary *,
        .card.bg-success *,
        .card.bg-warning *,
        .card.bg-danger *,
        .card.bg-info * {
            color: #F8FAFC !important;
        }

        .card.bg-primary i {
            color: #3B82F6 !important;
        }

        .card.bg-success i {
            color: #10B981 !important;
        }

        .card.bg-warning i {
            color: #F59E0B !important;
        }

        .card.bg-danger i {
            color: #EF4444 !important;
        }

        .card.bg-info i {
            color: #0EA5E9 !important;
        }

        /* 4. TABLES (DataTables) */
        .table,
        .table-bordered,
        .table-bordered th,
        .table-bordered td,
        .table th,
        .table td {
            border-color: #334155 !important;
        }

        .table-bordered th,
        .table-bordered td {
            border-left: none !important;
            border-right: none !important;
        }

        .table th,
        .table td {
            vertical-align: middle;
            color: #F8FAFC !important;
        }

        .table thead th {
            background-color: #0F172A !important;
            border-bottom: 2px solid #334155 !important;
            color: #94A3B8 !important;
            font-weight: 600;
        }

        .table tbody tr {
            background-color: #1E293B !important;
        }

        .table tbody tr:hover,
        .table-hover tbody tr:hover {
            background-color: #334155 !important;
        }

        /* DataTables Controls (Search & Pagination) */
        .dataTables_wrapper .dataTables_length label,
        .dataTables_wrapper .dataTables_filter label,
        .dataTables_wrapper .dataTables_info {
            color: #94A3B8 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button,
        .page-item .page-link {
            background-color: #1E293B !important;
            color: #F8FAFC !important;
            border: 1px solid #334155 !important;
            border-radius: 4px;
            margin: 0 2px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover,
        .page-item.active .page-link {
            background-color: #3B82F6 !important;
            color: #ffffff !important;
            border-color: #3B82F6 !important;
        }

        .page-item.disabled .page-link {
            background-color: #0F172A !important;
            color: #64748B !important;
            border-color: #334155 !important;
        }

        .page-item .page-link:hover {
            background-color: #334155 !important;
            color: #ffffff !important;
        }

        /* 5. FORM CONTROLS & MODALS */
        .form-control,
        .custom-select,
        input[type="search"] {
            background-color: #0F172A !important;
            color: #F8FAFC !important;
            border: 1px solid #334155 !important;
        }

        .form-control:focus,
        .custom-select:focus,
        input[type="search"]:focus {
            background-color: #0F172A !important;
            color: #F8FAFC !important;
            border-color: #3B82F6 !important;
            box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25) !important;
            outline: none;
        }

        .form-control::placeholder {
            color: #94A3B8 !important;
        }

        /* Modals */
        .modal-content {
            background-color: #1E293B !important;
            border: 1px solid #334155 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.7) !important;
        }

        .modal-header,
        .modal-footer {
            border-color: #334155 !important;
        }

        .modal-title {
            color: #F8FAFC !important;
        }

        .modal-header .close {
            color: #F8FAFC !important;
            text-shadow: none;
            opacity: 0.7;
        }

        .modal-header .close:hover {
            opacity: 1;
            color: #EF4444 !important;
        }

        /* 6. SUB-MENU SIDEBAR (MetisMenu) */
        .nk-sidebar .metismenu ul,
        .nk-sidebar .metismenu ul.collapse,
        .nk-sidebar .metismenu ul.collapse.in,
        .nk-sidebar .metismenu ul.in {
            background-color: #1E293B !important;
            border-top: none !important;
        }

        .nk-sidebar .metismenu ul a {
            color: #94A3B8 !important;
            padding-left: 2rem !important;
        }

        .nk-sidebar .metismenu ul a:hover,
        .nk-sidebar .metismenu ul a:focus,
        .nk-sidebar .metismenu ul a.active,
        .nk-sidebar .metismenu ul li.active a {
            color: #F8FAFC !important;
            background-color: transparent !important;
            text-decoration: none !important;
        }

        /* 7. FOOTER (Tugas 2) */
        .footer .copyright,
        .footer p {
            background-color: #0F172A !important;
            color: #94A3B8 !important;
            border: none !important;
            margin: 0 !important;
        }

        /* 8. STATE SAAT SIDEBAR DISEMBUNYIKAN */
        body.sidebar-hidden .nk-sidebar {
            left: -20rem !important;
            display: none !important;
        }

        body.sidebar-hidden .content-body {
            margin-left: 0 !important;
        }

        body.sidebar-hidden .header {
            margin-left: 0 !important;
            width: 100% !important;
        }

        /* 9. STABILISASI LOGO (Tugas 2) */
        .brand-logo a {
            display: flex !important;
            align-items: center !important;
            text-decoration: none !important;
            justify-content: flex-start !important;
        }

        .brand-logo img {
            width: 40px !important;
            height: auto !important;
            max-width: none !important;
            margin-right: 12px !important;
            filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3)) !important;
        }

        .brand-title {
            color: #F8FAFC !important;
            font-weight: bold !important;
            font-size: 1.3rem !important;
        }

        /* --- PEMBASMI BACKGROUND PUTIH PADA ITEM MENU SIDEBAR --- */
        .nk-sidebar .metismenu li,
        .nk-sidebar .metismenu a,
        .nk-sidebar .metismenu ul li,
        .nk-sidebar .metismenu ul li a {
            background-color: transparent !important;
        }

        /* Pastikan menu yang sedang diklik (aktif) tetap memiliki background gelap yang berbeda */
        .nk-sidebar .metismenu li.active>a {
            background-color: #0F172A !important;
            color: #3B82F6 !important;
        }

        .ul.metismenu,
        .nk-sidebar .metismenu,
        .nk-sidebar .nk-nav-scroll,
        .nk-sidebar .metismenu>li,
        .nk-sidebar .metismenu>li>a {
            background-color: #1E293B !important;
            background: #1E293B !important;
        }

        /* --- PRINT MEDIA QUERY UNTUK CETAK STRUK MODAL --- */
        @media print {
            body.printing-modal * {
                visibility: hidden;
            }

            body.printing-modal .print-active,
            body.printing-modal .print-active * {
                visibility: visible;
            }

            body.printing-modal .print-active {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                background: white !important;
                /* Agar hasil cetak terang */
                color: black !important;
            }

            .no-print {
                display: none !important;
            }
        }
    </style>
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

                <a href="{{ auth()->check() ? (auth()->user()->role == 'admin' ? route('dashboard') : route('user.dashboard')) : url('/Perpustakaan/login') }}">
                    <img src="{{ asset('assets/images/logo_perpus.png') }}" alt="Logo">
                    <span class="brand-title" style="color: #F8FAFC !important; font-weight: 700; font-size: 1.4rem; letter-spacing: 0.5px; margin-top: 2px;">Perpustakaan</span>
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

                <div class="float-right mr-4 mt-3" style="position: relative; z-index: 50;">
                    <div class="dropdown d-inline-block">
                        <button class="btn btn-light dropdown-toggle font-weight-bold" type="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: transparent; border: none;">
                            Halo, {{ Auth::user()->name }}
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown" style="z-index: 1050;">
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profil</a>
                            <div class="dropdown-divider"></div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            <div class="px-3 pb-2 pt-1 m-0">
                                <button type="button" onclick="confirmLogout(event)" class="btn btn-danger btn-sm btn-block">Logout</button>
                            </div>
                        </div>
                    </div>
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

                            <svg style="width: 1.5rem; height: 1.5rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                            </svg>

                            <span class="nav-text">

                                Dashboard

                            </span>

                        </a>

                    </li>

                    <li>

                        <a class="has-arrow" href="javascript:void(0)">

                            <svg style="width: 1.5rem; height: 1.5rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                            </svg>

                            <span class="nav-text">

                                Master

                            </span>

                        </a>

                        <ul>

                            <li>

                                <a href="{{ route('kategori.index') }}">
                                    <svg class="w-5 h-5" style="width: 1.25rem; height: 1.25rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                    </svg>
                                    Data Kategori
                                </a>

                            </li>

                            <li>

                                <a href="{{ route('buku.index') }}">
                                    <svg class="w-5 h-5" style="width: 1.25rem; height: 1.25rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                    Data Buku
                                </a>

                            </li>

                            <li>

                                <a href="{{ route('anggota.index') }}">
                                    <svg class="w-5 h-5" style="width: 1.25rem; height: 1.25rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                    </svg>
                                    Data Anggota
                                </a>

                            </li>

                        </ul>

                    </li>

                    <li>

                        <a class="has-arrow" href="javascript:void(0)">

                            <svg style="width: 1.5rem; height: 1.5rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>

                            <span class="nav-text">

                                Transaksi

                            </span>

                        </a>

                        <ul>

                            <li>

                                <a href="{{ route('peminjaman.index') }}">
                                    <svg class="w-5 h-5" style="width: 1.25rem; height: 1.25rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l3 3m0 0l-3 3m3-3H2.25" />
                                    </svg>
                                    Peminjaman
                                </a>

                            </li>

                            <li>

                                <a href="{{ route('pengembalian.index') }}">
                                    <svg class="w-5 h-5" style="width: 1.25rem; height: 1.25rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                    </svg>
                                    Pengembalian
                                </a>

                            </li>

                        </ul>

                    </li>

                    @else

                    <!-- USER -->

                    <li>

                        <a href="{{ route('user.dashboard') }}">

                            <svg style="width: 1.5rem; height: 1.5rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                            </svg>

                            <span class="nav-text">

                                Dashboard

                            </span>

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('user.buku') }}">

                            <svg style="width: 1.5rem; height: 1.5rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>

                            <span class="nav-text">

                                Daftar Buku

                            </span>

                        </a>

                    </li>

                    <li>

                        <a href="{{ route('user.riwayat') }}">

                            <svg style="width: 1.5rem; height: 1.5rem; display: inline-block; vertical-align: middle; margin-right: 10px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

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

    <!-- Data Container for JS -->
    <div id="flash-messages" data-success="{{ session('success') }}" data-error="{{ session('error') }}"></div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let flashDiv = document.getElementById('flash-messages');
            let successMessage = flashDiv ? flashDiv.dataset.success : null;
            let errorMessage = flashDiv ? flashDiv.dataset.error : null;

            if (successMessage) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successMessage,
                    timer: 3000,
                    showConfirmButton: false
                });
            }

            if (errorMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: errorMessage,
                });
            }

            // form-konfirmasi interception
            const formKonfirmasi = document.querySelectorAll('.form-konfirmasi');
            formKonfirmasi.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Tindakan',
                        text: 'Apakah Anda yakin ingin memproses data ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Proses!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

        });
    </script>

    @yield('scripts')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const hamburger = document.querySelector('.nav-control .hamburger') || document.querySelector('.hamburger');
            if (hamburger) {
                // Kloning elemen untuk mematikan event listener bawaan template yang bentrok
                const newHamburger = hamburger.cloneNode(true);
                hamburger.parentNode.replaceChild(newHamburger, hamburger);

                newHamburger.addEventListener('click', function(e) {
                    e.preventDefault();
                    this.classList.toggle('is-active'); // Efek animasi garis tiga
                    document.body.classList.toggle('sidebar-hidden'); // Trigger CSS perluasan area konten
                });
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Beri jeda 100ms agar MetisMenu bawaan template selesai memuat strukturnya terlebih dahulu
            setTimeout(function() {
                // 1. Serang semua elemen list dan link di sidebar untuk membasmi background putih/cerah
                let sidebarItems = document.querySelectorAll('.nk-sidebar .metismenu li, .nk-sidebar .metismenu a, .nk-sidebar .metismenu ul, .nk-sidebar .metismenu ul li');
                sidebarItems.forEach(el => {
                    el.style.setProperty('background-color', 'transparent', 'important');
                    el.style.setProperty('background', 'none', 'important');
                });

                // 2. Warnai khusus menu yang sedang aktif (diklik)
                let activeItems = document.querySelectorAll('.nk-sidebar .metismenu li.active > a');
                activeItems.forEach(el => {
                    el.style.setProperty('background-color', '#0F172A', 'important');
                    el.style.setProperty('color', '#3B82F6', 'important');
                    el.style.setProperty('border-radius', '6px', 'important');
                });

                // 3. Pastikan teks menu yang tidak aktif tetap berwarna kontras
                let idleLinks = document.querySelectorAll('.nk-sidebar .metismenu a');
                idleLinks.forEach(el => {
                    if (!el.parentElement.classList.contains('active')) {
                        el.style.setProperty('color', '#94A3B8', 'important');
                    }
                });
            }, 100);
        });

        // Logout Confirmation Function
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar dari aplikasi?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal',
                background: '#1E293B',
                color: '#F8FAFC'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
        // Mencegah Double Submit pada semua Form secara Global
        document.addEventListener('submit', function(e) {
            if (e.target && e.target.tagName === 'FORM') {
                // Abaikan form GET (seperti form pencarian)
                if (e.target.method.toUpperCase() === 'GET') return;

                const submitBtn = e.target.querySelector('button[type="submit"], input[type="submit"]');
                if (submitBtn) {
                    if (submitBtn.disabled) {
                        e.preventDefault();
                        return;
                    }
                    // Gunakan setTimeout agar form tetap memproses data sebelum tombol didisable
                    setTimeout(() => {
                        submitBtn.disabled = true;
                        if (!submitBtn.dataset.originalText) {
                            submitBtn.dataset.originalText = submitBtn.innerHTML;
                        }
                        submitBtn.innerHTML = 'Memproses...';
                    }, 0);
                }
            }
        });

        // Global Print Modal Function
        function printModal(modalId) {
            document.body.classList.add('printing-modal');
            document.getElementById(modalId).classList.add('print-active');
            window.print();
            document.body.classList.remove('printing-modal');
            document.getElementById(modalId).classList.remove('print-active');
        }
    </script>
</body>

</html>
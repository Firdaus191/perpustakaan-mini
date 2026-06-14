@extends('layout.layout')

@section('title', 'Dashboard')

@section('content')

<div class="row">

    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-1">
            <div class="card-body">
                <h3 class="card-title text-white">
                    Total Buku
                </h3>

                <div class="d-inline-block">
                    <h2 class="text-white">
                        {{ $totalBuku }}
                    </h2>

                    <p class="text-white mb-0">
                        Data Buku
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-2">
            <div class="card-body">
                <h3 class="card-title text-white">
                    Kategori
                </h3>

                <div class="d-inline-block">
                    <h2 class="text-white">
                        {{ $totalKategori }}
                    </h2>

                    <p class="text-white mb-0">
                        Data Kategori
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-3">
            <div class="card-body">
                <h3 class="card-title text-white">
                    Anggota
                </h3>

                <div class="d-inline-block">
                    <h2 class="text-white">
                        {{ $totalAnggota }}
                    </h2>

                    <p class="text-white mb-0">
                        Data Anggota
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-sm-6">
        <div class="card gradient-4">
            <div class="card-body">
                <h3 class="card-title text-white">
                    Sedang Dipinjam
                </h3>

                <div class="d-inline-block">
                    <h2 class="text-white">
                        {{ $totalPeminjaman }}
                    </h2>

                    <p class="text-white mb-0">
                        Buku Dipinjam
                    </p>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row mt-3">

    <div class="col-lg-3 col-sm-6">

        <div class="card bg-success">

            <div class="card-body">

                <h3 class="card-title text-white">
                    Sudah Dikembalikan
                </h3>

                <div class="d-inline-block">

                    <h2 class="text-white">

                        {{ $totalPengembalian }}

                    </h2>

                    <p class="text-white mb-0">

                        Pengembalian

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
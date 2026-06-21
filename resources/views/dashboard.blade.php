@extends('layout.layout')

@section('title', 'Dashboard')

@section('content')

<style>
    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }

    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }

    .border-left-warning {
        border-left: 4px solid #f6c23e !important;
    }

    .border-left-danger {
        border-left: 4px solid #e74a3b !important;
    }

    .text-primary {
        color: #4e73df !important;
    }

    .text-success {
        color: #1cc88a !important;
    }

    .text-warning {
        color: #f6c23e !important;
    }

    .text-danger {
        color: #e74a3b !important;
    }
</style>

<!-- Row 1: Master Data -->
<div class="row">
    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm rounded-lg border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Buku</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalBuku }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="icon-book-open fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm rounded-lg border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Kategori</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalKategori }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="icon-grid fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm rounded-lg border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Anggota</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalAnggota }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="icon-people fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2: Transaksi -->
<div class="row mt-3">
    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm rounded-lg border-left-warning h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sedang Dipinjam</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalPeminjaman }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="icon-notebook fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm rounded-lg border-left-success h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sudah Dikembalikan</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalPengembalian }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="icon-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm rounded-lg border-left-danger h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Terlambat Dikembalikan</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $totalTerlambat }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="icon-close fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Peminjaman Terlambat</h4>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Jatuh Tempo</th>
                                <th>Terlambat</th>
                                <th>Denda</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($peminjamanTerlambat as $trx)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $trx->anggota->nama }}</td>
                                <td>{{ $trx->buku->judul }}</td>
                                <td>{{ \Carbon\Carbon::parse($trx->tanggal_kembali)->format('d M Y') }}</td>
                                <td><span class="badge badge-danger">{{ $trx->telat_hari }} Hari</span></td>
                                <td>
                                    Rp {{ number_format($trx->total_denda, 0, ',', '.') }}
                                    @if($trx->status_denda == 'menunggu_konfirmasi')
                                    <br><span class="badge badge-warning mt-1">Menunggu Konfirmasi</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('peminjaman.index') }}" class="btn btn-sm btn-primary">Lihat Transaksi</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada peminjaman yang terlambat.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
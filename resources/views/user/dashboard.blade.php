@extends('layout.layout')

@section('title', 'Dashboard User')

@section('content')

@php
    $namaDepan = explode(' ', Auth::user()->name)[0];
    $isH1 = false;
    if ($jatuhTempoTerdekat) {
        $hariSisa = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($jatuhTempoTerdekat), false);
        if ($hariSisa <= 2 && $hariSisa >= 0) {
            $isH1 = true;
        }
    }
@endphp

<div class="row mb-4">
    <div class="col-12">
        <h2 class="font-weight-bold">Halo, {{ $namaDepan }}! Apa yang ingin kamu baca hari ini?</h2>
    </div>
</div>

<style>
    .border-left-primary { border-left: 4px solid #4e73df !important; }
    .border-left-danger { border-left: 4px solid #e74a3b !important; }
    .text-primary { color: #4e73df !important; }
    .text-danger { color: #e74a3b !important; }
</style>

<div class="row">
    <!-- Card Buku Sedang Dipinjam -->
    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm rounded-lg border-left-primary h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Buku Sedang Dipinjam</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">{{ $dipinjamCount }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="icon-notebook fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Tanggal Jatuh Tempo -->
    <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card bg-white shadow-sm rounded-lg {{ $isH1 ? 'border-left-danger' : 'border-left-primary' }} h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold {{ $isH1 ? 'text-danger' : 'text-primary' }} text-uppercase mb-1">Jatuh Tempo Terdekat</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">
                            {{ $jatuhTempoTerdekat ? \Carbon\Carbon::parse($jatuhTempoTerdekat)->format('d M Y') : '-' }}
                        </div>
                        @if($isH1)
                            <div class="text-danger mt-1 font-weight-bold" style="font-size: 0.8rem;">Segera Kembalikan!</div>
                        @endif
                    </div>
                    <div class="col-auto">
                        <i class="icon-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Card Total Tagihan Denda -->
    <div class="col-lg-4 col-sm-12 mb-3">
        <div class="card bg-white shadow-sm rounded-lg border-left-danger h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Tagihan Denda</div>
                        <div class="h5 mb-0 font-weight-bold text-dark">Rp {{ number_format($totalTagihanDenda, 0, ',', '.') }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="icon-credit-card fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Peminjaman Aktif Anda -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h4 class="card-title">Peminjaman Aktif Anda</h4>
                <hr>
                @if($peminjamanAktif->isEmpty())
                    <p class="text-muted text-center mt-4">Anda belum meminjam buku apa pun saat ini.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Cover</th>
                                    <th>Judul</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamanAktif as $peminjaman)
                                <tr>
                                    <td>
                                        <img src="{{ $peminjaman->buku->cover_image ?? 'https://via.placeholder.com/50x70?text=No+Cover' }}" onerror="this.src='https://via.placeholder.com/50x70?text=No+Cover'" alt="Cover" style="width: 40px; height: 60px; object-fit: cover; border-radius: 4px;">
                                    </td>
                                    <td class="align-middle">{{ $peminjaman->buku->judul }}</td>
                                    <td class="align-middle">{{ \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y') }}</td>
                                    <td class="align-middle">
                                        @if($peminjaman->status == 'booking')
                                            <span class="badge badge-info">Booking</span>
                                        @else
                                            <span class="badge badge-warning">Dipinjam</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Rekomendasi Buku Untukmu -->
    <div class="col-lg-6 col-md-12 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h4 class="card-title">Rekomendasi Buku Untukmu</h4>
                <hr>
                <div class="row">
                    @forelse($rekomendasiBuku as $buku)
                        <div class="col-6 col-sm-3 mb-3 text-center">
                            <img src="{{ $buku->cover_image ?? 'https://via.placeholder.com/100x150?text=No+Cover' }}" onerror="this.src='https://via.placeholder.com/100x150?text=No+Cover'" alt="Cover" class="img-fluid mb-2" style="height: 120px; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            <p class="mb-1 text-truncate" style="font-size: 0.85rem;" title="{{ $buku->judul }}">{{ $buku->judul }}</p>
                            
                            <form action="{{ route('user.pinjam', $buku->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm btn-block" style="font-size: 0.75rem; padding: 0.2rem 0.5rem;">Pinjam</button>
                            </form>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted text-center">Belum ada rekomendasi buku saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dashboard-data" data-has-denda="{{ $totalTagihanDenda > 0 ? 'true' : 'false' }}"></div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let hasDenda = document.getElementById('dashboard-data').dataset.hasDenda === 'true';
        if (hasDenda) {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Anda memiliki buku yang telah jatuh tempo!'
            });
        }
    });
</script>
@endsection
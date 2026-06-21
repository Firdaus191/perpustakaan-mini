@extends('layout.layout')

@section('title', 'Dashboard User')

@section('content')

@php
$namaDepan = explode(' ', Auth::user()->name)[0];
$isH1 = false;
if ($jatuhTempoTerdekat) {
$hariSisa = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($jatuhTempoTerdekat), false);
if ($hariSisa <= 2 && $hariSisa>= 0) {
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
        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }

        .border-left-danger {
            border-left: 4px solid #e74a3b !important;
        }

        .text-primary {
            color: #4e73df !important;
        }

        .text-danger {
            color: #e74a3b !important;
        }
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
                            @if($totalTagihanDenda > 0)
                            @if($menungguKonfirmasi)
                            <button class="btn btn-sm btn-secondary mt-2 font-weight-bold" style="border-radius: 4px; cursor: not-allowed;" disabled>
                                <i class="icon-clock mr-1"></i> Menunggu Konfirmasi Admin
                            </button>
                            @else
                            <button onclick="document.getElementById('modalBayarDenda').style.display='flex'" class="btn btn-sm btn-danger mt-2 font-weight-bold" style="border-radius: 4px;">
                                <i class="icon-wallet mr-1"></i> Bayar Denda
                            </button>
                            @endif
                            @endif
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
                                        @elseif($peminjaman->status == 'menunggu_pengembalian')
                                        <span class="badge badge-secondary">Menunggu Admin</span>
                                        @elseif($peminjaman->status == 'dipinjam')
                                        @if($peminjaman->status_denda == 'belum_bayar')
                                        @php
                                        $telat = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_kembali));
                                        @endphp
                                        <span class="badge badge-warning">Dipinjam</span><br>
                                        <small class="text-danger font-weight-bold mt-1 d-block mb-1">Terlambat {{ $telat }} Hari - Belum Bayar Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</small>
                                        @elseif($peminjaman->status_denda == 'menunggu_konfirmasi')
                                        @php
                                        $telat = \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_kembali));
                                        @endphp
                                        <span class="badge badge-warning">Dipinjam</span><br>
                                        <small class="text-warning font-weight-bold mt-1 d-block mb-1">Terlambat {{ $telat }} Hari - Menunggu Konfirmasi</small>
                                        @else
                                        <span class="badge badge-warning mb-1 d-inline-block">Dipinjam</span>
                                        @endif
                                        
                                        <form action="{{ route('user.kembalikan', $peminjaman->id) }}" method="POST" class="mt-2">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info w-100" style="font-size: 0.75rem;">
                                                <i class="icon-action-undo"></i> Kembalikan Buku
                                            </button>
                                        </form>

                                        @elseif($peminjaman->status == 'kembali')
                                        @php
                                        $tglKembaliAsli = $peminjaman->tanggal_dikembalikan ? \Carbon\Carbon::parse($peminjaman->tanggal_dikembalikan) : \Carbon\Carbon::now();
                                        $telat = $tglKembaliAsli->diffInDays(\Carbon\Carbon::parse($peminjaman->tanggal_kembali));
                                        @endphp
                                        @if($peminjaman->status_denda == 'belum_bayar')
                                        <span class="badge badge-success">Dikembalikan</span><br>
                                        <small class="text-danger font-weight-bold mt-1 d-block">Terlambat {{ $telat }} Hari - Belum Bayar Rp {{ number_format($peminjaman->denda, 0, ',', '.') }}</small>
                                        @elseif($peminjaman->status_denda == 'menunggu_konfirmasi')
                                        <span class="badge badge-success">Dikembalikan</span><br>
                                        <small class="text-warning font-weight-bold mt-1 d-block">Terlambat {{ $telat }} Hari - Menunggu Konfirmasi</small>
                                        @elseif($peminjaman->status_denda == 'lunas')
                                        <span class="badge badge-success">Dikembalikan</span><br>
                                        <small class="text-success font-weight-bold mt-1 d-block">Terlambat {{ $telat }} Hari - Lunas</small>
                                        @else
                                        <span class="badge badge-success">Dikembalikan</span>
                                        @endif
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
                            @if($buku->cover_image)
                            <img src="{{ Str::startsWith($buku->cover_image, ['http://', 'https://']) ? $buku->cover_image : asset('storage/covers/' . $buku->cover_image) }}"
                                alt="Cover {{ $buku->judul }}" class="img-fluid mb-2" style="height: 120px; width: 100%; object-fit: cover; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            @else
                            <div class="mb-2 d-flex align-items-center justify-content-center bg-secondary text-white" style="height: 120px; width: 100%; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); font-size: 0.8rem; padding: 10px;">
                                No Cover
                            </div>
                            @endif
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

    <!-- Modal Bayar Denda -->
    <div id="modalBayarDenda" style="display: none; position: fixed; z-index: 9999; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.6); align-items: center; justify-content: center;">
        <div style="background-color: #1E293B; margin: auto; padding: 20px; border: 1px solid #334155; width: 90%; max-width: 500px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #334155; padding-bottom: 10px; margin-bottom: 15px;">
                <h4 style="color: #F8FAFC; margin: 0;">Upload Bukti Pembayaran</h4>
                <span onclick="document.getElementById('modalBayarDenda').style.display='none'" style="color: #94A3B8; font-size: 24px; font-weight: bold; cursor: pointer;">&times;</span>
            </div>
            <form action="{{ route('user.bayarDenda') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="bukti_pembayaran" style="color: #F8FAFC;">File Bukti Transfer/Bayar (JPG, PNG, PDF | Max 2MB)</label>
                    <input type="file" class="form-control" name="bukti_pembayaran" id="bukti_pembayaran" required style="background-color: #0F172A; color: #F8FAFC; border: 1px solid #334155; padding: 5px;">
                </div>
                <div style="text-align: right; margin-top: 20px;">
                    <button type="button" onclick="document.getElementById('modalBayarDenda').style.display='none'" class="btn btn-secondary mr-2">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Bukti</button>
                </div>
            </form>
        </div>
    </div>

    <div id="session-data"
        data-success="{{ session('success') }}"
        data-error="{{ session('error') }}"
        data-errors="{{ json_encode($errors->all()) }}"></div>

    @endsection

    @section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sessionData = document.getElementById('session-data');
            const successMsg = sessionData.dataset.success;
            const errorMsg = sessionData.dataset.error;

            let errors = [];
            try {
                errors = JSON.parse(sessionData.dataset.errors);
            } catch (e) {}

            if (successMsg) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: successMsg,
                    timer: 3000,
                    showConfirmButton: false
                });
            }

            if (errorMsg) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMsg
                });
            }

            if (errors && errors.length > 0) {
                let htmlList = '<ul>';
                errors.forEach(function(err) {
                    htmlList += '<li>' + err + '</li>';
                });
                htmlList += '</ul>';
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    html: htmlList
                });
            }

            let hasDenda = document.getElementById('dashboard-data').dataset.hasDenda === 'true';
            if (hasDenda && !successMsg) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Anda memiliki buku yang telah jatuh tempo!'
                });
            }
        });
    </script>
    @endsection
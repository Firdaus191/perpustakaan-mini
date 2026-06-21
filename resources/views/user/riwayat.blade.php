@extends('layout.layout')

@section('title', 'Riwayat Peminjaman')

@section('content')

<div class="row">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-body">

                <h4>Riwayat Peminjaman</h4>

                <hr>

                @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

                @endif

                @if(session('error'))

                <div class="alert alert-danger">

                    {{ session('error') }}

                </div>

                @endif

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($riwayat as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $item->buku->judul ?? '-' }}</td>

                            <td>{{ $item->tanggal_pinjam }}</td>

                            <td>{{ $item->tanggal_kembali }}</td>

                            <td>
                                @php
                                $isLate = false;
                                $telatHari = 0;
                                $denda = 0;
                                if ($item->status == 'dipinjam') {
                                $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_kembali)->startOfDay();
                                $hariIni = \Carbon\Carbon::now()->startOfDay();
                                if ($hariIni->greaterThan($jatuhTempo)) {
                                $isLate = true;
                                $telatHari = $jatuhTempo->diffInDays($hariIni);
                                $denda = $telatHari * 2000;
                                }
                                }
                                @endphp

                                @if($isLate)
                                <span class="badge badge-danger">Terlambat {{ $telatHari }} Hari (Denda: Rp {{ number_format($denda, 0, ',', '.') }})</span>
                                @elseif($item->status == 'dipinjam')
                                <span class="badge badge-warning">Sedang Dipinjam</span>
                                @elseif($item->status == 'kembali')
                                <span class="badge badge-success">Dikembalikan</span>
                                @elseif($item->status == 'booking')
                                <span class="badge badge-info">Booking</span>
                                @elseif($item->status == 'menunggu_pengembalian')
                                <span class="badge badge-primary">Menunggu Pengembalian</span>
                                @else
                                <span class="badge badge-secondary">{{ ucfirst($item->status) }}</span>
                                @endif

                                @if($item->status == 'dipinjam')
                                <form action="{{ route('user.kembalikan', $item->id) }}" method="POST" class="mt-2 d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-info">
                                        Kembalikan Buku
                                    </button>
                                </form>
                                @endif

                                @if($item->bukti_pembayaran != null)
                                <button type="button" class="btn btn-info btn-sm ml-2" data-toggle="modal" data-target="#modalBuktiUser{{ $item->id }}">
                                    Lihat Bukti
                                </button>
                                @endif
                            </td>



                        </tr>

                        @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                Belum ada riwayat peminjaman.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                @foreach($riwayat as $item)
                @if($item->bukti_pembayaran != null)
                <!-- Modal Bukti User -->
                <div class="modal fade" id="modalBuktiUser{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="modalBuktiUserLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header no-print">
                                <h5 class="modal-title" id="modalBuktiUserLabel{{ $item->id }}">Bukti Pembayaran Denda</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <h3 class="mb-3 d-none d-print-block text-dark">Struk Pembayaran Denda Perpus</h3>
                                <img src="{{ asset('storage/bukti/' . $item->bukti_pembayaran) }}" alt="Bukti Pembayaran" style="max-width: 100%; height: auto; border-radius: 8px;">
                            </div>
                            <div class="modal-footer no-print">
                                <button type="button" class="btn btn-primary" onclick="printModal('modalBuktiUser{{ $item->id }}')"><i class="fa fa-print"></i> Cetak Struk</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection
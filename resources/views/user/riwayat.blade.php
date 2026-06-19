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

            </div>

        </div>

    </div>

</div>

@endsection
@extends('layout.layout')

@section('title', 'Pengembalian Buku')

@section('content')

<div class="row">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <h4 class="card-title">

                    Data Buku yang Masih Dipinjam

                </h4>

                <hr>

                @if(session('success'))

                <div class="alert alert-success">

                    {{ session('success') }}

                </div>

                @endif

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Anggota</th>

                                <th>Buku</th>

                                <th>Tanggal Pinjam</th>

                                <th>Jatuh Tempo</th>

                                <th>Status</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($dipinjam as $item)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>

                                    {{ $item->anggota->nama }}

                                </td>

                                <td>

                                    {{ $item->buku->judul }}

                                </td>

                                <td>

                                    {{ $item->tanggal_pinjam }}

                                </td>

                                <td>

                                    {{ $item->tanggal_kembali }}

                                </td>

                                <td>

                                    @php
                                    $jatuhTempo = \Carbon\Carbon::parse($item->tanggal_kembali)->startOfDay();
                                    $hariIni = \Carbon\Carbon::now()->startOfDay();
                                    @endphp
                                    @if($hariIni->greaterThan($jatuhTempo))
                                    @php
                                    $telat = $jatuhTempo->diffInDays($hariIni);
                                    $denda = $telat * 2000;
                                    @endphp
                                    <span class="badge badge-danger">Terlambat {{ $telat }} Hari <br> (Denda: Rp {{ number_format($denda, 0, ',', '.') }})</span>
                                    @else
                                    <span class="badge badge-warning">Sedang Dipinjam</span>
                                    @endif

                                </td>

                                <td>

                                    <form
                                        action="{{ route('pengembalian.kembalikan', $item->id) }}"
                                        method="POST"
                                        class="form-konfirmasi">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-success btn-sm">

                                            Kembalikan

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="7" class="text-center">

                                    Tidak ada buku yang sedang dipinjam.

                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <h4 class="card-title">

                    Riwayat Pengembalian

                </h4>

                <hr>

                <div class="table-responsive">

                    <table class="table table-bordered table-striped">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Anggota</th>

                                <th>Buku</th>

                                <th>Tanggal Pinjam</th>

                                <th>Tanggal Kembali</th>

                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($dikembalikan as $item)

                            <tr>

                                <td>{{ $loop->iteration }}</td>

                                <td>

                                    {{ $item->anggota->nama }}

                                </td>

                                <td>

                                    {{ $item->buku->judul }}

                                </td>

                                <td>

                                    {{ $item->tanggal_pinjam }}

                                </td>

                                <td>

                                    {{ $item->tanggal_kembali }}

                                </td>

                                <td>

                                    <span class="badge badge-success">

                                        {{ $item->status }}

                                    </span>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="6" class="text-center">

                                    Belum ada riwayat pengembalian.

                                </td>

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
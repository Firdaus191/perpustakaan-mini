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
                            <th>Aksi</th>

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

                                @if($item->status == 'Dipinjam')

                                    <span class="badge badge-warning">

                                        Dipinjam

                                    </span>

                                @else

                                    <span class="badge badge-success">

                                        Dikembalikan

                                    </span>

                                @endif

                            </td>

                            <td>

                                @if($item->status == 'Dipinjam')

                                    <form action="{{ route('user.kembalikan', $item->id) }}" method="POST">

                                        @csrf

                                        <button
                                            type="submit"
                                            class="btn btn-success btn-sm">

                                            Kembalikan

                                        </button>

                                    </form>

                                @else

                                    -

                                @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center">

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
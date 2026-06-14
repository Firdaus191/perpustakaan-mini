@extends('layout.layout')

@section('title', 'Daftar Buku')

@section('content')

<div class="row">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-body">

                <h4>Daftar Buku</h4>

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
                            <th>Cover</th>
                            <th>Kode Buku</th>
                            <th>Judul</th>
                            <th>Pengarang</th>
                            <th>Stok</th>
                            <th>Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($buku as $item)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                @if($item->cover_image)
                                    <img src="{{ asset('storage/covers/'.$item->cover_image) }}" alt="Cover" style="width: 50px; height: 70px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                @else
                                    <span class="badge badge-secondary">No Cover</span>
                                @endif
                            </td>

                            <td>{{ $item->kode_buku }}</td>

                            <td>{{ $item->judul }}</td>

                            <td>{{ $item->penulis }}</td>

                            <td>{{ $item->stok }}</td>

                            <td>

                        @if(in_array($item->id, $dipinjam))

                            <button
                                class="btn btn-secondary btn-sm"
                                disabled>

                                Sedang Dipinjam

                            </button>

                        @elseif($item->stok > 0)

                            <form action="{{ route('user.pinjam', $item->id) }}" method="POST">

                                @csrf

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-sm">

                                    Pinjam

                                </button>

                            </form>

                        @else

                            <span class="badge badge-danger">

                                Habis

                            </span>

                        @endif

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" class="text-center">

                                Tidak ada data buku.

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
@extends('layout.layout')

@section('title', 'Data Buku')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Data Buku</h4>

                {{-- Notifikasi --}}
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif

                <div class="d-flex justify-content-end mb-3">

                    <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">
                        + Tambah Buku
                    </a>

                </div>

                <div class="table-responsive">

                    <table id="tabelBuku" class="table table-striped table-bordered">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Cover</th>
                                <th>Kode</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($buku as $index => $item)

                            <tr>

                                <td>{{ $index + 1 }}</td>

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

                                <td>{{ $item->penerbit }}</td>

                                <td>{{ $item->tahun_terbit }}</td>

                                <td>
                                    {{ $item->kategori->nama_kategori ?? '-' }}
                                </td>

                                <td>{{ $item->stok }}</td>

                                <td>

                                    <a href="{{ route('buku.edit',$item->id) }}"
                                        class="btn btn-success btn-sm">

                                        Edit

                                    </a>

                                    <form action="{{ route('buku.delete', $item->id) }}"
                                        method="POST"
                                        class="d-inline form-konfirmasi">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-danger btn-sm">

                                            Hapus

                                        </button>

                                    </form>

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {

        $('#tabelBuku').DataTable();

    });
</script>

@endsection
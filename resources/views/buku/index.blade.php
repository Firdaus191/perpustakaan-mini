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

                <div class="d-flex justify-content-between mb-3 align-items-center">
                    <form method="GET" action="{{ route('buku.index') }}" class="m-0">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Cari judul atau penulis..." value="{{ request('search') }}">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="submit">Cari</button>
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('buku.create') }}" class="btn btn-primary">
                        + Tambah Buku
                    </a>
                </div>

                <div class="table-responsive">

                    <table class="table table-striped table-bordered">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Cover</th>
                                <th>Kode</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'judul', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark text-decoration-none d-flex align-items-center justify-content-between">
                                        Judul Buku
                                        @if(request('sort') == 'judul')
                                        <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'penulis', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark text-decoration-none d-flex align-items-center justify-content-between">
                                        Penulis
                                        @if(request('sort') == 'penulis')
                                        <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Penerbit</th>
                                <th>
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'tahun_terbit', 'order' => request('order') == 'asc' ? 'desc' : 'asc']) }}" class="text-dark text-decoration-none d-flex align-items-center justify-content-between">
                                        Tahun
                                        @if(request('sort') == 'tahun_terbit')
                                        <i class="fas fa-sort-{{ request('order') == 'asc' ? 'up' : 'down' }} ms-1"></i>
                                        @else
                                        <i class="fas fa-sort ms-1 text-muted"></i>
                                        @endif
                                    </a>
                                </th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($buku as $index => $item)

                            <tr>

                                <td>{{ $buku->firstItem() + $index }}</td>

                                <td>
                                    @if($item->cover_image)
                                    <img src="{{ Str::startsWith($item->cover_image, ['http://', 'https://']) ? $item->cover_image : asset('storage/covers/' . $item->cover_image) }}"
                                        alt="Cover {{ $item->judul }}"
                                        class="w-12 h-16 object-cover rounded shadow-sm" style="width: 48px; height: 64px; object-fit: cover;">
                                    @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($item->judul) }}&background=random&color=fff&size=400&font-size=0.33"
                                        alt="Cover {{ $item->judul }}"
                                        class="w-12 h-16 object-cover rounded shadow-sm" style="width: 48px; height: 64px; object-fit: cover;">
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

                    <div class="custom-pagination-container">
                        <div class="pagination-info">
                            Showing {{ $buku->firstItem() }} to {{ $buku->lastItem() }} of {{ $buku->total() }} entries
                        </div>
                        <div class="pagination-buttons">
                            {{ $buku->links('pagination::bootstrap-4') }}
                        </div>
                    </div>

                    <style>
                        .custom-pagination-container {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            width: 100%;
                            margin-top: 1rem;
                            padding-bottom: 1rem;
                        }

                        .pagination-info {
                            color: #9ca3af;
                            /* Warna teks abu-abu terang */
                            font-size: 0.875rem;
                        }

                        .pagination-buttons .pagination {
                            display: flex;
                            gap: 0.25rem;
                            margin: 0;
                            padding: 0;
                            list-style: none;
                        }

                        .pagination-buttons .page-item .page-link {
                            background-color: transparent;
                            border: 1px solid #374151;
                            /* Border abu-abu gelap */
                            color: #d1d5db;
                            padding: 0.375rem 0.75rem;
                            border-radius: 0.375rem;
                            /* Membuat sudut agak membulat */
                            text-decoration: none;
                            font-size: 0.875rem;
                        }

                        .pagination-buttons .page-item.active .page-link {
                            background-color: #3b82f6;
                            /* Warna biru */
                            border-color: #3b82f6;
                            color: #ffffff;
                        }

                        .pagination-buttons .page-item.disabled .page-link {
                            color: #6b7280;
                            pointer-events: none;
                            background-color: transparent;
                            border-color: #374151;
                        }

                        /* Menghilangkan panah raksasa/SVG bawaan Laravel Tailwind jika ada */
                        .pagination-buttons svg {
                            display: none !important;
                        }
                    </style>

                </div>

            </div>
        </div>
    </div>
</div>

@endsection
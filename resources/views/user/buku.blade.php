@extends('layout.layout')

@section('title', 'Daftar Buku')

@section('content')

<div class="row">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-body">

                <h4>Daftar Buku</h4>

                <hr>

                <form method="GET" action="{{ route('user.buku') }}" class="mb-3" id="search-form">
                    <div class="input-group">
                        <input type="text" name="search" id="search-input" class="form-control" placeholder="Cari judul buku..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>

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

                    <tbody id="buku-tbody">

                        @forelse($buku as $item)

                        <tr>

                            <td>{{ $buku->firstItem() + $loop->index }}</td>

                            <td>
                                @if($item->cover_image)
                                <img src="{{ Str::startsWith($item->cover_image, ['http://', 'https://']) ? $item->cover_image : asset('storage/covers/' . $item->cover_image) }}"
                                    alt="Cover {{ $item->judul }}"
                                    class="w-12 h-16 object-cover rounded shadow-sm" style="width: 48px; height: 64px; object-fit: cover;">
                                @else
                                <div class="w-12 h-16 bg-gray-300 flex items-center justify-center rounded shadow-sm text-xs text-gray-500 text-center p-1" style="width: 48px; height: 64px; background: #e2e8f0; display:flex; align-items:center; justify-content:center;">No Cover</div>
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

                                <form action="{{ route('user.pinjam', $item->id) }}" method="POST" class="form-pinjam">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="btn btn-primary btn-sm btn-pinjam">

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

                <div class="mt-3" id="pagination-container">
                    {{ $buku->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('.form-pinjam');

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah reload halaman

                const url = this.action;
                const formData = new FormData(this);
                const submitBtn = this.querySelector('.btn-pinjam');

                // Disable button saat request
                submitBtn.disabled = true;
                submitBtn.innerHTML = 'Memproses...';

                fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json().then(data => ({
                        status: response.status,
                        body: data
                    })))
                    .then(result => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Pinjam';

                        if (result.status >= 400) {
                            // Jika Error (Termasuk Suspend 403)
                            Swal.fire({
                                icon: 'error',
                                title: 'Aksi Ditolak!',
                                text: result.body.error || 'Terjadi kesalahan sistem.',
                                confirmButtonColor: '#d33'
                            }).then(() => {
                                // Jika frozen, reload untuk men-trigger logout dari middleware
                                if (result.body.error && result.body.error.toLowerCase().includes('dibekukan')) {
                                    window.location.reload();
                                }
                            });
                        } else if (result.status === 200 || result.status === 201) {
                            // Jika Success
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: result.body.success || 'Buku berhasil dibooking.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    })
                    .catch(error => {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = 'Pinjam';
                        console.error('Error:', error);

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Gagal menghubungi server.',
                        });
                    });
            });
        });
    });

    // AJAX Live Search
    document.addEventListener('DOMContentLoaded', function() {
        let searchTimeout;
        const searchInput = document.getElementById('search-input');
        const tbody = document.getElementById('buku-tbody');
        const paginationContainer = document.getElementById('pagination-container');
        const searchForm = document.getElementById('search-form');

        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault(); // Mencegah reload
            });
        }

        if (searchInput) {
            searchInput.addEventListener('keyup', function(e) {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    let keyword = this.value;

                    // Tambahkan efek loading
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center"><i class="fa fa-spinner fa-spin"></i> Mencari...</td></tr>';

                    fetch("{{ route('user.buku') }}?search=" + encodeURIComponent(keyword), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            tbody.innerHTML = data.html;
                            if (paginationContainer) {
                                paginationContainer.innerHTML = data.pagination;
                            }
                        })
                        .catch(error => {
                            tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Gagal memuat data</td></tr>';
                        });
                }, 500);
            });
        }
    });
</script>

@endsection
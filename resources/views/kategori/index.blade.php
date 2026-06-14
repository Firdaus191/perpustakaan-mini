@extends('layout.layout')

@section('title', 'Data Kategori')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Data Kategori</h4>

                {{-- NOTIFIKASI --}}
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

                <div class="d-flex justify-content-end mb-3">

                    <a href="{{ route('kategori.create') }}" class="btn btn-primary btn-sm">
                        + Tambah
                    </a>

                </div>

                <div class="table-responsive">

                    <table id="tabelKategori" class="table table-striped table-bordered">

                        <thead>
                            <tr>
                                <th width="60">No</th>
                                <th>Kode</th>
                                <th>Nama Kategori</th>
                                <th>Keterangan</th>
                                <th width="170">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($kategori as $index => $item)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>
                                    {{ $item->kode_kategori }}
                                </td>

                                <td>
                                    {{ $item->nama_kategori }}
                                </td>

                                <td>
                                    {{ $item->keterangan }}
                                </td>

                                <td>

                                    <a href="{{ route('kategori.edit',$item->id) }}"
                                        class="btn btn-success btn-sm">

                                        Edit

                                    </a>

                                    <form action="{{ route('kategori.delete',$item->id) }}"
                                        method="POST"
                                        style="display:inline;"
                                        onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">

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

$(document).ready(function(){

    $('#tabelKategori').DataTable();

});

</script>

@endsection
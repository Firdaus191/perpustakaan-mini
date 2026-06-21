@extends('layout.layout')

@section('title', 'Data Anggota')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Data Anggota</h4>

                {{-- NOTIFIKASI --}}
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

                    <a href="{{ route('anggota.create') }}" class="btn btn-primary btn-sm">
                        + Tambah Anggota
                    </a>

                </div>

                <div class="table-responsive">

                    <table id="tabelAnggota" class="table table-striped table-bordered">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Kode Anggota</th>

                                <th>Nama</th>

                                <th>Jenis Kelamin</th>

                                <th>No HP</th>

                                <th>Email</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($anggota as $index => $item)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>{{ $item->kode_anggota }}</td>

                                <td>{{ $item->nama }}</td>

                                <td>

                                    {{ $item->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}

                                </td>

                                <td>{{ $item->no_hp }}</td>

                                <td>{{ $item->user->email ?? 'Email tidak ditemukan' }}</td>

                                <td>

                                    <a href="{{ route('anggota.edit',$item->id) }}"
                                        class="btn btn-success btn-sm">

                                        Edit

                                    </a>

                                    <form action="{{ route('anggota.delete', $item->id) }}"
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

        $('#tabelAnggota').DataTable();

    });
</script>

@endsection
@extends('layout.layout')

@section('title', 'Data Peminjaman')

@section('content')

<div class="row">
<div class="col-12">
<div class="card">
<div class="card-body">

<h4 class="card-title">Data Peminjaman</h4>

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

    <a href="{{ route('peminjaman.create') }}" class="btn btn-primary btn-sm">

        + Tambah Peminjaman

    </a>

</div>

<div class="table-responsive">

<table id="tabelPeminjaman" class="table table-striped table-bordered">

<thead>

<tr>

    <th>No</th>

    <th>Anggota</th>

    <th>Buku</th>

    <th>Tanggal Pinjam</th>

    <th>Tanggal Kembali</th>

    <th>Status</th>

    <th>Aksi</th>

</tr>

</thead>

<tbody>

@foreach($peminjaman as $index => $item)

<tr>

    <td>{{ $index + 1 }}</td>

    <td>

        {{ $item->anggota->kode_anggota }}

        <br>

        {{ $item->anggota->nama }}

    </td>

    <td>

        {{ $item->buku->kode_buku }}

        <br>

        {{ $item->buku->judul }}

    </td>

    <td>

        {{ $item->tanggal_pinjam }}

    </td>

    <td>

        {{ $item->tanggal_kembali }}

    </td>

    <td>

        @if($item->status=="Dipinjam")

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

        <a href="{{ route('peminjaman.edit',$item->id) }}"
            class="btn btn-success btn-sm">

            Edit

        </a>

        <form
            action="{{ route('peminjaman.delete',$item->id) }}"
            method="POST"
            style="display:inline;"
            onsubmit="return confirm('Yakin hapus data?')">

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

    $('#tabelPeminjaman').DataTable();

});

</script>

@endsection
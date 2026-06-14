@extends('layout.layout')

@section('title', 'Tambah Buku')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">

<div class="card-body">

<div class="card-header d-flex justify-content-between align-items-center">

    <h4 class="card-title">Tambah Buku</h4>

    <a href="{{ route('buku.index') }}" class="btn btn-primary btn-sm">
        Kembali
    </a>

</div>

<hr>

<form action="{{ route('buku.store') }}" method="POST">

@csrf

<div class="form-group row">

    <div class="col-md-6">

        <label>Kode Buku</label>

        <input
            type="text"
            name="kode_buku"
            class="form-control"
            required>

    </div>

    <div class="col-md-6">

        <label>Judul Buku</label>

        <input
            type="text"
            name="judul"
            class="form-control"
            required>

    </div>

</div>

<div class="form-group row">

    <div class="col-md-6">

        <label>Penulis</label>

        <input
            type="text"
            name="penulis"
            class="form-control"
            required>

    </div>

    <div class="col-md-6">

        <label>Penerbit</label>

        <input
            type="text"
            name="penerbit"
            class="form-control"
            required>

    </div>

</div>

<div class="form-group row">

    <div class="col-md-4">

        <label>Tahun Terbit</label>

        <input
            type="number"
            name="tahun_terbit"
            class="form-control"
            min="1900"
            max="2100"
            required>

    </div>

    <div class="col-md-4">

        <label>Kategori</label>

        <select
            name="kategori_id"
            class="form-control"
            required>

            <option value="">-- Pilih Kategori --</option>

            @foreach($kategori as $item)

            <option value="{{ $item->id }}">
                {{ $item->nama_kategori }}
            </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-4">

        <label>Stok</label>

        <input
            type="number"
            name="stok"
            class="form-control"
            min="0"
            required>

    </div>

</div>

<button type="submit" class="btn btn-primary float-right">

    Simpan

</button>

</form>

</div>

</div>

</div>
</div>

@endsection
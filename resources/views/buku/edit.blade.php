@extends('layout.layout')

@section('title', 'Edit Buku')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">

<div class="card-body">

<div class="card-header d-flex justify-content-between align-items-center">

    <h4 class="card-title">Edit Buku</h4>

    <a href="{{ route('buku.index') }}" class="btn btn-primary btn-sm">
        Kembali
    </a>

</div>

<hr>

<form action="{{ route('buku.update', $buku->id) }}" method="POST">

@csrf

<div class="form-group row">

    <div class="col-md-6">

        <label>Kode Buku</label>

        <input
            type="text"
            name="kode_buku"
            class="form-control"
            value="{{ $buku->kode_buku }}"
            required>

    </div>

    <div class="col-md-6">

        <label>Judul Buku</label>

        <input
            type="text"
            name="judul"
            class="form-control"
            value="{{ $buku->judul }}"
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
            value="{{ $buku->penulis }}"
            required>

    </div>

    <div class="col-md-6">

        <label>Penerbit</label>

        <input
            type="text"
            name="penerbit"
            class="form-control"
            value="{{ $buku->penerbit }}"
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
            value="{{ $buku->tahun_terbit }}"
            required>

    </div>

    <div class="col-md-4">

        <label>Kategori</label>

        <select name="kategori_id" class="form-control">

            @foreach($kategori as $item)

                <option value="{{ $item->id }}"
                    {{ $buku->kategori_id == $item->id ? 'selected' : '' }}>

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
            value="{{ $buku->stok }}"
            required>

    </div>

</div>

<button type="submit" class="btn btn-primary float-right">

    Simpan Perubahan

</button>

</form>

</div>

</div>

</div>
</div>

@endsection
@extends('layout.layout')

@section('title', 'Tambah Anggota')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">

<div class="card-body">

<div class="card-header d-flex justify-content-between align-items-center">

    <h4 class="card-title">Tambah Anggota</h4>

    <a href="{{ route('anggota.index') }}" class="btn btn-primary btn-sm">
        Kembali
    </a>

</div>

<hr>

<form action="{{ route('anggota.store') }}" method="POST">

@csrf

<div class="form-group row">

    <div class="col-md-6">

        <label>Kode Anggota</label>

        <input
            type="text"
            name="kode_anggota"
            class="form-control"
            required>

    </div>

    <div class="col-md-6">

        <label>Nama Lengkap</label>

        <input
            type="text"
            name="nama"
            class="form-control"
            required>

    </div>

</div>

<div class="form-group row">

    <div class="col-md-6">

        <label>Jenis Kelamin</label>

        <select
            name="jenis_kelamin"
            class="form-control"
            required>

            <option value="L">Laki-laki</option>

            <option value="P">Perempuan</option>

        </select>

    </div>

    <div class="col-md-6">

        <label>No HP</label>

        <input
            type="text"
            name="no_hp"
            class="form-control"
            required>

    </div>

</div>

<div class="form-group">

    <label>Email</label>

    <input
        type="email"
        name="email"
        class="form-control">

</div>

<div class="form-group">

    <label>Alamat</label>

    <textarea
        name="alamat"
        rows="4"
        class="form-control"
        required></textarea>

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
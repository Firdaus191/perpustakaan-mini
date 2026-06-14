@extends('layout.layout')

@section('title', 'Edit Peminjaman')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">

<div class="card-body">

<div class="card-header d-flex justify-content-between align-items-center">

    <h4 class="card-title">Edit Peminjaman</h4>

    <a href="{{ route('peminjaman.index') }}" class="btn btn-primary btn-sm">
        Kembali
    </a>

</div>

<hr>

<form action="{{ route('peminjaman.update', $peminjaman->id) }}" method="POST">

@csrf

<div class="form-group row">

    <div class="col-md-6">

        <label>Anggota</label>

        <select name="anggota_id" class="form-control" required>

            @foreach($anggota as $item)

                <option value="{{ $item->id }}"
                    {{ $peminjaman->anggota_id == $item->id ? 'selected' : '' }}>

                    {{ $item->kode_anggota }} - {{ $item->nama }}

                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6">

        <label>Buku</label>

        <select name="buku_id" class="form-control" required>

            @foreach($buku as $item)

                <option value="{{ $item->id }}"
                    {{ $peminjaman->buku_id == $item->id ? 'selected' : '' }}>

                    {{ $item->kode_buku }} - {{ $item->judul }}

                </option>

            @endforeach

        </select>

    </div>

</div>

<div class="form-group row">

    <div class="col-md-6">

        <label>Tanggal Pinjam</label>

        <input
            type="date"
            name="tanggal_pinjam"
            class="form-control"
            value="{{ $peminjaman->tanggal_pinjam }}"
            required>

    </div>

    <div class="col-md-6">

        <label>Tanggal Kembali</label>

        <input
            type="date"
            name="tanggal_kembali"
            class="form-control"
            value="{{ $peminjaman->tanggal_kembali }}"
            required>

    </div>

</div>

<div class="form-group">

    <label>Status</label>

    <select name="status" class="form-control">

        <option value="Dipinjam"
            {{ $peminjaman->status == 'Dipinjam' ? 'selected' : '' }}>
            Dipinjam
        </option>

        <option value="Dikembalikan"
            {{ $peminjaman->status == 'Dikembalikan' ? 'selected' : '' }}>
            Dikembalikan
        </option>

    </select>

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
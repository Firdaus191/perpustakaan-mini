@extends('layout.layout')

@section('title', 'Tambah Peminjaman')

@section('content')

<div class="row">
<div class="col-12">

<div class="card">

<div class="card-body">

<div class="card-header d-flex justify-content-between align-items-center">

    <h4 class="card-title">Tambah Peminjaman</h4>

    <a href="{{ route('peminjaman.index') }}" class="btn btn-primary btn-sm">
        Kembali
    </a>

</div>

<hr>

<form action="{{ route('peminjaman.store') }}" method="POST">

@csrf

<div class="form-group row">

    <div class="col-md-6">

        <label>Anggota</label>

        <select name="anggota_id" class="form-control" required>

            <option value="">-- Pilih Anggota --</option>

            @foreach($anggota as $item)

                <option value="{{ $item->id }}">
                    {{ $item->kode_anggota }} - {{ $item->nama }}
                </option>

            @endforeach

        </select>

    </div>

    <div class="col-md-6">

        <label>Buku</label>

        <select name="buku_id" class="form-control" required>

            <option value="">-- Pilih Buku --</option>

            @foreach($buku as $item)

                <option value="{{ $item->id }}">
                    {{ $item->kode_buku }} - {{ $item->judul }}
                    (Stok: {{ $item->stok }})
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
            value="{{ date('Y-m-d') }}"
            required>

    </div>

    <div class="col-md-6">

        <label>Tanggal Kembali</label>

        <input
            type="date"
            name="tanggal_kembali"
            class="form-control"
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
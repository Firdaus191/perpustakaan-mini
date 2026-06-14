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

<form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">

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

<div class="form-group row">

    <div class="col-md-12">

        <label>Cover Buku</label>

        @if($buku->cover_image)
            <div class="mb-2">
                <img src="{{ asset('storage/covers/'.$buku->cover_image) }}" alt="Cover Current" style="width: 80px; height: 120px; object-fit: cover; border: 1px solid #ccc; border-radius: 4px;">
                <p class="small text-muted mb-0">Cover Saat Ini</p>
            </div>
        @endif

        <input
            type="file"
            name="cover_image"
            class="form-control-file @error('cover_image') is-invalid @enderror">

        <small class="text-muted">Format gambar: jpeg, png, jpg, gif (Max 2MB). Biarkan kosong jika tidak ingin mengubah cover.</small>

        @error('cover_image')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror

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
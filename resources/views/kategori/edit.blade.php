@extends('layout.layout')

@section('title', 'Edit Kategori')

@section('content')

<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h4 class="card-title">Edit Kategori</h4>

                    <a href="{{ route('kategori.index') }}"
                        class="btn btn-primary btn-sm">

                        Kembali

                    </a>

                </div>

                <hr>

                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">

                    @csrf

                    <div class="form-group row">

                        <div class="col-md-6">

                            <label>Kode Kategori</label>

                            <input
                                type="text"
                                name="kode_kategori"
                                class="form-control"
                                value="{{ $kategori->kode_kategori }}"
                                required>

                        </div>

                        <div class="col-md-6">

                            <label>Nama Kategori</label>

                            <input
                                type="text"
                                name="nama_kategori"
                                class="form-control"
                                value="{{ $kategori->nama_kategori }}"
                                required>

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Keterangan</label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="4">{{ $kategori->keterangan }}</textarea>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary float-right">

                        Update

                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection
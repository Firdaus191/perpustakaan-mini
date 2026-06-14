@extends('layout.layout')

@section('title', 'Tambah Kategori')

@section('content')

<div class="row">
    <div class="col-12">

        <div class="card">

            <div class="card-body">

                <div class="card-header d-flex justify-content-between align-items-center">

                    <h4 class="card-title">Tambah Kategori</h4>

                    <a href="{{ route('kategori.index') }}"
                        class="btn btn-primary btn-sm">

                        <i class="fa fa-arrow-left"></i> Kembali

                    </a>

                </div>

                <hr>

                @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

                @endif

                @if ($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

                @endif

                <form action="{{ route('kategori.store') }}" method="POST">

                    @csrf

                    <div class="form-group row">

                        <div class="col-md-6">

                            <label>Kode Kategori</label>

                            <input
                                type="text"
                                name="kode_kategori"
                                class="form-control"
                                required>

                        </div>

                        <div class="col-md-6">

                            <label>Nama Kategori</label>

                            <input
                                type="text"
                                name="nama_kategori"
                                class="form-control"
                                required>

                        </div>

                    </div>

                    <div class="form-group">

                        <label>Keterangan</label>

                        <textarea
                            name="keterangan"
                            class="form-control"
                            rows="4"></textarea>

                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary float-right">

                        Simpan

                    </button>

                </form>

            </div>

        </div>

    </div>
</div>

@endsection
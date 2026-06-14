@extends('layout.layout')

@section('title', 'Dashboard User')

@section('content')

<div class="row">

    <div class="col-lg-12">

        <div class="card">

            <div class="card-body text-center">

                <h2>
                    Selamat Datang
                </h2>

                <hr>

                <h4>

                    {{ Auth::user()->name }}

                </h4>

                <p>

                    Login sebagai

                    <strong>

                        USER / ANGGOTA

                    </strong>

                </p>

            </div>

        </div>

    </div>

</div>

@endsection
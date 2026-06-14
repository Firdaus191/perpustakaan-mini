<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Sistem Informasi Perpustakaan</title>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <style>

        html,
        body {

            height: 100%;
            margin: 0;

        }

        .login-form-bg {

            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .login-form-bg .container {

            width: 100%;

        }

    </style>

</head>

<body>

<div class="login-form-bg">

    <div class="container">

        <div class="row justify-content-center align-items-center">

            <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8">

                <div class="form-input-content">

                    <div class="card login-form mb-0 shadow">

                        <div class="card-body">

                            <h3 class="text-center mb-4">

                                Sistem Informasi Perpustakaan

                            </h3>

                            @if(session('success'))

                                <div class="alert alert-success">

                                    {{ session('success') }}

                                </div>

                            @endif

                            @if(session('error'))

                                <div class="alert alert-danger">

                                    {{ session('error') }}

                                </div>

                            @endif

                            <form action="{{ route('login.post') }}" method="POST">

                                @csrf

                                <div class="form-group">

                                    <label>Email</label>

                                    <input
                                        type="email"
                                        name="email"
                                        class="form-control"
                                        required>

                                </div>

                                <div class="form-group">

                                    <label>Password</label>

                                    <input
                                        type="password"
                                        name="password"
                                        class="form-control"
                                        required>

                                </div>

                                <button
                                    type="submit"
                                    class="btn btn-primary btn-block">

                                    Login

                                </button>

                            </form>

                            <hr>

                            <div class="text-center">

                                <small>

                                    © {{ date('Y') }} Perpustakaan Mini

                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>
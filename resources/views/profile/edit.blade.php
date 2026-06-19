@extends('layout.layout')

@section('title', 'Edit Profil')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm rounded-lg bg-white border-left-primary">
            <div class="card-body">
                <h4 class="card-title text-primary font-weight-bold mb-4">Edit Profil</h4>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                        @error('name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <hr>
                    <p class="text-muted small">Kosongkan password jika tidak ingin mengubahnya.</p>

                    <div class="form-group">
                        <label for="password">Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;">
                            <div class="input-group-append" style="cursor: pointer;">
                                <span class="input-group-text" style="background-color: #1E293B; border: 1px solid #475569; color: #94A3B8; border-left: none; border-top-right-radius: 6px; border-bottom-right-radius: 6px;">
                                    <i class="fa fa-eye toggle-password"></i>
                                </span>
                            </div>
                        </div>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;">
                            <div class="input-group-append" style="cursor: pointer;">
                                <span class="input-group-text" style="background-color: #1E293B; border: 1px solid #475569; color: #94A3B8; border-left: none; border-top-right-radius: 6px; border-bottom-right-radius: 6px;">
                                    <i class="fa fa-eye toggle-password"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.input-group-append').forEach(function(append) {
        append.addEventListener('click', function() {
            const input = this.closest('.input-group').querySelector('input');
            const icon = this.querySelector('.toggle-password');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endsection
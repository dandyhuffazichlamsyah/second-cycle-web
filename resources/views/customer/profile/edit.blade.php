@extends('layouts.main')

@section('title', 'Edit Profil')

@section('content')
<!-- Page Header -->
<div class="bg-primary text-white mb-4" style="padding-top: 120px; padding-bottom: 3rem;">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-3 text-center">
                @if($user->avatar)
                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" 
                         class="rounded-circle border border-white border-3" 
                         style="width: 120px; height: 120px; object-fit: cover;" 
                         alt="{{ $user->name }}">
                @else
                    <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center mx-auto" 
                         style="width: 120px; height: 120px; font-size: 2.5rem;">
                        {{ strtoupper(substr($user->name, 0, 2)) }}
                    </div>
                @endif
                
                <button type="button" class="btn btn-light btn-sm mt-3 rounded-pill px-3" onclick="document.getElementById('avatar').click()">
                    <i class="fas fa-camera me-1"></i> Ganti Foto
                </button>
            </div>
            <div class="col-md-9">
                <h2 class="mb-1">{{ $user->name }}</h2>
                <p class="mb-2">{{ $user->email }}</p>
                <span class="badge bg-light text-primary">
                    <i class="fas fa-user me-1"></i>Pelanggan
                </span>
                @if($user->google_id)
                    <span class="badge bg-info ms-2">
                        <i class="fab fa-google me-1"></i>Google Account
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="fas fa-exclamation-circle me-2"></i>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Edit Form -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-edit me-2 text-primary"></i>Informasi Profil
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="{{ old('name', $user->name) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $user->email) }}" required>
                                    @if($user->google_id)
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle"></i> Email terhubung dengan Google
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="{{ old('phone', $user->phone) }}" 
                                           placeholder="0812-3456-7890">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Foto Profil</label>
                                    <input type="file" class="form-control" id="avatar" name="avatar" 
                                           accept="image/*" onchange="previewAvatar(event)">
                                    <small class="text-muted">Format: JPG, PNG, WebP. Max: 2MB</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="address" name="address" rows="3" 
                                      placeholder="Jl. Contoh No. 123, Kelurahan, Kecamatan, Kota, Provinsi">{{ old('address', $user->address) }}</textarea>
                        </div>

                        <!-- Avatar Preview -->
                        <div id="avatarPreview" class="mb-3" style="display: none;">
                            <label class="form-label">Preview Foto Profil</label>
                            <img id="previewImage" src="#" alt="Preview" 
                                 class="rounded-circle border border-primary" 
                                 style="width: 100px; height: 100px; object-fit: cover;">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Change Form -->
            <div class="card shadow-sm mt-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-key me-2 text-warning"></i>Ubah Password
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('profile.password.update') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input type="password" class="form-control" id="current_password" 
                                           name="current_password" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" id="password" 
                                           name="password" required minlength="8">
                                    <small class="text-muted">Minimal 8 karakter</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" 
                                           name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i>Ubah Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-info-circle me-2 text-info"></i>Informasi Akun
                    </h6>
                    <div class="mb-3">
                        <small class="text-muted">ID Pengguna:</small>
                        <div class="fw-bold">#{{ $user->id }}</div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Status Email:</small>
                        <div class="fw-bold">
                            @if($user->email_verified_at)
                                <span class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>Terverifikasi
                                </span>
                            @else
                                <span class="text-warning">
                                    <i class="fas fa-exclamation-circle me-1"></i>Belum Verifikasi
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">Bergabung Sejak:</small>
                        <div class="fw-bold">{{ $user->created_at->format('d F Y') }}</div>
                    </div>
                    <div>
                        <small class="text-muted">Terakhir Update:</small>
                        <div class="fw-bold">{{ $user->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm mt-3">
                <div class="card-body">
                    <h6 class="card-title mb-3">
                        <i class="fas fa-bolt me-2 text-warning"></i>Aksi Cepat
                    </h6>
                    <div class="d-grid gap-2">
                        <a href="{{ route('home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-home me-2"></i>Kembali ke Beranda
                        </a>
                        <a href="{{ route('workshops') }}" class="btn btn-outline-info">
                            <i class="fas fa-wrench me-2"></i>Lihat Workshop
                        </a>
                        <a href="{{ route('contact.show') }}" class="btn btn-outline-success">
                            <i class="fas fa-envelope me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function previewAvatar(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('avatarPreview');
    const previewImage = document.getElementById('previewImage');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
    }
}

// Password strength indicator
document.getElementById('password')?.addEventListener('input', function(e) {
    const password = e.target.value;
    let strength = 0;
    
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]+/)) strength++;
    if (password.match(/[A-Z]+/)) strength++;
    if (password.match(/[0-9]+/)) strength++;
    if (password.match(/[$@#&!]+/)) strength++;
    
    const strengthText = document.getElementById('passwordStrength');
    if (strengthText) {
        if (strength < 3) {
            strengthText.textContent = 'Lemah';
            strengthText.className = 'text-danger';
        } else if (strength < 5) {
            strengthText.textContent = 'Sedang';
            strengthText.className = 'text-warning';
        } else {
            strengthText.textContent = 'Kuat';
            strengthText.className = 'text-success';
        }
    }
});
</script>
@endsection

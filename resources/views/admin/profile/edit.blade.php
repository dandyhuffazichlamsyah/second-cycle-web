@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<div class="admin-content">
    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-center">
        <div>
            <h1 class="page-title">Edit Profil</h1>
            <nav class="page-breadcrumb">
                <a href="{{ route('admin.dashboard') }}">Admin</a> / Profil
            </nav>
        </div>
    </div>

<div class="row">
    <!-- Profile Information -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <div class="mb-3">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" 
                             class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;" 
                             alt="{{ $user->name }}">
                    @else
                        <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white mx-auto" 
                             style="width: 120px; height: 120px; font-size: 2.5rem;">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                    @endif
                    
                    <button type="button" class="btn btn-outline-primary btn-sm mt-3 rounded-pill" onclick="document.getElementById('avatar').click()">
                        <i class="fas fa-camera me-1"></i> Ganti Foto
                    </button>
                </div>
                <h5 class="card-title">{{ $user->name }}</h5>
                <p class="card-text text-muted">{{ $user->email }}</p>
                <span class="badge bg-{{ $user->getRoleColor() }} mb-2">
                    {{ $user->getRoleLabel() }}
                </span>
                <br>
                @if($user->google_id)
                    <span class="badge bg-info">
                        <i class="fab fa-google me-1"></i>Google Account
                    </span>
                @endif
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="card shadow-sm mt-3">
            <div class="card-body">
                <h6 class="card-title mb-3">Informasi Akun</h6>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">ID Pengguna:</small>
                    <small class="fw-bold">#{{ $user->id }}</small>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-muted">Bergabung:</small>
                    <small class="fw-bold">{{ $user->created_at->format('d M Y') }}</small>
                </div>
                <div class="d-flex justify-content-between">
                    <small class="text-muted">Terakhir Update:</small>
                    <small class="fw-bold">{{ $user->updated_at->diffForHumans() }}</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="col-lg-8">
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

        <!-- Profile Edit Form -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2"></i>Informasi Profil
                </h6>
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

                    <div class="mb-3">
                        <label for="avatar" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="avatar" name="avatar" 
                               accept="image/*" onchange="previewAvatar(event)">
                        <small class="text-muted">Format: JPG, PNG, WebP. Max: 2MB</small>
                        
                        <!-- Avatar Preview -->
                        <div id="avatarPreview" class="mt-2" style="display: none;">
                            <img id="previewImage" src="#" alt="Preview" 
                                 class="rounded-circle" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Password Change Form -->
        <div class="card shadow-sm mt-3">
            <div class="card-header bg-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-key me-2"></i>Ubah Password
                </h6>
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
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Kelola Pengguna</h1>
        <nav class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a> / Pengguna
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="fas fa-user-plus me-1"></i> Tambah Pengguna
        </button>
        <a href="{{ route('admin.users.export') }}" class="btn btn-outline-success">
            <i class="fas fa-download me-1"></i> Export
        </a>
    </div>
</div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\User::count() }}</h4>
                            <p class="card-text">Total Pengguna</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\User::where('role', 'customer')->count() }}</h4>
                            <p class="card-text">Customer</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\User::whereIn('role', ['manager', 'admin'])->count() }}</h4>
                            <p class="card-text">Admin Staff</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-tie fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\User::where('role', 'ceo')->count() }}</h4>
                            <p class="card-text">CEO</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-crown fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Pengguna</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nama atau email...">
                    </div>
                    <div class="col-md-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="">Semua Role</option>
                            <option value="customer" {{ request('role') == 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="ceo" {{ request('role') == 'ceo' ? 'selected' : '' }}>CEO</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Users Table -->
    <div class="card">
        <div class="card-body">
            @if(isset($users) && $users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Avatar</th>
                                <th>Informasi Pengguna</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Registrasi</th>
                                <th>Login Terakhir</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <div class="avatar-sm d-inline-block">
                                        @if($user->google_id)
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                                                 class="rounded-circle" style="width: 40px; height: 40px;">
                                        @else
                                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center text-white" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $user->name }}</div>
                                    <a href="mailto:{{ $user->email }}" class="text-decoration-none text-muted">
                                        {{ $user->email }}
                                    </a>
                                    @if($user->google_id)
                                        <span class="badge bg-info ms-1">Google</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-{{ $user->getRoleColor() }}">
                                        {{ $user->getRoleLabel() }}
                                    </span>
                                </td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Terverifikasi
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-clock me-1"></i>Belum Verifikasi
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $user->created_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $user->updated_at->format('d M H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary" onclick="viewUser({{ $user->id }})" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-warning" onclick="editUser({{ $user->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        @if($user->role !== 'ceo')
                                        <button class="btn btn-outline-info" onclick="resetUserPassword({{ $user->id }})" title="Reset Password">
                                            <i class="fas fa-key"></i>
                                        </button>
                                        @endif
                                        @if(auth()->user()->hasCeoAccess() && $user->id !== auth()->id() && $user->role !== 'ceo')
                                        <button class="btn btn-outline-danger" onclick="deleteUser({{ $user->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} 
                            dari {{ $users->total() }} pengguna
                        </small>
                    </div>
                    <div>
                        {{ $users->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada pengguna ditemukan</h5>
                    <p class="text-muted">Coba ubah filter atau tunggu pengguna baru mendaftar.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Add User Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">➕ Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm">
                    @csrf
                    <div class="mb-3">
                        <label for="userName" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="userName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="userEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="userRole" class="form-label">Role</label>
                        <select class="form-select" id="userRole" name="role" required>
                            <option value="">Pilih Role</option>
                            <option value="customer">Customer</option>
                            <option value="manager">Manager</option>
                            <option value="admin">Administrator</option>
                            @if(auth()->user()->hasCeoAccess())
                            <option value="ceo">CEO</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="userPassword" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="userPassword" name="password" required>
                            <button class="btn btn-outline-secondary" type="button" onclick="generatePassword()">
                                <i class="fas fa-random"></i> Generate
                            </button>
                        </div>
                        <small class="text-muted">Minimal 8 karakter</small>
                    </div>
                    <div class="mb-3">
                        <label for="userPasswordConfirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="userPasswordConfirmation" name="password_confirmation" required>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="sendEmail" name="send_email">
                            <label class="form-check-label" for="sendEmail">
                                Kirim email notifikasi ke pengguna
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveUser()">
                    <i class="fas fa-save me-1"></i> Simpan Pengguna
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let editingUserId = null;

function viewUser(id) {
    fetch(`/admin/users/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const user = data.user;
            const modalHtml = `
                <div class="modal fade" id="viewUserModal" tabindex="-1">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">👤 Detail Pengguna</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="text-center">
                                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                                                <i class="fas fa-user fa-3x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <h4>${user.name}</h4>
                                        <p class="text-muted">${user.email}</p>
                                        <div class="mb-3">
                                            <span class="badge bg-${user.getRoleColor()}">${user.getRoleLabel()}</span>
                                            <span class="badge bg-${user.email_verified_at ? 'success' : 'warning'}">
                                                ${user.email_verified_at ? 'Aktif' : 'Tidak Aktif'}
                                            </span>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <small class="text-muted">Google ID</small>
                                                <p class="mb-2">${user.google_id || 'Manual Registration'}</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <small class="text-muted">Terdaftar</small>
                                                <p class="mb-2">${new Date(user.created_at).toLocaleDateString('id-ID')}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            const existingModal = document.getElementById('viewUserModal');
            if (existingModal) existingModal.remove();
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const modal = new bootstrap.Modal(document.getElementById('viewUserModal'));
            modal.show();
        } else {
            showAlert('error', 'Gagal memuat detail pengguna');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat memuat detail pengguna');
    });
}

function editUser(id) {
    fetch(`/admin/users/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const user = data.user;
            editingUserId = id;
            
            document.getElementById('userName').value = user.name;
            document.getElementById('userEmail').value = user.email;
            document.getElementById('userRole').value = user.role;
            
            document.querySelector('#addUserModal .modal-title').innerHTML = '✏️ Edit Pengguna';
            
            const modal = new bootstrap.Modal(document.getElementById('addUserModal'));
            modal.show();
        } else {
            showAlert('error', 'Gagal memuat data pengguna');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat memuat data pengguna');
    });
}

function toggleUserStatus(id) {
    if (confirm('Apakah Anda ingin mengubah status pengguna ini?')) {
        fetch(`/admin/users/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                location.reload();
            } else {
                showAlert('error', 'Gagal mengubah status');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat mengubah status');
        });
    }
}

function resetUserPassword(id) {
    const newPassword = prompt('Masukkan password baru (minimal 8 karakter):');
    if (newPassword && newPassword.length >= 8) {
        const confirmPassword = prompt('Konfirmasi password baru:');
        if (newPassword === confirmPassword) {
            fetch(`/admin/users/${id}/reset-password`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    password: newPassword,
                    password_confirmation: confirmPassword
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showAlert('success', data.message);
                } else {
                    showAlert('error', 'Gagal reset password');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('error', 'Terjadi kesalahan saat reset password');
            });
        } else {
            showAlert('error', 'Password konfirmasi tidak cocok');
        }
    } else if (newPassword) {
        showAlert('error', 'Password minimal 8 karakter');
    }
}

function deleteUser(id) {
    if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
        fetch(`/admin/users/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                location.reload();
            } else {
                showAlert('error', 'Gagal menghapus pengguna');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat menghapus pengguna');
        });
    }
}

function saveUser() {
    const form = document.getElementById('addUserForm');
    const formData = new FormData(form);
    const isEdit = editingUserId !== null;
    
    const url = isEdit ? `/admin/users/${editingUserId}` : '/admin/users';
    const method = isEdit ? 'PUT' : 'POST';
    
    if (isEdit) {
        formData.append('_method', 'PUT');
    }
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('addUserModal'));
            modal.hide();
            
            form.reset();
            editingUserId = null;
            document.querySelector('#addUserModal .modal-title').innerHTML = '➕ Tambah Pengguna Baru';
            
            location.reload();
        } else {
            showAlert('error', 'Gagal menyimpan pengguna');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat menyimpan pengguna');
    });
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;" role="alert">
            ${message}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    setTimeout(() => {
        const alert = document.querySelector('.alert.position-fixed');
        if (alert) alert.remove();
    }, 5000);
}

document.getElementById('addUserModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('addUserForm').reset();
    editingUserId = null;
    document.querySelector('#addUserModal .modal-title').innerHTML = '➕ Tambah Pengguna Baru';
});
</script>
@endsection

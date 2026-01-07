@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Pengaturan Sistem</h1>
        <nav class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a> / System Settings
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-success" onclick="backupDatabase()">
            <i class="fas fa-download me-1"></i> Backup Database
        </button>
        <button class="btn btn-warning" onclick="clearCache()">
            <i class="fas fa-broom me-1"></i> Clear Cache
        </button>
    </div>
</div>

    <!-- CEO Access Warning -->
    <div class="alert alert-danger border-0 bg-danger text-white">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle me-3 fa-2x"></i>
            <div>
                <h6 class="alert-heading mb-1">⚠️ CEO ONLY ACCESS</h6>
                <p class="mb-0">Halaman ini hanya dapat diakses oleh CEO. Perubahan di sini akan mempengaruhi seluruh sistem.</p>
            </div>
        </div>
    </div>

    <!-- System Overview -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\User::count() }}</h4>
                            <p class="card-text">Total Users</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\Product::count() }}</h4>
                            <p class="card-text">Total Products</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-motorcycle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\ContactMessage::count() }}</h4>
                            <p class="card-text">Total Messages</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-envelope fa-2x"></i>
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
                            <h4 class="card-title">{{ config('app.version', '1.0.0') }}</h4>
                            <p class="card-text">System Version</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-code-branch fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Tabs -->
    <div class="card">
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs" id="settingsTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="general-tab" data-bs-toggle="tab" data-bs-target="#general" type="button" role="tab">
                        <i class="fas fa-cog me-1"></i> General
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="security-tab" data-bs-toggle="tab" data-bs-target="#security" type="button" role="tab">
                        <i class="fas fa-shield-alt me-1"></i> Security
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="email-tab" data-bs-toggle="tab" data-bs-target="#email" type="button" role="tab">
                        <i class="fas fa-envelope me-1"></i> Email
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="backup-tab" data-bs-toggle="tab" data-bs-target="#backup" type="button" role="tab">
                        <i class="fas fa-database me-1"></i> Backup
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="settingsTabContent">
                <!-- General Settings -->
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <h5 class="mb-4">📋 Pengaturan Umum</h5>
                    <form id="generalSettingsForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="siteName" class="form-label">Nama Website</label>
                                    <input type="text" class="form-control" id="siteName" name="site_name" value="SecondCycle">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="siteEmail" class="form-label">Email System</label>
                                    <input type="email" class="form-control" id="siteEmail" name="site_email" value="info@secondcycle.id">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sitePhone" class="form-label">Nomor Telepon</label>
                                    <input type="tel" class="form-control" id="sitePhone" name="site_phone" value="+62 877-6900-2763">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="siteAddress" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" id="siteAddress" name="site_address" value="Jl. Sudirman No. 123, Jakarta Pusat">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="siteDescription" class="form-label">Deskripsi Website</label>
                            <textarea class="form-control" id="siteDescription" name="site_description" rows="3">Platform motor bekas berkualitas dengan sistem terpercaya dan pelayanan terbaik.</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="maintenanceMode" name="maintenance_mode">
                                    <label class="form-check-label" for="maintenanceMode">
                                        Maintenance Mode
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="userRegistration" name="user_registration" checked>
                                    <label class="form-check-label" for="userRegistration">
                                        Allow User Registration
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="googleOAuth" name="google_oauth" checked>
                                    <label class="form-check-label" for="googleOAuth">
                                        Enable Google OAuth
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="btn btn-primary" onclick="saveGeneralSettings()">
                                <i class="fas fa-save me-1"></i> Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Security Settings -->
                <div class="tab-pane fade" id="security" role="tabpanel">
                    <h5 class="mb-4">🔐 Pengaturan Keamanan</h5>
                    <form id="securitySettingsForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sessionTimeout" class="form-label">Session Timeout (menit)</label>
                                    <input type="number" class="form-control" id="sessionTimeout" name="session_timeout" value="120" min="5" max="1440">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="maxLoginAttempts" class="form-label">Max Login Attempts</label>
                                    <input type="number" class="form-control" id="maxLoginAttempts" name="max_login_attempts" value="5" min="3" max="10">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="twoFactorAuth" name="two_factor_auth">
                                    <label class="form-check-label" for="twoFactorAuth">
                                        Two-Factor Authentication
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="ipWhitelist" name="ip_whitelist">
                                    <label class="form-check-label" for="ipWhitelist">
                                        IP Whitelist for Admin
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="auditLogging" name="audit_logging" checked>
                                    <label class="form-check-label" for="auditLogging">
                                        Enable Audit Logging
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="allowedIPs" class="form-label">Allowed IP Addresses (comma separated)</label>
                            <textarea class="form-control" id="allowedIPs" name="allowed_ips" rows="2" placeholder="192.168.1.1, 10.0.0.1"></textarea>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="btn btn-primary" onclick="saveSecuritySettings()">
                                <i class="fas fa-save me-1"></i> Simpan Pengaturan
                            </button>
                            <button type="button" class="btn btn-warning ms-2" onclick="clearAllSessions()">
                                <i class="fas fa-sign-out-alt me-1"></i> Clear All Sessions
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Email Settings -->
                <div class="tab-pane fade" id="email" role="tabpanel">
                    <h5 class="mb-4">📧 Pengaturan Email</h5>
                    <form id="emailSettingsForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mailDriver" class="form-label">Mail Driver</label>
                                    <select class="form-select" id="mailDriver" name="mail_driver">
                                        <option value="smtp">SMTP</option>
                                        <option value="mail">PHP Mail</option>
                                        <option value="sendmail">Sendmail</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="mailHost" class="form-label">SMTP Host</label>
                                    <input type="text" class="form-control" id="mailHost" name="mail_host" value="smtp.gmail.com">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="mailPort" class="form-label">SMTP Port</label>
                                    <input type="number" class="form-control" id="mailPort" name="mail_port" value="587">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="mailUsername" class="form-label">SMTP Username</label>
                                    <input type="email" class="form-control" id="mailUsername" name="mail_username">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="mailPassword" class="form-label">SMTP Password</label>
                                    <input type="password" class="form-control" id="mailPassword" name="mail_password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailVerification" name="email_verification" checked>
                                    <label class="form-check-label" for="emailVerification">
                                        Email Verification Required
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="emailNotifications" name="email_notifications" checked>
                                    <label class="form-check-label" for="emailNotifications">
                                        Send Email Notifications
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4">
                            <button type="button" class="btn btn-primary" onclick="saveEmailSettings()">
                                <i class="fas fa-save me-1"></i> Simpan Pengaturan
                            </button>
                            <button type="button" class="btn btn-info ms-2" onclick="testEmailSettings()">
                                <i class="fas fa-paper-plane me-1"></i> Kirim Email Test
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Backup Settings -->
                <div class="tab-pane fade" id="backup" role="tabpanel">
                    <h5 class="mb-4">💾 Backup & Restore</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">📦 Backup Database</h6>
                                    <p class="card-text">Download backup lengkap database SecondCycle.</p>
                                    <button class="btn btn-success" onclick="backupDatabase()">
                                        <i class="fas fa-download me-1"></i> Download Backup
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">📁 Backup Files</h6>
                                    <p class="card-text">Download backup semua file upload dan assets.</p>
                                    <button class="btn btn-info" onclick="backupFiles()">
                                        <i class="fas fa-download me-1"></i> Backup Files
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">🔄 Auto Backup</h6>
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="autoBackup" name="auto_backup">
                                        <label class="form-check-label" for="autoBackup">
                                            Enable Automatic Backup
                                        </label>
                                    </div>
                                    <select class="form-select" id="backupFrequency" name="backup_frequency">
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="card-title text-warning">⚠️ Restore System</h6>
                                    <p class="card-text text-warning">Restore dari backup file.</p>
                                    <input type="file" class="form-control mb-2" id="restoreFile" accept=".sql,.zip">
                                    <button class="btn btn-warning" onclick="restoreSystem()">
                                        <i class="fas fa-upload me-1"></i> Restore
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function saveGeneralSettings() {
    // TODO: Implement save general settings via AJAX
    alert('Simpan pengaturan umum (AJAX implementation needed)');
}

function saveSecuritySettings() {
    // TODO: Implement save security settings via AJAX
    alert('Simpan pengaturan keamanan (AJAX implementation needed)');
}

function clearAllSessions() {
    if (confirm('Apakah Anda ingin menghapus semua session aktif? Semua pengguna akan logout otomatis.')) {
    }
}

function backupDatabase() {
    if (confirm('Apakah Anda yakin ingin membuat backup database?')) {
        fetch('/admin/system-settings/backup', {
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
                loadSystemStats(); // Refresh stats to show new backup
            } else {
                showAlert('error', 'Gagal membuat backup');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat membuat backup');
        });
}

function backupFiles() {
    // TODO: Implement files backup
    alert('Download backup files (AJAX implementation needed)');
}

function restoreSystem() {
    const fileInput = document.getElementById('restoreFile');
    if (!fileInput.files.length) {
        alert('Pilih file backup terlebih dahulu!');
        return;
    }
    
    if (confirm('PERINGATAN: Restore akan menghapus semua data saat ini dan menggantinya dengan backup. Lanjutkan?')) {
        // TODO: Implement system restore
        alert('Restore sistem dari backup (AJAX implementation needed)');
    }
}
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Audit Log')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Audit Log</h1>
        <nav class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a> / Audit Log
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-success" onclick="exportAuditLog()">
            <i class="fas fa-download me-1"></i> Export Log
        </button>
        <button class="btn btn-warning" onclick="clearOldLogs()">
            <i class="fas fa-trash me-1"></i> Hapus Log Lama
        </button>
    </div>
</div>

    <!-- CEO Access Warning -->
    <div class="alert alert-danger border-0 bg-danger text-white mb-4">
        <div class="d-flex align-items-center">
            <i class="fas fa-lock me-3 fa-2x"></i>
            <div>
                <h6 class="alert-heading mb-1">🔒 CEO ONLY ACCESS</h6>
                <p class="mb-0">Audit log hanya dapat diakses oleh CEO untuk monitoring keamanan sistem.</p>
            </div>
        </div>
    </div>

    <!-- Statistics -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">1,234</h4>
                            <p class="card-text">Total Activities</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x"></i>
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
                            <h4 class="card-title">456</h4>
                            <p class="card-text">Today</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-day fa-2x"></i>
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
                            <h4 class="card-title">23</h4>
                            <p class="card-text">Failed Logins</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
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
                            <h4 class="card-title">5</h4>
                            <p class="card-text">Security Alerts</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-shield-alt fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.audit-log') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="action" class="form-label">Action Type</label>
                        <select class="form-select" id="action" name="action">
                            <option value="">All Actions</option>
                            <option value="login">Login</option>
                            <option value="logout">Logout</option>
                            <option value="create">Create</option>
                            <option value="update">Update</option>
                            <option value="delete">Delete</option>
                            <option value="export">Export</option>
                            <option value="security">Security</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="user" class="form-label">User</label>
                        <select class="form-select" id="user" name="user">
                            <option value="">All Users</option>
                            <option value="dandy@secondcycle.id">Dandy CEO</option>
                            <option value="admin@secondcycle.id">Admin</option>
                            <option value="manager@secondcycle.id">Manager</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="dateFrom" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="dateFrom" name="date_from">
                    </div>
                    <div class="col-md-3">
                        <label for="dateTo" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="dateTo" name="date_to">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-9">
                        <label for="search" class="form-label">Search Description</label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search in activity descriptions...">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Filter Logs
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Log Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Resource</th>
                            <th>Description</th>
                            <th>IP Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample audit log entries -->
                        <tr>
                            <td>
                                <small>{{ now()->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ now()->format('H:i:s') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                        DC
                                    </div>
                                    <div>
                                        <div class="fw-bold">Dandy CEO</div>
                                        <small class="text-muted">dandy@secondcycle.id</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-warning">UPDATE</span>
                            </td>
                            <td>
                                <span class="text-muted">System Settings</span>
                            </td>
                            <td>
                                <small>Modified email configuration settings in admin panel</small>
                            </td>
                            <td>
                                <small class="text-muted">192.168.1.100</small>
                            </td>
                            <td>
                                <span class="badge bg-success">Success</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>{{ now()->subMinutes(15)->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ now()->subMinutes(15)->format('H:i:s') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                        AS
                                    </div>
                                    <div>
                                        <div class="fw-bold">Admin Staff</div>
                                        <small class="text-muted">admin@secondcycle.id</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-info">CREATE</span>
                            </td>
                            <td>
                                <span class="text-muted">Product</span>
                            </td>
                            <td>
                                <small>Added new product: Honda Vario 160</small>
                            </td>
                            <td>
                                <small class="text-muted">192.168.1.101</small>
                            </td>
                            <td>
                                <span class="badge bg-success">Success</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>{{ now()->subMinutes(30)->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ now()->subMinutes(30)->format('H:i:s') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Unknown</div>
                                        <small class="text-muted">unknown@hacker.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-danger">LOGIN</span>
                            </td>
                            <td>
                                <span class="text-muted">Authentication</span>
                            </td>
                            <td>
                                <small>Failed login attempt with invalid credentials</small>
                            </td>
                            <td>
                                <small class="text-muted">203.0.113.1</small>
                            </td>
                            <td>
                                <span class="badge bg-danger">Failed</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>{{ now()->subHour()->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ now()->subHour()->format('H:i:s') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-info text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                        MS
                                    </div>
                                    <div>
                                        <div class="fw-bold">Manager</div>
                                        <small class="text-muted">manager@secondcycle.id</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-success">EXPORT</span>
                            </td>
                            <td>
                                <span class="text-muted">Contact Messages</span>
                            </td>
                            <td>
                                <small>Exported contact messages to CSV file</small>
                            </td>
                            <td>
                                <small class="text-muted">192.168.1.102</small>
                            </td>
                            <td>
                                <span class="badge bg-success">Success</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>{{ now()->subHours(2)->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ now()->subHours(2)->format('H:i:s') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-danger text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                        DC
                                    </div>
                                    <div>
                                        <div class="fw-bold">Dandy CEO</div>
                                        <small class="text-muted">dandy@secondcycle.id</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-danger">DELETE</span>
                            </td>
                            <td>
                                <span class="text-muted">User</span>
                            </td>
                            <td>
                                <small>Deleted user account: test@example.com</small>
                            </td>
                            <td>
                                <small class="text-muted">192.168.1.100</small>
                            </td>
                            <td>
                                <span class="badge bg-success">Success</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <small>{{ now()->subHours(3)->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ now()->subHours(3)->format('H:i:s') }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width: 30px; height: 30px; font-size: 12px;">
                                        <i class="fab fa-google"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">Customer</div>
                                        <small class="text-muted">customer@gmail.com</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-primary">LOGIN</span>
                            </td>
                            <td>
                                <span class="text-muted">OAuth</span>
                            </td>
                            <td>
                                <small>Logged in via Google OAuth</small>
                            </td>
                            <td>
                                <small class="text-muted">203.0.113.50</small>
                            </td>
                            <td>
                                <span class="badge bg-success">Success</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <small class="text-muted">
                        Menampilkan 1-6 dari 1,234 aktivitas
                    </small>
                </div>
                <div>
                    <nav>
                        <ul class="pagination pagination-sm mb-0">
                            <li class="page-item disabled">
                                <a class="page-link" href="#" tabindex="-1">Previous</a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="#">Next</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
function exportAuditLog() {
    if (confirm('Apakah Anda ingin mengekspor audit log saat ini?')) {
        // TODO: Implement export audit log
        alert('Export audit log (AJAX implementation needed)');
    }
}

function clearOldLogs() {
    if (confirm('Apakah Anda ingin menghapus audit log yang lebih tua dari 30 hari? Tindakan ini tidak dapat dibatalkan!')) {
        // TODO: Implement clear old logs
        alert('Hapus log lama (AJAX implementation needed)');
    }
}

// Auto-refresh audit log every 30 seconds
setInterval(function() {
    // TODO: Implement auto-refresh via AJAX
    console.log('Auto-refreshing audit log...');
}, 30000);
</script>
@endsection
@endsection

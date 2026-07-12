@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light">
    <div>
        <h1 class="h3 fw-bold mb-0 text-dark">Dashboard</h1>
        <small class="text-secondary">Statistik dan aktivitas platform terkini</small>
    </div>
    <div>
        <button class="btn btn-outline-dark me-2" onclick="exportData()">
            <i class="fas fa-download me-1"></i> Export CSV
        </button>
        <button class="btn btn-primary" onclick="refreshDashboard()">
            <i class="fas fa-sync-alt me-1"></i> Refresh
        </button>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-4 mb-4">
    <!-- Total Users Card -->
    <div class="col-xl-3 col-md-6">
        <div class="p-4 bg-white border border-light h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-secondary small fw-semibold text-uppercase tracking-wider">Total Users</span>
                    <h3 class="fw-bold mb-0 mt-2 text-dark">{{ $stats['total_users'] }}</h3>
                </div>
                <div class="p-2 bg-light border border-light text-dark">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Products Card -->
    <div class="col-xl-3 col-md-6">
        <div class="p-4 bg-white border border-light h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-secondary small fw-semibold text-uppercase tracking-wider">Total Products</span>
                    <h3 class="fw-bold mb-0 mt-2 text-dark">{{ $stats['total_products'] }}</h3>
                </div>
                <div class="p-2 bg-light border border-light text-dark">
                    <i class="fas fa-motorcycle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Contacts Card -->
    <div class="col-xl-3 col-md-6">
        <div class="p-4 bg-white border border-light h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-secondary small fw-semibold text-uppercase tracking-wider">Total Contacts</span>
                    <h3 class="fw-bold mb-0 mt-2 text-dark">{{ $stats['total_contacts'] }}</h3>
                </div>
                <div class="p-2 bg-light border border-light text-dark">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Users Card -->
    <div class="col-xl-3 col-md-6">
        <div class="p-4 bg-white border border-light h-100">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <span class="text-secondary small fw-semibold text-uppercase tracking-wider">Active Users</span>
                    <h3 class="fw-bold mb-0 mt-2 text-dark">{{ $stats['active_users'] }}</h3>
                </div>
                <div class="p-2 bg-light border border-light text-dark">
                    <i class="fas fa-user-check"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <!-- Contact Messages Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="bg-white border border-light p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
                <h6 class="fw-bold mb-0 text-dark">Tren Pesan Masuk (7 Hari Terakhir)</h6>
                <button class="btn btn-sm btn-outline-dark" onclick="refreshCharts()">🔄 Reload</button>
            </div>
            <div class="chart-area" style="height: 250px;">
                <canvas id="contactMessagesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Department Distribution -->
    <div class="col-xl-4 col-lg-5">
        <div class="bg-white border border-light p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
                <h6 class="fw-bold mb-0 text-dark">Distribusi Hak Akses</h6>
            </div>
            <div class="chart-pie" style="height: 200px;">
                <canvas id="departmentChart"></canvas>
            </div>
            <div class="mt-4 d-flex flex-wrap justify-content-center gap-3 small">
                <span><i class="fas fa-circle me-1" style="color:#18181b;"></i> Customer</span>
                <span><i class="fas fa-circle me-1" style="color:#10b981;"></i> Manager</span>
                <span><i class="fas fa-circle me-1" style="color:#3b82f6;"></i> Admin</span>
                <span><i class="fas fa-circle me-1" style="color:#f59e0b;"></i> CEO</span>
            </div>
        </div>
    </div>
</div>

<!-- Today's Stats Row -->
<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="p-3 bg-light border border-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-semibold">Pengguna Baru Hari Ini</span>
                    <h4 class="fw-bold mb-0 text-dark mt-1">{{ $stats['new_users_today'] }}</h4>
                </div>
                <i class="fas fa-user-plus text-secondary opacity-50 fs-3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 bg-light border border-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-semibold">Produk Baru Hari Ini</span>
                    <h4 class="fw-bold mb-0 text-dark mt-1">{{ $stats['new_products_today'] }}</h4>
                </div>
                <i class="fas fa-plus-circle text-secondary opacity-50 fs-3"></i>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="p-3 bg-light border border-light">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="text-secondary small fw-semibold">Pesan Baru Hari Ini</span>
                    <h4 class="fw-bold mb-0 text-dark mt-1">{{ $stats['new_contacts_today'] }}</h4>
                </div>
                <i class="fas fa-envelope-open text-secondary opacity-50 fs-3"></i>
            </div>
        </div>
    </div>
</div>

<!-- Recent Messages & Quick Actions -->
<div class="row g-4">
    <!-- Recent Messages -->
    <div class="col-lg-6">
        <div class="bg-white border border-light p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
                <h6 class="fw-bold mb-0 text-dark">Pesan Masuk Terbaru</h6>
                <a href="{{ route('admin.contacts') }}" class="btn btn-sm btn-outline-dark">Lihat Semua</a>
            </div>
            <div style="max-height: 400px; overflow-y: auto;">
                @forelse($recentContacts as $message)
                <div class="p-3 border border-light mb-3 {{ !$message->read ? 'bg-light' : '' }}">
                    <div class="d-flex justify-content-between">
                        <strong class="text-dark small">{{ $message->name }}</strong>
                        <small class="text-secondary" style="font-size: 0.75rem;">{{ $message->created_at->diffForHumans() }}</small>
                    </div>
                    <span class="text-secondary small d-block mb-2">{{ $message->email }}</span>
                    <p class="mb-0 text-secondary small">{{ Str::limit($message->message, 100) }}</p>
                </div>
                @empty
                <div class="text-center py-4">
                    <p class="text-secondary small mb-0">Belum ada pesan masuk</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Recent Users -->
    <div class="col-lg-6">
        <div class="bg-white border border-light p-4">
            <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom border-light">
                <h6 class="fw-bold mb-0 text-dark">Pengguna Baru Terdaftar</h6>
                <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-dark">Lihat Semua</a>
            </div>
            <div style="max-height: 400px; overflow-y: auto;">
                @forelse($recentUsers as $user)
                <div class="d-flex align-items-center justify-content-between p-3 border border-light mb-2">
                    <div>
                        <strong class="text-dark small d-block">{{ $user->name }}</strong>
                        <small class="text-secondary" style="font-size: 0.75rem;">{{ $user->email }}</small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-dark small" style="font-size: 0.65rem;">{{ strtoupper($user->getRoleLabel()) }}</span>
                        <small class="text-secondary d-block mt-1" style="font-size: 0.75rem;">{{ $user->created_at->diffForHumans() }}</small>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <p class="text-secondary small mb-0">Belum ada pengguna terdaftar</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Contact Messages Chart
const ctx1 = document.getElementById('contactMessagesChart').getContext('2d');
const contactMessagesChart = new Chart(ctx1, {
    type: 'line',
    data: {
        labels: @json($chartData['labels']),
        datasets: [{
            label: 'Pesan Masuk',
            data: @json($chartData['contact_messages']),
            borderColor: '#18181b',
            backgroundColor: 'rgba(24, 24, 27, 0.02)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// User Role Distribution Chart
const ctx2 = document.getElementById('departmentChart').getContext('2d');
const departmentChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: ['Customers', 'Managers', 'Admins', 'CEOs'],
        datasets: [{
            data: [
                {{ $userRoles['customers'] }},
                {{ $userRoles['managers'] }},
                {{ $userRoles['admins'] }},
                {{ $userRoles['ceos'] }}
            ],
            backgroundColor: ['#18181b', '#10b981', '#3b82f6', '#f59e0b'],
            hoverBackgroundColor: ['#09090b', '#059669', '#2563eb', '#d97706'],
        }],
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

// Export Dashboard Data to CSV
function exportData() {
    const csvContent = "data:text/csv;charset=utf-8," 
        + "Metric,Value\n"
        + "Total Users,{{ $stats['total_users'] }}\n"
        + "Total Products,{{ $stats['total_products'] }}\n"
        + "Total Contacts,{{ $stats['total_contacts'] }}\n"
        + "Active Users,{{ $stats['active_users'] }}\n"
        + "New Users Today,{{ $stats['new_users_today'] }}\n"
        + "New Products Today,{{ $stats['new_products_today'] }}\n"
        + "New Contacts Today,{{ $stats['new_contacts_today'] }}\n"
        + "\nUser Roles Distribution\n"
        + "Customers,{{ $userRoles['customers'] }}\n"
        + "Managers,{{ $userRoles['managers'] }}\n"
        + "Admins,{{ $userRoles['admins'] }}\n"
        + "CEOs,{{ $userRoles['ceos'] }}\n";
    
    const encodedUri = encodeURI(csvContent);
    const link = document.createElement("a");
    link.setAttribute("href", encodedUri);
    link.setAttribute("download", "dashboard_export_" + new Date().toISOString().slice(0,10) + ".csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
    
    showAlert('success', 'Data berhasil di-export!');
}

// Refresh Dashboard
function refreshDashboard() {
    showAlert('info', 'Memuat ulang dashboard...');
    setTimeout(() => {
        location.reload();
    }, 500);
}

// Refresh Charts via AJAX
function refreshCharts() {
    fetch('{{ route("admin.dashboard.stats") }}', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update statistics cards
            document.querySelectorAll('.border-left-primary .h5').forEach(el => el.textContent = data.stats.total_users);
            document.querySelectorAll('.border-left-success .h5').forEach(el => el.textContent = data.stats.total_products);
            document.querySelectorAll('.border-left-info .h5').forEach(el => el.textContent = data.stats.total_contacts);
            document.querySelectorAll('.border-left-warning .h5').forEach(el => el.textContent = data.stats.active_users);
            
            showAlert('success', 'Data dashboard berhasil diperbarui!');
        } else {
            showAlert('danger', 'Gagal memperbarui data dashboard');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('danger', 'Terjadi kesalahan saat memperbarui data');
    });
}

// Show Alert Notification
function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    setTimeout(() => {
        const alert = document.querySelector('.alert.position-fixed');
        if (alert) alert.remove();
    }, 5000);
}

// Auto-refresh dashboard stats every 60 seconds
setInterval(function() {
    refreshCharts();
}, 60000);
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <nav class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a> / Dashboard
        </nav>
    </div>
    <div>
        <button class="btn btn-primary" onclick="refreshDashboard()">
            <i class="fas fa-sync-alt me-1"></i> Refresh
        </button>
    </div>
</div>

    <!-- Stats Cards -->
    <div class="row">
        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_users'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total Products
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_products'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-motorcycle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Contacts Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Contacts
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total_contacts'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-envelope fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Active Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Active Users
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['active_users'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Contact Messages Chart -->
        <div class="col-xl-8 col-lg-7 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">📈 Tren Pesan Kontak (7 Hari Terakhir)</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in">
                            <a class="dropdown-item" href="#" onclick="refreshCharts()">🔄 Refresh Data</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('admin.contacts') }}">📋 Lihat Detail</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="contactMessagesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department Distribution -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">🏢 Distribusi Departemen</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="departmentChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Customers
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Managers
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Admins
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-warning"></i> CEOs
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Stats Row -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pengguna Baru Hari Ini</h6>
                            <h3 class="mb-0">{{ $stats['new_users_today'] }}</h3>
                        </div>
                        <i class="fas fa-user-plus fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Produk Baru Hari Ini</h6>
                            <h3 class="mb-0">{{ $stats['new_products_today'] }}</h3>
                        </div>
                        <i class="fas fa-plus-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-info text-white shadow">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-white-50 mb-1">Pesan Baru Hari Ini</h6>
                            <h3 class="mb-0">{{ $stats['new_contacts_today'] }}</h3>
                        </div>
                        <i class="fas fa-envelope-open fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Messages & Quick Actions -->
    <div class="row">
        <!-- Recent Messages -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">📨 Pesan Terbaru</h6>
                    <a href="{{ route('admin.contacts') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if($recentContacts->count() > 0)
                        @foreach($recentContacts as $message)
                        <div class="d-flex align-items-start mb-3 p-3 border rounded {{ !$message->read ? 'bg-light border-primary' : '' }}">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar bg-{{ !$message->read ? 'primary' : 'secondary' }} text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($message->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">{{ $message->name }}</h6>
                                        <p class="mb-1 text-muted small">{{ $message->email }}</p>
                                    </div>
                                    <small class="text-muted">{{ $message->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-0 mt-1 text-muted">{{ Str::limit($message->message, 80) }}</p>
                                @if($message->department)
                                    <span class="badge bg-secondary mt-1">{{ ucfirst($message->department) }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Belum ada pesan masuk</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">👥 Pengguna Terbaru</h6>
                    <a href="{{ route('admin.users') }}" class="btn btn-sm btn-outline-success">Lihat Semua</a>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @if($recentUsers->count() > 0)
                        @foreach($recentUsers as $user)
                        <div class="d-flex align-items-center mb-3 p-2 border rounded">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar bg-{{ $user->getRoleColor() }} text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->email }}</small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-{{ $user->getRoleColor() }}">{{ $user->getRoleLabel() }}</span>
                                <br>
                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Belum ada pengguna terdaftar</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Products -->
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">⚡ Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.contacts') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-envelope text-info me-2"></i>
                                Kelola Pesan
                            </div>
                            <span class="badge bg-info rounded-pill">{{ $stats['new_contacts_today'] }}</span>
                        </a>
                        <a href="{{ route('admin.products') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-motorcycle text-success me-2"></i>
                                Kelola Produk
                            </div>
                            <span class="badge bg-success rounded-pill">{{ $stats['total_products'] }}</span>
                        </a>
                        <a href="{{ route('admin.users') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-users text-primary me-2"></i>
                                Kelola Pengguna
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $stats['total_users'] }}</span>
                        </a>
                        @if(auth()->user()->hasCeoAccess())
                        <a href="{{ route('admin.system-settings') }}" class="list-group-item list-group-item-action">
                            <i class="fas fa-cog text-warning me-2"></i>
                            System Settings
                        </a>
                        @endif
                    </div>
                    
                    <hr>
                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-primary" onclick="exportData()">
                            <i class="fas fa-download me-1"></i> Export Data
                        </button>
                        <button class="btn btn-outline-success" onclick="refreshDashboard()">
                            <i class="fas fa-sync me-1"></i> Refresh Dashboard
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-warning">🏍️ Produk Terbaru</h6>
                    <a href="{{ route('admin.products') }}" class="btn btn-sm btn-outline-warning">Lihat Semua</a>
                </div>
                <div class="card-body">
                    @if($recentProducts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Ditambahkan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentProducts as $product)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($product->image)
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                            <div class="bg-secondary rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-motorcycle text-white"></i>
                                            </div>
                                            @endif
                                            <div>
                                                <strong>{{ Str::limit($product->name, 30) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $product->brand ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                    <td>
                                        @if($product->status == 'available')
                                            <span class="badge bg-success">Tersedia</span>
                                        @elseif($product->status == 'sold')
                                            <span class="badge bg-danger">Terjual</span>
                                        @else
                                            <span class="badge bg-warning">{{ ucfirst($product->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-motorcycle fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">Belum ada produk</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.chart-area {
    position: relative;
    height: 20rem;
    width: 100%;
}
.chart-pie {
    position: relative;
    height: 15rem;
    width: 100%;
}
</style>
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
            borderColor: '#4e73df',
            backgroundColor: 'rgba(78, 115, 223, 0.05)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
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
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#858796'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#f4b619', '#60616f'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
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
            document.querySelector('.border-left-primary .h5').textContent = data.stats.total_users;
            document.querySelector('.border-left-success .h5').textContent = data.stats.total_products;
            document.querySelector('.border-left-info .h5').textContent = data.stats.total_contacts;
            document.querySelector('.border-left-warning .h5').textContent = data.stats.active_users;
            
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

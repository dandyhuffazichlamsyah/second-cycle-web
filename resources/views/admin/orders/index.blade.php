@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Kelola Pesanan</h1>
        <nav class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a> / Pesanan
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.orders.export') }}" class="btn btn-outline-success">
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
                        <h4 class="card-title">{{ $stats['total'] }}</h4>
                        <p class="card-text">Total Pesanan</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-shopping-cart fa-2x"></i>
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
                        <h4 class="card-title">{{ $stats['pending'] }}</h4>
                        <p class="card-text">Menunggu</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
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
                        <h4 class="card-title">{{ $stats['approved'] }}</h4>
                        <p class="card-text">Disetujui</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
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
                        <h4 class="card-title">{{ $stats['completed'] }}</h4>
                        <p class="card-text">Selesai</p>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-flag-checkered fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.orders') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Pesanan</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="No. Order, nama, email...">
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="payment_type" class="form-label">Pembayaran</label>
                    <select class="form-select" id="payment_type" name="payment_type">
                        <option value="">Semua Tipe</option>
                        <option value="cash" {{ request('payment_type') == 'cash' ? 'selected' : '' }}>Tunai</option>
                        <option value="dp" {{ request('payment_type') == 'dp' ? 'selected' : '' }}>DP</option>
                        <option value="credit" {{ request('payment_type') == 'credit' ? 'selected' : '' }}>Kredit</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Filter
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Orders Table -->
<div class="card">
    <div class="card-body">
        @if(isset($orders) && $orders->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Pembayaran</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <span class="fw-bold text-primary">#{{ $order->order_number }}</span>
                            </td>
                            <td>
                                <div class="fw-bold">{{ $order->customer_name }}</div>
                                <small class="text-muted">{{ $order->customer_email }}</small>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($order->product && $order->product->image)
                                        <img src="{{ asset('storage/' . $order->product->image) }}" 
                                             class="rounded me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-2" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-motorcycle text-white"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-bold">{{ Str::limit($order->product->name ?? 'N/A', 20) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_type === 'cash' ? 'success' : ($order->payment_type === 'dp' ? 'info' : 'primary') }}">
                                    {{ $order->payment_type_label }}
                                </span>
                                @if($order->payment_type === 'credit')
                                    <br><small class="text-muted">{{ $order->credit_months }} bulan</small>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold">Rp {{ number_format($order->product_price, 0, ',', '.') }}</div>
                                @if($order->dp_amount)
                                    <small class="text-success">DP: Rp {{ number_format($order->dp_amount, 0, ',', '.') }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->status_color }}">{{ $order->status_label }}</span>
                            </td>
                            <td>
                                <small>{{ $order->created_at->format('d M Y') }}</small><br>
                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-outline-primary" onclick="viewOrder({{ $order->id }})" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button class="btn btn-outline-success" onclick="updateStatus({{ $order->id }})" title="Update Status">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @if(auth()->user()->hasCeoAccess())
                                    <button class="btn btn-outline-danger" onclick="deleteOrder({{ $order->id }})" title="Hapus">
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
                        Menampilkan {{ $orders->firstItem() }} - {{ $orders->lastItem() }} 
                        dari {{ $orders->total() }} pesanan
                    </small>
                </div>
                <div>
                    {{ $orders->links() }}
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                <h5 class="text-muted">Belum ada pesanan</h5>
                <p class="text-muted">Pesanan akan muncul di sini ketika pelanggan melakukan pembelian.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@section('modals')
<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">📋 Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="orderDetailContent">
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🔄 Update Status Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" id="updateOrderId" name="order_id">
                    <div class="mb-3">
                        <label for="newStatus" class="form-label">Status Baru</label>
                        <select class="form-select" id="newStatus" name="status" required>
                            <option value="pending">Menunggu Persetujuan</option>
                            <option value="approved">Disetujui</option>
                            <option value="processing">Sedang Diproses</option>
                            <option value="completed">Selesai</option>
                            <option value="rejected">Ditolak</option>
                            <option value="cancelled">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="adminNotes" class="form-label">Catatan Admin (Opsional)</label>
                        <textarea class="form-control" id="adminNotes" name="admin_notes" rows="3" 
                                  placeholder="Catatan untuk pelanggan..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function viewOrder(id) {
    const modal = new bootstrap.Modal(document.getElementById('viewOrderModal'));
    modal.show();
    
    fetch(`/admin/orders/${id}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const order = data.order;
            document.getElementById('orderDetailContent').innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Informasi Pesanan</h6>
                        <table class="table table-sm">
                            <tr><th>No. Order</th><td>#${order.order_number}</td></tr>
                            <tr><th>Status</th><td><span class="badge bg-${getStatusColor(order.status)}">${getStatusLabel(order.status)}</span></td></tr>
                            <tr><th>Pembayaran</th><td>${getPaymentLabel(order.payment_type)}</td></tr>
                            <tr><th>Harga</th><td>Rp ${parseInt(order.product_price).toLocaleString('id-ID')}</td></tr>
                            ${order.dp_amount ? `<tr><th>DP</th><td>Rp ${parseInt(order.dp_amount).toLocaleString('id-ID')}</td></tr>` : ''}
                            ${order.monthly_payment ? `<tr><th>Cicilan/Bulan</th><td>Rp ${parseInt(order.monthly_payment).toLocaleString('id-ID')}</td></tr>` : ''}
                            ${order.credit_months ? `<tr><th>Tenor</th><td>${order.credit_months} bulan</td></tr>` : ''}
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Informasi Pelanggan</h6>
                        <table class="table table-sm">
                            <tr><th>Nama</th><td>${order.customer_name}</td></tr>
                            <tr><th>Email</th><td>${order.customer_email}</td></tr>
                            <tr><th>Telepon</th><td>${order.customer_phone}</td></tr>
                            <tr><th>Alamat</th><td>${order.customer_address}</td></tr>
                            ${order.customer_ktp ? `<tr><th>KTP</th><td>${order.customer_ktp}</td></tr>` : ''}
                        </table>
                    </div>
                </div>
                ${order.notes ? `<div class="mt-3"><h6>Catatan Pelanggan</h6><p class="bg-light p-2 rounded">${order.notes}</p></div>` : ''}
                ${order.admin_notes ? `<div class="mt-3"><h6>Catatan Admin</h6><p class="bg-warning bg-opacity-25 p-2 rounded">${order.admin_notes}</p></div>` : ''}
            `;
        }
    });
}

function updateStatus(id) {
    document.getElementById('updateOrderId').value = id;
    const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    modal.show();
}

document.getElementById('updateStatusForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const orderId = document.getElementById('updateOrderId').value;
    const formData = new FormData(this);
    
    fetch(`/admin/orders/${orderId}/status`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            status: formData.get('status'),
            admin_notes: formData.get('admin_notes')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Gagal mengupdate status');
        }
    });
});

function deleteOrder(id) {
    if (confirm('Yakin ingin menghapus pesanan ini?')) {
        fetch(`/admin/orders/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function getStatusColor(status) {
    const colors = {
        'pending': 'warning',
        'approved': 'info',
        'processing': 'primary',
        'completed': 'success',
        'rejected': 'danger',
        'cancelled': 'secondary'
    };
    return colors[status] || 'secondary';
}

function getStatusLabel(status) {
    const labels = {
        'pending': 'Menunggu',
        'approved': 'Disetujui',
        'processing': 'Diproses',
        'completed': 'Selesai',
        'rejected': 'Ditolak',
        'cancelled': 'Dibatalkan'
    };
    return labels[status] || status;
}

function getPaymentLabel(type) {
    const labels = {
        'cash': 'Tunai',
        'dp': 'DP',
        'credit': 'Kredit'
    };
    return labels[type] || type;
}
</script>
@endsection

@extends('layouts.main')

@section('title', 'Detail Pesanan #' . $order->order_number . ' - SecondCycle')

@section('content')
<section class="py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Pesanan Saya</a></li>
                <li class="breadcrumb-item active">#{{ $order->order_number }}</li>
            </ol>
        </nav>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- Order Details -->
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-receipt me-2"></i>Detail Pesanan
                        </h5>
                        <span class="badge bg-{{ $order->status_color }} fs-6">{{ $order->status_label }}</span>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Nomor Pesanan:</strong></p>
                                <p class="text-primary fw-bold">#{{ $order->order_number }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Tanggal Pesanan:</strong></p>
                                <p>{{ $order->created_at->format('d F Y, H:i') }}</p>
                            </div>
                        </div>

                        <!-- Product Info -->
                        <div class="bg-light p-3 rounded mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-3">
                                    @if($order->product && $order->product->image)
                                        <img src="{{ asset('storage/' . $order->product->image) }}" 
                                             class="img-fluid rounded" alt="{{ $order->product->name }}">
                                    @else
                                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded" 
                                             style="height: 100px;">
                                            <i class="fas fa-motorcycle fa-2x text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-9">
                                    <h5 class="mb-1">{{ $order->product->name ?? 'Produk tidak tersedia' }}</h5>
                                    @if($order->product)
                                        <p class="text-muted mb-2">
                                            {{ $order->product->brand }} {{ $order->product->type }} {{ $order->product->cc }}cc
                                        </p>
                                    @endif
                                    <h4 class="text-primary mb-0">Rp {{ number_format($order->product_price, 0, ',', '.') }}</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <h6 class="mb-3"><i class="fas fa-credit-card me-2"></i>Detail Pembayaran</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">Metode Pembayaran</th>
                                <td>
                                    <span class="badge bg-{{ $order->payment_type === 'cash' ? 'success' : ($order->payment_type === 'dp' ? 'info' : 'primary') }}">
                                        {{ $order->payment_type_label }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Harga Produk</th>
                                <td>Rp {{ number_format($order->product_price, 0, ',', '.') }}</td>
                            </tr>
                            @if($order->payment_type !== 'cash')
                                <tr>
                                    <th>Uang Muka (DP)</th>
                                    <td class="text-success">Rp {{ number_format($order->dp_amount, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Sisa Pembayaran</th>
                                    <td class="text-danger">Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}</td>
                                </tr>
                            @endif
                            @if($order->payment_type === 'credit')
                                <tr>
                                    <th>Tenor</th>
                                    <td>{{ $order->credit_months }} Bulan</td>
                                </tr>
                                <tr>
                                    <th>Cicilan per Bulan</th>
                                    <td class="text-primary fw-bold">Rp {{ number_format($order->monthly_payment, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor KTP</th>
                                    <td>{{ $order->customer_ktp }}</td>
                                </tr>
                            @endif
                        </table>

                        @if($order->notes)
                            <div class="mt-4">
                                <h6><i class="fas fa-sticky-note me-2"></i>Catatan Anda</h6>
                                <p class="bg-light p-3 rounded">{{ $order->notes }}</p>
                            </div>
                        @endif

                        @if($order->admin_notes)
                            <div class="mt-4">
                                <h6><i class="fas fa-comment-alt me-2"></i>Catatan Admin</h6>
                                <p class="bg-warning bg-opacity-25 p-3 rounded">{{ $order->admin_notes }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                @if($order->status === 'completed')
                    @php
                        $hasReviewed = \App\Models\Review::where('user_id', auth()->id())
                            ->where('product_id', $order->product_id)
                            ->exists();
                    @endphp

                    @if(!$hasReviewed)
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0"><i class="fas fa-star me-2 text-warning"></i>Berikan Ulasan</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $order->product_id }}">
                                
                                <div class="mb-3">
                                    <label class="form-label">Rating</label>
                                    <div class="rating-input">
                                        @for($i=5; $i>=1; $i--)
                                            <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" required>
                                            <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                        @endfor
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="comment" class="form-label">Komentar Anda</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3" placeholder="Ceritakan pengalaman Anda dengan produk ini..."></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                                </button>
                            </form>
                        </div>
                    </div>
                    <style>
                        .rating-input {
                            display: flex;
                            flex-direction: row-reverse;
                            justify-content: flex-end;
                        }
                        .rating-input input {
                            display: none;
                        }
                        .rating-input label {
                            cursor: pointer;
                            font-size: 1.5rem;
                            color: #ddd;
                            margin-right: 5px;
                        }
                        .rating-input label:hover,
                        .rating-input label:hover ~ label,
                        .rating-input input:checked ~ label {
                            color: #ffc107;
                        }
                    </style>
                    @else
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>Anda sudah memberikan ulasan untuk produk ini. Terima kasih!
                    </div>
                    @endif
                @endif

                <!-- Timeline -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-history me-2"></i>Status Pesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div class="timeline-item {{ $order->status !== 'cancelled' && $order->status !== 'rejected' ? 'active' : '' }}">
                                <div class="timeline-marker bg-success"></div>
                                <div class="timeline-content">
                                    <h6 class="mb-0">Pesanan Dibuat</h6>
                                    <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                </div>
                            </div>
                            @if($order->approved_at)
                                <div class="timeline-item active">
                                    <div class="timeline-marker bg-info"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-0">Pesanan Disetujui</h6>
                                        <small class="text-muted">{{ $order->approved_at->format('d M Y, H:i') }}</small>
                                    </div>
                                </div>
                            @endif
                            @if($order->status === 'processing')
                                <div class="timeline-item active">
                                    <div class="timeline-marker bg-primary"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-0">Sedang Diproses</h6>
                                        <small class="text-muted">Pesanan sedang diproses</small>
                                    </div>
                                </div>
                            @endif
                            @if($order->completed_at)
                                <div class="timeline-item active">
                                    <div class="timeline-marker bg-success"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-0">Pesanan Selesai</h6>
                                        <small class="text-muted">{{ $order->completed_at->format('d M Y, H:i') }}</small>
                                    </div>
                                </div>
                            @endif
                            @if($order->status === 'rejected')
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-danger"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-0 text-danger">Pesanan Ditolak</h6>
                                        <small class="text-muted">{{ $order->admin_notes ?? 'Tidak ada keterangan' }}</small>
                                    </div>
                                </div>
                            @endif
                            @if($order->status === 'cancelled')
                                <div class="timeline-item">
                                    <div class="timeline-marker bg-secondary"></div>
                                    <div class="timeline-content">
                                        <h6 class="mb-0 text-secondary">Pesanan Dibatalkan</h6>
                                        <small class="text-muted">Dibatalkan oleh pembeli</small>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Info Sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-user me-2"></i>Informasi Pembeli</h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>{{ $order->customer_name }}</strong></p>
                        <p class="mb-2">
                            <i class="fas fa-envelope me-2 text-muted"></i>{{ $order->customer_email }}
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-phone me-2 text-muted"></i>{{ $order->customer_phone }}
                        </p>
                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt me-2 text-muted"></i>{{ $order->customer_address }}
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
                            </a>
                            @if($order->status === 'pending')
                                <form action="{{ route('orders.cancel', $order) }}" method="POST" 
                                      onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="fas fa-times me-2"></i>Batalkan Pesanan
                                    </button>
                                </form>
                            @endif
                            <a href="https://wa.me/6281234567890?text=Halo, saya ingin bertanya tentang pesanan {{ $order->order_number }}" 
                               target="_blank" class="btn btn-success">
                                <i class="fab fa-whatsapp me-2"></i>Hubungi via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}
.timeline-item {
    position: relative;
    padding-bottom: 20px;
    padding-left: 20px;
    border-left: 2px solid #dee2e6;
}
.timeline-item:last-child {
    padding-bottom: 0;
    border-left: 2px solid transparent;
}
.timeline-item.active {
    border-left-color: #0d6efd;
}
.timeline-marker {
    position: absolute;
    left: -8px;
    top: 0;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    border: 2px solid #fff;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStatus = '{{ $order->status }}';
    const orderId = '{{ $order->id }}';
    const checkInterval = 10000; // Check every 10 seconds

    setInterval(function() {
        fetch(`{{ route('orders.show', $order->id) }}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (data.status !== currentStatus) {
                    // Status changed, reload page to show updates
                    console.log('Order status changed from ' + currentStatus + ' to ' + data.status);
                    location.reload();
                }
            }
        })
        .catch(error => console.error('Error polling order status:', error));
    }, checkInterval);
});
</script>
@endsection

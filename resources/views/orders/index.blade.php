@extends('layouts.main')

@section('title', 'Pesanan Saya - SecondCycle')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-shopping-bag me-2"></i>Pesanan Saya</h2>
            <a href="{{ route('products.index') }}" class="btn btn-primary">
                <i class="fas fa-motorcycle me-2"></i>Lihat Produk
            </a>
        </div>

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

        @if($orders->count() > 0)
            <div class="row">
                @foreach($orders as $order)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header bg-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold">#{{ $order->order_number }}</span>
                            <span class="badge bg-{{ $order->status_color }}">{{ $order->status_label }}</span>
                        </div>
                        <div class="card-body">
                            <div class="d-flex mb-3">
                                @if($order->product && $order->product->image)
                                    <img src="{{ asset('storage/' . $order->product->image) }}" 
                                         class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-3" 
                                         style="width: 80px; height: 80px;">
                                        <i class="fas fa-motorcycle text-white"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-1">{{ $order->product->name ?? 'Produk tidak tersedia' }}</h6>
                                    <p class="text-primary fw-bold mb-0">Rp {{ number_format($order->product_price, 0, ',', '.') }}</p>
                                    <small class="text-muted">{{ $order->payment_type_label }}</small>
                                </div>
                            </div>

                            @if($order->payment_type === 'credit')
                                <div class="bg-light p-2 rounded mb-3">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <small class="text-muted">DP</small>
                                            <p class="mb-0 fw-bold">Rp {{ number_format($order->dp_amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Cicilan/Bulan</small>
                                            <p class="mb-0 fw-bold text-primary">Rp {{ number_format($order->monthly_payment, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @elseif($order->payment_type === 'dp')
                                <div class="bg-light p-2 rounded mb-3">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <small class="text-muted">DP</small>
                                            <p class="mb-0 fw-bold">Rp {{ number_format($order->dp_amount, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Sisa</small>
                                            <p class="mb-0 fw-bold text-danger">Rp {{ number_format($order->remaining_amount, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>{{ $order->created_at->format('d M Y, H:i') }}
                            </small>
                        </div>
                        <div class="card-footer bg-white">
                            <div class="d-flex gap-2">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                                @if($order->status === 'pending')
                                    <form action="{{ route('orders.cancel', $order) }}" method="POST" 
                                          onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center">
                {{ $orders->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-shopping-bag fa-4x text-muted mb-3"></i>
                <h4 class="text-muted">Belum ada pesanan</h4>
                <p class="text-muted">Anda belum melakukan pembelian apapun.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-motorcycle me-2"></i>Lihat Produk
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@extends('layouts.main')

@section('title', $product->name . ' - SecondCycle')

@section('content')
<section class="product-detail py-5">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Produk</a></li>
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Image -->
            <div class="col-lg-6 col-12 mb-4">
                <div class="position-relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             class="img-fluid rounded shadow" 
                             alt="{{ $product->name }}"
                             style="width: 100%; height: auto;">
                    @else
                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded" 
                             style="height: 400px;">
                            <i class="fas fa-motorcycle fa-5x text-white"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6 col-12">
                <div class="product-info">
                    <!-- Brand & Type Badge -->
                    <div class="mb-2">
                        @if($product->brand)
                            <span class="badge bg-primary me-1">{{ $product->brand }}</span>
                        @endif
                        @if($product->type)
                            <span class="badge bg-info">{{ $product->type }}</span>
                        @endif
                        @if($product->cc)
                            <span class="badge bg-secondary">{{ $product->cc }}cc</span>
                        @endif
                        @if($product->grade)
                            <span class="badge bg-{{ $product->grade_color }}">Grade {{ $product->grade }}</span>
                        @endif
                        @if($product->location)
                            <span class="badge bg-dark"><i class="fas fa-map-marker-alt me-1"></i>{{ $product->location }}</span>
                        @endif
                    </div>

                    <!-- Product Name -->
                    <h1 class="product-title mb-3">{{ $product->name }}</h1>

                    <!-- Price -->
                    <div class="product-price mb-4">
                        <h2 class="text-primary fw-bold mb-0">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </h2>
                        <small class="text-muted">Harga nego di tempat</small>
                    </div>

                    <!-- Short Description -->
                    @if($product->short_description)
                        <p class="lead text-muted mb-4">{{ $product->short_description }}</p>
                    @endif

                    <!-- Specs Summary -->
                    <div class="row mb-4">
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-tachometer-alt fa-2x text-muted me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Odometer</small>
                                    <span class="fw-bold">{{ $product->odometer ? number_format($product->odometer) . ' KM' : '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar fa-2x text-muted me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Tahun</small>
                                    <span class="fw-bold">{{ $product->year_manufacture ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file-alt fa-2x text-muted me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Pajak</small>
                                    <span class="fw-bold {{ $product->tax_status == 'Hidup' ? 'text-success' : 'text-danger' }}">
                                        {{ $product->tax_status ?? '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-cogs fa-2x text-muted me-3"></i>
                                <div>
                                    <small class="text-muted d-block">Transmisi</small>
                                    <span class="fw-bold">{{ $product->type ?? '-' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons mb-4">
                        @auth
                            <button type="button" class="btn btn-primary btn-lg w-100 mb-2" data-bs-toggle="modal" data-bs-target="#orderModal">
                                <i class="fas fa-shopping-cart me-2"></i>Ajukan Pembelian
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg w-100 mb-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Login untuk Membeli
                            </a>
                        @endauth
                        <a href="https://wa.me/6281234567890?text=Halo%20saya%20tertarik%20dengan%20{{ urlencode($product->name) }}" target="_blank" class="btn btn-outline-success w-100">
                            <i class="fab fa-whatsapp me-2"></i>Chat Penjual
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Tabs -->
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-tabs nav-fill mb-4" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc" type="button" role="tab">
                            <i class="fas fa-align-left me-2"></i>Deskripsi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">
                            <i class="fas fa-list me-2"></i>Spesifikasi Detail
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="condition-tab" data-bs-toggle="tab" data-bs-target="#condition" type="button" role="tab">
                            <i class="fas fa-check-circle me-2"></i>Kondisi & Riwayat
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content p-4 bg-white rounded shadow-sm" id="productTabsContent">
                    <!-- Description -->
                    <div class="tab-pane fade show active" id="desc" role="tabpanel">
                        <h5>Deskripsi Produk</h5>
                        <div class="text-muted">
                            {!! nl2br(e($product->description ?? 'Tidak ada deskripsi.')) !!}
                        </div>
                    </div>

                    <!-- Specs -->
                    <div class="tab-pane fade" id="specs" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="mb-3">Identitas Kendaraan</h6>
                                <table class="table table-borderless table-striped">
                                    <tr><td width="40%">Merek</td><td class="fw-bold">{{ $product->brand }}</td></tr>
                                    <tr><td>Model</td><td class="fw-bold">{{ $product->name }}</td></tr>
                                    <tr><td>Tipe</td><td class="fw-bold">{{ $product->type }}</td></tr>
                                    <tr><td>Warna</td><td class="fw-bold">{{ $product->color ?? '-' }}</td></tr>
                                    <tr><td>Tahun Pembuatan</td><td class="fw-bold">{{ $product->year_manufacture ?? '-' }}</td></tr>
                                    <tr><td>Tahun Perakitan</td><td class="fw-bold">{{ $product->year_assembly ?? '-' }}</td></tr>
                                    <tr><td>Kapasitas Mesin</td><td class="fw-bold">{{ $product->cc }} cc</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-3">Dokumen & Legalitas</h6>
                                <table class="table table-borderless table-striped">
                                    <tr><td width="40%">STNK</td><td class="fw-bold">{{ $product->stnk_status ?? '-' }}</td></tr>
                                    <tr><td>BPKB</td><td class="fw-bold">{{ $product->bpkb_status ?? '-' }}</td></tr>
                                    <tr><td>Status Pajak</td><td class="fw-bold {{ $product->tax_status == 'Hidup' ? 'text-success' : 'text-danger' }}">{{ $product->tax_status ?? '-' }}</td></tr>
                                    <tr><td>Masa Berlaku</td><td class="fw-bold">{{ $product->tax_expiry ? $product->tax_expiry->format('d M Y') : '-' }}</td></tr>
                                    <tr><td>Plat Nomor</td><td class="fw-bold">{{ $product->plate_number_status ?? '-' }}</td></tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Condition -->
                    <div class="tab-pane fade" id="condition" role="tabpanel">
                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <h6 class="mb-3 text-primary"><i class="fas fa-car-side me-2"></i>Kondisi Fisik</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Body <span class="badge bg-secondary">{{ $product->body_condition ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Rangka <span class="badge bg-secondary">{{ $product->frame_condition ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Kaki-kaki <span class="badge bg-secondary">{{ $product->legs_condition ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Kelistrikan <span class="badge bg-secondary">{{ $product->electrical_condition ?? '-' }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mb-4">
                                <h6 class="mb-3 text-primary"><i class="fas fa-cogs me-2"></i>Kondisi Mesin</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Suara Mesin <span class="badge bg-secondary">{{ $product->engine_sound ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Kebocoran Oli <span class="badge bg-secondary">{{ $product->oil_leak ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Asap Knalpot <span class="badge bg-secondary">{{ $product->exhaust_smoke ?? '-' }}</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Tarikan <span class="badge bg-secondary">{{ $product->engine_pull ?? '-' }}</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4 mb-4">
                                <h6 class="mb-3 text-primary"><i class="fas fa-history me-2"></i>Riwayat</h6>
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="fas fa-{{ $product->routine_service ? 'check text-success' : 'times text-danger' }} me-2"></i>Servis Rutin</li>
                                    <li class="mb-2"><i class="fas fa-{{ $product->service_book ? 'check text-success' : 'times text-danger' }} me-2"></i>Buku Servis</li>
                                    <li class="mb-2"><i class="fas fa-{{ !$product->accident_history ? 'check text-success' : 'times text-danger' }} me-2"></i>Bebas Tabrakan</li>
                                    <li class="mb-2"><i class="fas fa-{{ !$product->flood_history ? 'check text-success' : 'times text-danger' }} me-2"></i>Bebas Banjir</li>
                                </ul>
                                @if($product->service_notes)
                                    <div class="alert alert-light mt-2 mb-0">
                                        <small><strong>Catatan Servis:</strong> {{ $product->service_notes }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h6>Kelengkapan</h6>
                                <div>
                                    <span class="badge bg-{{ $product->spare_key ? 'success' : 'secondary' }} me-1">Kunci Cadangan</span>
                                    <span class="badge bg-{{ $product->toolkit ? 'success' : 'secondary' }} me-1">Toolkit</span>
                                    <span class="badge bg-{{ $product->manual_book ? 'success' : 'secondary' }} me-1">Buku Manual</span>
                                    <span class="badge bg-{{ $product->bonus_helmet ? 'success' : 'secondary' }} me-1">Bonus Helm</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('modals')
<!-- Order Modal -->
@auth
<div class="modal fade" id="orderModal" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="orderModalLabel">
                    <i class="fas fa-shopping-cart me-2"></i>Ajukan Pembelian
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('orders.store', $product) }}" method="POST" id="orderForm">
                    @csrf
                    <!-- Product Summary -->
                    <div class="product-summary p-3 bg-light rounded mb-4">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid rounded" alt="{{ $product->name }}">
                                @else
                                    <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="height: 80px;">
                                        <i class="fas fa-motorcycle text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <h5 class="mb-1">{{ $product->name }}</h5>
                                <p class="text-muted mb-1">{{ $product->brand }} {{ $product->type }} {{ $product->cc }}cc</p>
                                <h4 class="text-primary mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</h4>
                                <input type="hidden" id="productPrice" value="{{ $product->price }}">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Type Selection -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Pilih Metode Pembayaran</label>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="payment_type" id="paymentCash" value="cash" checked>
                                    <label class="form-check-label w-100" for="paymentCash">
                                        <div class="card text-center p-3 payment-card">
                                            <i class="fas fa-money-bill-wave fa-2x text-success mb-2"></i>
                                            <strong>Tunai (Cash)</strong>
                                            <small class="text-muted">Bayar langsung</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="payment_type" id="paymentDP" value="dp">
                                    <label class="form-check-label w-100" for="paymentDP">
                                        <div class="card text-center p-3 payment-card">
                                            <i class="fas fa-hand-holding-usd fa-2x text-info mb-2"></i>
                                            <strong>DP (Down Payment)</strong>
                                            <small class="text-muted">Bayar sebagian dulu</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check payment-option">
                                    <input class="form-check-input" type="radio" name="payment_type" id="paymentCredit" value="credit">
                                    <label class="form-check-label w-100" for="paymentCredit">
                                        <div class="card text-center p-3 payment-card">
                                            <i class="fas fa-calendar-alt fa-2x text-primary mb-2"></i>
                                            <strong>Kredit</strong>
                                            <small class="text-muted">Cicilan bulanan</small>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- DP/Credit Options (Hidden by default) -->
                    <div id="dpOptions" class="mb-4" style="display: none;">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <i class="fas fa-calculator me-2"></i>Pengaturan DP
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="dpAmount" class="form-label">Jumlah DP (Minimal 30%)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control" id="dpAmount" name="dp_amount" 
                                               min="{{ $product->price * 0.3 }}" max="{{ $product->price }}"
                                               value="{{ $product->price * 0.3 }}" onchange="calculateRemaining()">
                                    </div>
                                    <small class="text-muted">Minimal: Rp {{ number_format($product->price * 0.3, 0, ',', '.') }}</small>
                                </div>
                                <div class="alert alert-info mb-0">
                                    <strong>Sisa Pembayaran:</strong> 
                                    <span id="remainingAmount">Rp {{ number_format($product->price * 0.7, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="creditOptions" class="mb-4" style="display: none;">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-calculator me-2"></i>Simulasi Kredit
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="creditDpAmount" class="form-label">Jumlah DP (Minimal 20%)</label>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" class="form-control" id="creditDpAmount" 
                                                       min="{{ $product->price * 0.2 }}" max="{{ $product->price * 0.5 }}"
                                                       value="{{ $product->price * 0.2 }}" onchange="calculateCredit()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="creditMonths" class="form-label">Tenor (Bulan)</label>
                                            <select class="form-select" id="creditMonths" name="credit_months" onchange="calculateCredit()">
                                                <option value="6">6 Bulan</option>
                                                <option value="12" selected>12 Bulan</option>
                                                <option value="18">18 Bulan</option>
                                                <option value="24">24 Bulan</option>
                                                <option value="36">36 Bulan</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="customerKtp" class="form-label">Nomor KTP</label>
                                    <input type="text" class="form-control" id="customerKtp" name="customer_ktp" 
                                           placeholder="Masukkan 16 digit nomor KTP" maxlength="16">
                                    <small class="text-muted">Diperlukan untuk pengajuan kredit</small>
                                </div>
                                <div class="alert alert-primary">
                                    <div class="row text-center">
                                        <div class="col-4">
                                            <small>Sisa Pinjaman</small>
                                            <h6 id="creditRemaining">Rp 0</h6>
                                        </div>
                                        <div class="col-4">
                                            <small>Cicilan/Bulan</small>
                                            <h5 class="text-primary" id="monthlyPayment">Rp 0</h5>
                                        </div>
                                        <div class="col-4">
                                            <small>Bunga</small>
                                            <h6 id="creditInterest">5%/tahun</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <h6 class="mb-3"><i class="fas fa-user me-2"></i>Informasi Pembeli</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customerName" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="customerName" name="customer_name" 
                                       value="{{ auth()->user()->name }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="customerPhone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control" id="customerPhone" name="customer_phone" 
                                       value="{{ auth()->user()->phone ?? '' }}" required placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="customerEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="customerEmail" name="customer_email" 
                               value="{{ auth()->user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="customerAddress" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="customerAddress" name="customer_address" rows="3" 
                                  required placeholder="Alamat lengkap untuk pengiriman/survey">{{ auth()->user()->address ?? '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Catatan (Opsional)</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2" 
                                  placeholder="Catatan tambahan untuk penjual"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary" form="orderForm">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Pengajuan
                </button>
            </div>
        </div>
    </div>
</div>
@endauth

<style>
/* Override tooplate modal styles for order modal */
#orderModal .modal-header {
    padding: 1rem 1rem !important;
    padding-top: 1rem !important;
    padding-bottom: 1rem !important;
}
#orderModal .modal-body {
    padding: 1.5rem !important;
}
#orderModal .modal-footer {
    padding: 1rem !important;
}
#orderModal .modal-content {
    position: relative;
    z-index: 1060;
}
#orderModal .btn-close {
    position: relative !important;
    top: auto !important;
    right: auto !important;
    margin: 0 !important;
}
#orderModal {
    z-index: 1055 !important;
}
#orderModal .modal-dialog {
    pointer-events: auto;
}

.payment-option .form-check-input {
    display: none;
}
.payment-option .payment-card {
    cursor: pointer;
    border: 2px solid #dee2e6;
    transition: all 0.3s ease;
    pointer-events: auto;
}
.payment-option .form-check-input:checked + .form-check-label .payment-card {
    border-color: #0d6efd;
    background-color: #f0f7ff;
}
.payment-option .payment-card:hover {
    border-color: #0d6efd;
}

/* Ensure all form elements are clickable */
#orderModal input,
#orderModal select,
#orderModal textarea,
#orderModal button,
#orderModal label {
    pointer-events: auto !important;
    position: relative;
    z-index: 1;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentRadios = document.querySelectorAll('input[name="payment_type"]');
    const dpOptions = document.getElementById('dpOptions');
    const creditOptions = document.getElementById('creditOptions');
    const dpAmountInput = document.getElementById('dpAmount');
    const creditDpAmountInput = document.getElementById('creditDpAmount');

    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            dpOptions.style.display = 'none';
            creditOptions.style.display = 'none';
            
            if (this.value === 'dp') {
                dpOptions.style.display = 'block';
                dpAmountInput.name = 'dp_amount';
                creditDpAmountInput.name = '';
            } else if (this.value === 'credit') {
                creditOptions.style.display = 'block';
                creditDpAmountInput.name = 'dp_amount';
                dpAmountInput.name = '';
                calculateCredit();
            } else {
                dpAmountInput.name = '';
                creditDpAmountInput.name = '';
            }
        });
    });

    // Initialize
    calculateCredit();
});

function calculateRemaining() {
    const price = parseInt(document.getElementById('productPrice').value);
    const dp = parseInt(document.getElementById('dpAmount').value) || 0;
    const remaining = price - dp;
    document.getElementById('remainingAmount').textContent = 'Rp ' + remaining.toLocaleString('id-ID');
}

function calculateCredit() {
    const price = parseInt(document.getElementById('productPrice').value);
    const dp = parseInt(document.getElementById('creditDpAmount').value) || 0;
    const months = parseInt(document.getElementById('creditMonths').value) || 12;
    
    const remaining = price - dp;
    const interestRate = 0.05; // 5% per year
    const totalInterest = remaining * interestRate * (months / 12);
    const totalWithInterest = remaining + totalInterest;
    const monthlyPayment = Math.ceil(totalWithInterest / months);
    
    document.getElementById('creditRemaining').textContent = 'Rp ' + remaining.toLocaleString('id-ID');
    document.getElementById('monthlyPayment').textContent = 'Rp ' + monthlyPayment.toLocaleString('id-ID');
}
</script>
@endsection

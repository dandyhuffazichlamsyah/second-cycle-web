@extends('layouts.main')

@section('title', $product->name . ' - SecondCycle')

@section('content')
<section class="py-5 bg-white" style="margin-top: 120px;">
  <div class="container py-lg-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb small">
        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-secondary text-decoration-none">Beranda</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-secondary text-decoration-none">Koleksi</a></li>
        <li class="breadcrumb-item active text-dark fw-semibold" aria-current="page">{{ $product->name }}</li>
      </ol>
    </nav>

    @if(session('success'))
      <div class="alert alert-success border-0 mb-4 p-3 d-flex align-items-center" style="border-radius: 0; background-color: var(--bg-tertiary);">
        <i class="ri-checkbox-circle-fill text-success fs-4 me-2"></i>
        <div>
          <span class="fw-bold text-dark d-block">Pengajuan Berhasil</span>
          <span class="text-secondary small">{{ session('success') }}</span>
        </div>
      </div>
    @endif

    <div class="row g-5">
      <!-- Left Column: Visuals & Tech Specifications -->
      <div class="col-lg-7">
        <!-- Main Image -->
        <div class="mb-4 border border-light position-relative" style="background-color: var(--bg-tertiary);">
          <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=800&q=80' }}" 
               class="img-fluid w-100" 
               alt="{{ $product->name }}"
               style="max-height: 480px; object-fit: cover;">
          
          <div class="position-absolute top-0 start-0 p-3">
            <span class="badge-premium badge-premium-dark">Grade {{ $product->grade ?? 'A' }}</span>
          </div>
        </div>

        <!-- Specifications Tabbed Area -->
        <div class="mt-5">
          <h3 class="fw-bold mb-4 border-bottom border-light pb-2">Spesifikasi Detail</h3>
          
          <div class="spec-sheet-grid">
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Merek / Model</span>
              <div class="spec-sheet-value">{{ $product->brand }} {{ $product->model ?? '' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Kapasitas Mesin</span>
              <div class="spec-sheet-value">{{ $product->cc ? $product->cc . ' cc' : '-' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Tahun Pembuatan</span>
              <div class="spec-sheet-value">{{ $product->year_manufacture ?? '-' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Tahun Perakitan</span>
              <div class="spec-sheet-value">{{ $product->year_assembly ?? '-' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Warna</span>
              <div class="spec-sheet-value">{{ $product->color ?? '-' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Jarak Tempuh (Odo)</span>
              <div class="spec-sheet-value">{{ $product->odometer ? number_format($product->odometer) . ' KM' : '-' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Status STNK</span>
              <div class="spec-sheet-value">{{ $product->stnk_status ?? '-' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Status BPKB</span>
              <div class="spec-sheet-value">{{ $product->bpkb_status ?? '-' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Status Pajak</span>
              <div class="spec-sheet-value">
                <span class="{{ $product->tax_status == 'Hidup' ? 'text-success' : 'text-danger' }} fw-bold">
                  {{ $product->tax_status ?? '-' }}
                </span>
                @if($product->tax_expiry)
                  <small class="text-secondary d-block">s/d {{ $product->tax_expiry->format('d M Y') }}</small>
                @endif
              </div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Lokasi Unit</span>
              <div class="spec-sheet-value">{{ $product->location ?? 'Jakarta Selatan' }}</div>
            </div>
          </div>

          <h3 class="fw-bold mt-5 mb-4 border-bottom border-light pb-2">Kondisi Fisik & Mesin</h3>
          <div class="spec-sheet-grid">
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Kondisi Bodi</span>
              <div class="spec-sheet-value">{{ $product->body_condition ?? 'Sangat Baik' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Kondisi Rangka</span>
              <div class="spec-sheet-value">{{ $product->frame_condition ?? 'Sangat Baik' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Suara Mesin</span>
              <div class="spec-sheet-value">{{ $product->engine_sound ?? 'Halus' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Kebocoran Oli</span>
              <div class="spec-sheet-value">{{ $product->oil_leak ?? 'Tidak Ada' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Riwayat Kecelakaan</span>
              <div class="spec-sheet-value">{{ $product->accident_history ? 'Pernah' : 'Bebas Tabrak' }}</div>
            </div>
            <div class="spec-sheet-item">
              <span class="spec-sheet-label">Riwayat Banjir</span>
              <div class="spec-sheet-value">{{ $product->flood_history ? 'Pernah' : 'Bebas Banjir' }}</div>
            </div>
          </div>
          
          @if($product->description)
            <h3 class="fw-bold mt-5 mb-4 border-bottom border-light pb-2">Catatan Tambahan</h3>
            <p class="text-secondary small" style="line-height: 1.8;">{!! nl2br(e($product->description)) !!}</p>
          @endif
        </div>
      </div>

      <!-- Right Column: Transactions & Live Credit Simulation -->
      <div class="col-lg-5">
        <div class="p-4 border border-light bg-white" style="position: sticky; top: 120px;">
          <span class="text-secondary small d-block">Harga Cash</span>
          <h2 class="display-6 fw-bold mb-1">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
          <p class="small text-secondary mb-4">Harga On The Road (OTR) wilayah {{ $product->location ?? 'Jakarta' }}</p>

          <hr class="opacity-10 mb-4">

          <!-- Features included -->
          <div class="mb-4">
            <h6 class="fw-bold mb-3 small text-uppercase tracking-wider">Sudah Termasuk:</h6>
            <div class="row g-2 small text-secondary">
              <div class="col-6"><i class="ri-checkbox-circle-fill text-dark me-2"></i>Garansi Mesin 30 Hari</div>
              <div class="col-6"><i class="ri-checkbox-circle-fill text-dark me-2"></i>Gratis Ganti Oli Pertama</div>
              <div class="col-6"><i class="ri-checkbox-circle-fill text-dark me-2"></i>Jas Hujan & Helm</div>
              <div class="col-6"><i class="ri-checkbox-circle-fill text-dark me-2"></i>Surat Siap Jalan</div>
            </div>
          </div>

          <div class="d-flex flex-column gap-2 mb-4">
            @auth
              <button type="button" class="btn btn-primary py-3" data-bs-toggle="modal" data-bs-target="#orderModal">
                <i class="ri-shopping-cart-2-line me-2"></i>Ajukan Pembelian Sekarang
              </button>
            @else
              <a href="{{ route('login') }}" class="btn btn-primary py-3 text-center">
                <i class="ri-login-box-line me-2"></i>Masuk untuk Membeli
              </a>
            @endauth
            
            <a href="https://wa.me/6281234567890?text=Halo%20saya%20tertarik%20dengan%20motor%20{{ urlencode($product->name) }}%20di%20SecondCycle" 
               target="_blank" 
               class="btn btn-outline-dark py-3">
              <i class="ri-whatsapp-line me-2"></i>Tanya Admin WhatsApp
            </a>
          </div>

          <!-- Mini Financing Preview/Interactive tool -->
          <div class="p-3 bg-light border border-light">
            <h6 class="fw-bold small text-uppercase tracking-wider mb-3"><i class="ri-calculator-line me-1"></i>Estimasi Cicilan Kredit</h6>
            <div class="mb-3">
              <div class="d-flex justify-content-between small mb-1">
                <span class="text-secondary">Uang Muka (DP 20%)</span>
                <span class="fw-bold" id="dpText">Rp {{ number_format($product->price * 0.2, 0, ',', '.') }}</span>
              </div>
              <input type="range" class="modern-range w-100" id="dpRange" 
                     min="{{ $product->price * 0.2 }}" max="{{ $product->price * 0.6 }}" step="500000" 
                     value="{{ $product->price * 0.2 }}" oninput="updateCalculator()">
            </div>
            
            <div class="mb-3">
              <div class="d-flex justify-content-between small mb-1">
                <span class="text-secondary">Tenor Pinjaman</span>
                <span class="fw-bold" id="tenorText">12 Bulan</span>
              </div>
              <input type="range" class="modern-range w-100" id="tenorRange" 
                     min="6" max="36" step="6" 
                     value="12" oninput="updateCalculator()">
            </div>

            <div class="pt-3 border-top border-light d-flex justify-content-between align-items-center">
              <div>
                <span class="text-secondary small d-block">Angsuran / bln</span>
                <span class="fw-bold text-dark h5 mb-0" id="installmentText">Rp 0</span>
              </div>
              <small class="text-secondary">Bunga 5% p.a.</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('modals')
@auth
<!-- Order Modal -->
<div class="modal fade" id="orderModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 0; border: 1px solid var(--border);">
      <div class="modal-header border-bottom border-light">
        <h5 class="modal-title fw-bold">Formulir Pengajuan Pembelian</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('orders.store', $product->id) }}" method="POST" id="orderForm">
          @csrf
          <input type="hidden" id="productPrice" value="{{ $product->price }}">

          <!-- Payment Method Selection -->
          <div class="mb-4">
            <label class="form-label fw-bold small text-uppercase text-secondary">Metode Pembayaran</label>
            <div class="row g-3">
              <div class="col-md-4">
                <div class="form-check payment-option p-0">
                  <input class="form-check-input" type="radio" name="payment_type" id="paymentCash" value="cash" checked style="display: none;">
                  <label class="form-check-label w-100" for="paymentCash">
                    <div class="p-3 text-center border border-light payment-card" id="cardCash">
                      <i class="ri-wallet-line fs-2 mb-2 d-block"></i>
                      <strong>Cash Keras</strong>
                      <span class="text-secondary d-block small mt-1">Lunas di tempat</span>
                    </div>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check payment-option p-0">
                  <input class="form-check-input" type="radio" name="payment_type" id="paymentDP" value="dp" style="display: none;">
                  <label class="form-check-label w-100" for="paymentDP">
                    <div class="p-3 text-center border border-light payment-card" id="cardDP">
                      <i class="ri-refund-line fs-2 mb-2 d-block"></i>
                      <strong>Tanda Jadi (DP)</strong>
                      <span class="text-secondary d-block small mt-1">Bayar sebagian</span>
                    </div>
                  </label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-check payment-option p-0">
                  <input class="form-check-input" type="radio" name="payment_type" id="paymentCredit" value="credit" style="display: none;">
                  <label class="form-check-label w-100" for="paymentCredit">
                    <div class="p-3 text-center border border-light payment-card" id="cardCredit">
                      <i class="ri-bank-card-line fs-2 mb-2 d-block"></i>
                      <strong>Kredit Motor</strong>
                      <span class="text-secondary d-block small mt-1">Cicilan bulanan</span>
                    </div>
                  </label>
                </div>
              </div>
            </div>
          </div>

          <!-- Dynamic DP/Credit Fields -->
          <div id="dpFields" class="mb-4 p-3 bg-light border border-light" style="display: none;">
            <div class="mb-3">
              <label for="dpAmountInput" class="form-label fw-bold small text-secondary">Jumlah DP Pembayaran (Min. 30%)</label>
              <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="number" class="form-control" id="dpAmountInput" name="dp_amount" 
                       min="{{ $product->price * 0.3 }}" max="{{ $product->price }}" 
                       value="{{ $product->price * 0.3 }}" onchange="updateFormRemaining()">
              </div>
              <small class="text-secondary">DP minimal: Rp {{ number_format($product->price * 0.3, 0, ',', '.') }}</small>
            </div>
            <div class="p-2 border-top border-light d-flex justify-content-between">
              <span class="text-secondary small">Sisa Pembayaran Pelunasan:</span>
              <span class="fw-bold" id="formRemainingText">Rp {{ number_format($product->price * 0.7, 0, ',', '.') }}</span>
            </div>
          </div>

          <div id="creditFields" class="mb-4 p-3 bg-light border border-light" style="display: none;">
            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="creditDpInput" class="form-label fw-bold small text-secondary">DP Kredit (Min. 20%)</label>
                <div class="input-group">
                  <span class="input-group-text">Rp</span>
                  <input type="number" class="form-control" id="creditDpInput" 
                         min="{{ $product->price * 0.2 }}" max="{{ $product->price * 0.6 }}" 
                         value="{{ $product->price * 0.2 }}" onchange="updateFormCredit()">
                </div>
              </div>
              <div class="col-md-6">
                <label for="creditMonthsInput" class="form-label fw-bold small text-secondary">Tenor Pembayaran</label>
                <select class="form-select" id="creditMonthsInput" name="credit_months" onchange="updateFormCredit()">
                  <option value="6">6 Bulan</option>
                  <option value="12" selected>12 Bulan</option>
                  <option value="18">18 Bulan</option>
                  <option value="24">24 Bulan</option>
                  <option value="36">36 Bulan</option>
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label for="customerKtpInput" class="form-label fw-bold small text-secondary">Nomor NIK KTP Anda</label>
              <input type="text" class="form-control" id="customerKtpInput" name="customer_ktp" placeholder="Masukkan 16 digit NIK" maxlength="16">
            </div>
            <div class="p-3 border border-light bg-white d-flex justify-content-between align-items-center text-center">
              <div>
                <span class="text-secondary small d-block">Sisa Pokok</span>
                <span class="fw-bold text-dark small" id="formCreditRemaining">Rp 0</span>
              </div>
              <div>
                <span class="text-secondary small d-block">Cicilan / Bulan</span>
                <span class="fw-bold text-primary" id="formCreditInstallment">Rp 0</span>
              </div>
            </div>
          </div>

          <!-- Customer Data -->
          <div class="row g-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="customerName" class="form-label fw-bold small text-secondary">Nama Lengkap</label>
                <input type="text" class="form-control" name="customer_name" value="{{ auth()->user()->name }}" required>
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label for="customerPhone" class="form-label fw-bold small text-secondary">Nomor Whatsapp</label>
                <input type="tel" class="form-control" name="customer_phone" value="{{ auth()->user()->phone ?? '' }}" required placeholder="08xxxxxxxx">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="customerEmail" class="form-label fw-bold small text-secondary">Email Terdaftar</label>
            <input type="email" class="form-control" name="customer_email" value="{{ auth()->user()->email }}" required readonly>
          </div>
          <div class="mb-3">
            <label for="customerAddress" class="form-label fw-bold small text-secondary">Alamat Rumah Saat Ini</label>
            <textarea class="form-control" name="customer_address" rows="3" required placeholder="Alamat lengkap untuk survey dan kirim unit">{{ auth()->user()->address ?? '' }}</textarea>
          </div>
          <div class="mb-3">
            <label for="notes" class="form-label fw-bold small text-secondary">Catatan Pembelian (Opsional)</label>
            <textarea class="form-control" name="notes" rows="2" placeholder="Warna cadangan, request waktu test ride, dll."></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer border-top border-light">
        <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-primary px-4" form="orderForm">Kirim Berkas Pengajuan</button>
      </div>
    </div>
  </div>
</div>
@endauth

<script>
// Main visual calculator functions
function updateCalculator() {
  const price = parseInt(document.getElementById('dpRange').max) / 0.6; // get actual price
  const dp = parseInt(document.getElementById('dpRange').value);
  const tenor = parseInt(document.getElementById('tenorRange').value);

  // Update labels
  document.getElementById('dpText').textContent = 'Rp ' + dp.toLocaleString('id-ID');
  document.getElementById('tenorText').textContent = tenor + ' Bulan';

  // Calculate installment
  const remaining = price - dp;
  const interest = remaining * 0.05 * (tenor / 12);
  const total = remaining + interest;
  const monthly = Math.ceil(total / tenor);

  document.getElementById('installmentText').textContent = 'Rp ' + monthly.toLocaleString('id-ID');
}

// Update calculator on page load
document.addEventListener('DOMContentLoaded', function() {
  updateCalculator();

  // Handle Radio card clicks & style swaps
  @auth
    const radios = document.querySelectorAll('input[name="payment_type"]');
    const cards = {
      cash: document.getElementById('cardCash'),
      dp: document.getElementById('cardDP'),
      credit: document.getElementById('cardCredit')
    };
    const fields = {
      dp: document.getElementById('dpFields'),
      credit: document.getElementById('creditFields')
    };

    function updateActiveRadioCard() {
      // Clear borders
      Object.values(cards).forEach(c => {
        c.style.borderColor = 'var(--border)';
        c.style.backgroundColor = 'transparent';
      });

      // Hide fields
      Object.values(fields).forEach(f => f.style.display = 'none');

      // Set active
      const checked = document.querySelector('input[name="payment_type"]:checked').value;
      cards[checked].style.borderColor = 'var(--text-primary)';
      cards[checked].style.backgroundColor = 'var(--bg-tertiary)';

      if (checked === 'dp') {
        fields.dp.style.display = 'block';
        document.getElementById('dpAmountInput').name = 'dp_amount';
        document.getElementById('creditDpInput').name = '';
        updateFormRemaining();
      } else if (checked === 'credit') {
        fields.credit.style.display = 'block';
        document.getElementById('creditDpInput').name = 'dp_amount';
        document.getElementById('dpAmountInput').name = '';
        updateFormCredit();
      } else {
        document.getElementById('dpAmountInput').name = '';
        document.getElementById('creditDpInput').name = '';
      }
    }

    radios.forEach(r => r.addEventListener('change', updateActiveRadioCard));
    
    // Init radio cards
    updateActiveRadioCard();
  @endauth
});

function updateFormRemaining() {
  const price = parseInt(document.getElementById('productPrice').value);
  const dp = parseInt(document.getElementById('dpAmountInput').value) || 0;
  const remaining = price - dp;
  document.getElementById('formRemainingText').textContent = 'Rp ' + remaining.toLocaleString('id-ID');
}

function updateFormCredit() {
  const price = parseInt(document.getElementById('productPrice').value);
  const dp = parseInt(document.getElementById('creditDpInput').value) || 0;
  const tenor = parseInt(document.getElementById('creditMonthsInput').value) || 12;

  const remaining = price - dp;
  const interest = remaining * 0.05 * (tenor / 12);
  const total = remaining + interest;
  const monthly = Math.ceil(total / tenor);

  document.getElementById('formCreditRemaining').textContent = 'Rp ' + remaining.toLocaleString('id-ID');
  document.getElementById('formCreditInstallment').textContent = 'Rp ' + monthly.toLocaleString('id-ID');
}
</script>
@endsection

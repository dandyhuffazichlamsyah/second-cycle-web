@extends('layouts.main')

@section('title', 'Koleksi Motor - SecondCycle')

@section('content')
<section class="py-5 bg-white" style="margin-top: 120px;">
  <div class="container py-lg-4">
    <!-- Header Section -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="text-center">
          <span class="badge-premium badge-premium-dark mb-2">Katalog</span>
          <h1 class="display-5 fw-bold mb-3">Temukan Kendaraan Anda</h1>
          <p class="text-secondary mx-auto" style="max-width: 600px;">Jelajahi koleksi motor bekas bergaransi kami. Gunakan filter untuk menemukan motor yang sesuai kriteria Anda.</p>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <!-- Sidebar Filters (Left) -->
      <div class="col-lg-3 col-md-4">
        <div class="modern-filter-sidebar">
          <!-- Search input -->
          <div class="mb-4">
            <h5 class="modern-filter-title">Cari Unit</h5>
            <div class="position-relative">
              <input type="text" class="form-control" placeholder="Ketik nama atau model..." id="searchInput">
            </div>
          </div>
          
          <!-- Category Pills -->
          <div class="mb-4">
            <h5 class="modern-filter-title">Tipe Motor</h5>
            <div class="filter-pills d-flex flex-column gap-1">
              <button class="filter-btn-pill active" data-filter="all">
                Semua Tipe
              </button>
              <button class="filter-btn-pill" data-filter="matic">
                Matic
              </button>
              <button class="filter-btn-pill" data-filter="sport">
                Sport
              </button>
              <button class="filter-btn-pill" data-filter="bebek">
                Bebek
              </button>
            </div>
          </div>

          <!-- Brand Information -->
          <div class="mb-4 pt-3 border-top border-light">
            <h5 class="modern-filter-title">Mengapa Memilih Kami?</h5>
            <ul class="list-unstyled text-secondary small" style="line-height: 1.6;">
              <li class="mb-2"><i class="ri-checkbox-circle-line me-2 text-dark"></i> Garansi Rangka & Mesin</li>
              <li class="mb-2"><i class="ri-checkbox-circle-line me-2 text-dark"></i> Keaslian Surat Terjamin</li>
              <li class="mb-2"><i class="ri-checkbox-circle-line me-2 text-dark"></i> Layanan Servis Gratis</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Products Grid (Right) -->
      <div class="col-lg-9 col-md-8">
        <div class="row g-4 products-grid" id="productsContainer">
          @forelse($products as $product)
            <div class="col-lg-6 col-xl-4 col-md-6 mb-2 product-item" data-category="{{ $product->type }}">
              <div class="modern-card h-100 d-flex flex-column justify-content-between">
                <div>
                  <div class="position-relative">
                    <!-- Image -->
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->name }}" class="modern-card-img" style="height: 200px; object-fit: cover;">
                    
                    <!-- Badges -->
                    <div class="position-absolute top-0 start-0 p-3 d-flex flex-wrap gap-1">
                      <span class="badge-premium badge-premium-dark">{{ strtoupper($product->type) }}</span>
                      @if($product->grade)
                        <span class="badge-premium badge-premium-accent">Grade {{ $product->grade }}</span>
                      @endif
                    </div>
                  </div>

                  <div class="p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                      <span class="text-secondary small fw-semibold"><i class="ri-map-pin-line me-1"></i>{{ $product->location ?? 'Jakarta' }}</span>
                      <div class="d-flex align-items-center text-warning small">
                        @if($product->reviews_count > 0)
                            <i class="ri-star-fill me-1"></i>
                            <span class="text-dark fw-bold">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                        @else
                            <i class="ri-star-line me-1 text-muted"></i>
                            <span class="text-muted">N/A</span>
                        @endif
                      </div>
                    </div>
                    
                    <h4 class="h5 mb-2">
                      <a href="{{ route('products.show', $product->slug) }}" class="text-dark text-decoration-none">
                        {{ $product->name }}
                      </a>
                    </h4>
                    <p class="text-secondary small mb-3">{{ Str::limit($product->short_description ?? 'Motor pilihan tangguh, irit bahan bakar, performa maksimal.', 70) }}</p>
                  </div>
                </div>

                <div class="p-4 pt-0 border-top border-light d-flex justify-content-between align-items-center mt-auto">
                  <div>
                    <span class="text-secondary small d-block">Harga Cash</span>
                    <span class="fw-bold text-dark h6 mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                  </div>
                  <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary btn-sm px-3">
                    Detail
                  </a>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12">
              <div class="p-5 text-center border border-light bg-light">
                <i class="ri-search-line text-secondary mb-3" style="font-size: 3rem;"></i>
                <h4 class="fw-bold">Belum Ada Motor</h4>
                <p class="text-secondary">Mohon maaf, koleksi kendaraan kami sedang dalam pembaharuan.</p>
              </div>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('modals')
<!-- Quick View Modal (Keep for compatibility) -->
<div class="modal fade" id="quickViewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 0; border: 1px solid var(--border);">
      <div class="modal-header border-bottom border-light">
        <h5 class="modal-title fw-bold">Detail Motor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="quickViewContent">
        <!-- Content will be loaded dynamically -->
      </div>
    </div>
  </div>
</div>

<script>
// Search filter
document.getElementById('searchInput').addEventListener('input', function(e) {
  const searchTerm = e.target.value.toLowerCase();
  const products = document.querySelectorAll('.product-item');
  
  products.forEach(product => {
    const title = product.querySelector('h4').textContent.toLowerCase();
    const desc = product.querySelector('p').textContent.toLowerCase();
    
    if (title.includes(searchTerm) || desc.includes(searchTerm)) {
      product.style.display = 'block';
    } else {
      product.style.display = 'none';
    }
  });
});

// Category pills filter
document.querySelectorAll('.filter-btn-pill').forEach(pill => {
  pill.addEventListener('click', function() {
    document.querySelectorAll('.filter-btn-pill').forEach(p => p.classList.remove('active'));
    this.classList.add('active');
    
    const filter = this.dataset.filter;
    const products = document.querySelectorAll('.product-item');
    
    products.forEach(product => {
      const productCategory = product.dataset.category ? product.dataset.category.toLowerCase() : '';
      if (filter === 'all' || productCategory === filter) {
        product.style.display = 'block';
      } else {
        product.style.display = 'none';
      }
    });
  });
});
</script>
@endsection

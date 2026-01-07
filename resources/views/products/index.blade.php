@extends('layouts.main')

@section('title', 'Produk Kami - SecondCycle')

@section('content')
<section class="products-gen-z section-padding">
  <div class="container">
    <!-- Header Section -->
    <div class="row mb-5">
      <div class="col-12">
        <div class="products-header text-center">
          <h1 class="display-4 fw-bold mb-3">
            <span class="gradient-text">Koleksi Motor</span>
            <span class="emoji-bounce">🔥</span>
          </h1>
          <p class="lead text-muted">Temukan motor impianmu dengan gaya Gen Z yang kece!</p>
        </div>
      </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="row mb-4">
      <div class="col-lg-6 col-md-8 mx-auto">
        <div class="search-container">
          <div class="search-box glass-effect">
            <input type="text" class="form-control search-input" placeholder="Cari motor kesayanganmu... 🏍️" id="searchInput">
            <button class="search-btn">
              <i class="ri-search-line"></i>
            </button>
          </div>
        </div>
        
        <!-- Filter Pills -->
        <div class="filter-pills mt-3">
          <button class="filter-pill active" data-filter="all">
            <span class="pill-icon">🌟</span> Semua
          </button>
          <button class="filter-pill" data-filter="matic">
            <span class="pill-icon">⚡</span> Matic
          </button>
          <button class="filter-pill" data-filter="sport">
            <span class="pill-icon">🏁</span> Sport
          </button>
          <button class="filter-pill" data-filter="bebek">
            <span class="pill-icon">🛵</span> Bebek
          </button>
        </div>
      </div>
    </div>

    <!-- Products Grid -->
    <div class="row products-grid" id="productsContainer">
      @forelse($products as $product)
        <div class="col-lg-4 col-md-6 mb-4 product-item" data-category="{{ $product->type }}">
          <div class="product-card-gen-z">
            <!-- Badge -->
            <div class="product-badge-gen-z">
              <span class="badge-type">
                @if($product->type === 'matic')
                  ⚡ Matic
                @elseif($product->type === 'sport')
                  🏁 Sport
                @else
                  🛵 Bebek
                @endif
              </span>
              <span class="badge bg-secondary ms-2 text-white">{{ $product->cc }} cc</span>
              @if($product->grade)
                <span class="badge bg-{{ $product->grade_color }} ms-1">Grade {{ $product->grade }}</span>
              @endif
            </div>

            <!-- Wishlist Button -->
            <button class="wishlist-btn" onclick="toggleWishlist(this)">
              <i class="ri-heart-line"></i>
            </button>

            <!-- Product Image -->
            <div class="product-image-container">
              <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image-gen-z">
              <div class="image-overlay"></div>
            </div>

            <!-- Product Info -->
            <div class="product-info-gen-z">
              <div class="d-flex justify-content-between align-items-start mb-2">
                  @if($product->location)
                    <div class="small text-muted">
                      <i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $product->location }}
                    </div>
                  @endif
                  <div class="rating small">
                    @if($product->reviews_count > 0)
                        <i class="ri-star-fill text-warning"></i>
                        <span class="ms-1">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                    @else
                        <i class="ri-star-line text-muted"></i>
                        <span class="ms-1 text-muted">N/A</span>
                    @endif
                  </div>
              </div>
              <h3 class="product-title-gen-z">
                <a href="{{ route('products.show', $product->slug) }}">
                  {{ $product->name }}
                </a>
              </h3>
              <p class="product-desc-gen-z">{{ $product->short_description }}</p>
              
              <div class="product-footer">
                <div class="price-tag">
                  <span class="price-label">Start from</span>
                  <span class="price-amount">RP. {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <button class="quick-view-btn" onclick="quickView('{{ $product->slug }}')">
                  <i class="ri-eye-line"></i>
                </button>
              </div>
            </div>

            <!-- Hover Effects -->
            <div class="card-glow"></div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="empty-state text-center py-5">
            <div class="empty-icon">🔍</div>
            <h3>Oops, motor belum tersedia</h3>
            <p>Yuk, cek lagi nanti!</p>
          </div>
        </div>
      @endforelse
    </div>
  </div>
</section>
@endsection

@section('modals')
<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title">Detail Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="quickViewContent">
        <!-- Content will be loaded dynamically -->
      </div>
    </div>
  </div>
</div>

<style>
/* Override tooplate modal styles for quick view */
#quickViewModal .modal-header,
#quickViewModal .modal-body,
#quickViewModal .modal-footer {
    padding: 1rem !important;
}
#quickViewModal .btn-close {
    position: relative !important;
    top: auto !important;
    right: auto !important;
}
#quickViewModal .modal-content {
    pointer-events: auto !important;
}
#quickViewModal a,
#quickViewModal button {
    pointer-events: auto !important;
    position: relative;
    z-index: 1;
}
</style>

<script>
// Search functionality
document.getElementById('searchInput').addEventListener('input', function(e) {
  const searchTerm = e.target.value.toLowerCase();
  const products = document.querySelectorAll('.product-item');
  
  products.forEach(product => {
    const title = product.querySelector('.product-title-gen-z').textContent.toLowerCase();
    const desc = product.querySelector('.product-desc-gen-z').textContent.toLowerCase();
    
    if (title.includes(searchTerm) || desc.includes(searchTerm)) {
      product.style.display = 'block';
    } else {
      product.style.display = 'none';
    }
  });
});

// Filter functionality
document.querySelectorAll('.filter-pill').forEach(pill => {
  pill.addEventListener('click', function() {
    // Remove active class from all pills
    document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    // Add active class to clicked pill
    this.classList.add('active');
    
    const filter = this.dataset.filter;
    const products = document.querySelectorAll('.product-item');
    
    products.forEach(product => {
      if (filter === 'all' || product.dataset.category === filter) {
        product.style.display = 'block';
      } else {
        product.style.display = 'none';
      }
    });
  });
});

// Wishlist toggle
function toggleWishlist(btn) {
  btn.classList.toggle('active');
  const icon = btn.querySelector('i');
  if (btn.classList.contains('active')) {
    icon.classList.remove('ri-heart-line');
    icon.classList.add('ri-heart-fill');
    // Add animation
    btn.style.transform = 'scale(1.2)';
    setTimeout(() => {
      btn.style.transform = 'scale(1)';
    }, 200);
  } else {
    icon.classList.remove('ri-heart-fill');
    icon.classList.add('ri-heart-line');
  }
}

// Quick view function
function quickView(slug) {
  const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
  document.getElementById('quickViewContent').innerHTML = `
    <div class="text-center py-4">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="mt-2">Memuat detail produk...</p>
    </div>
  `;
  modal.show();
  
  // Fetch product data
  fetch(`/api/products/${slug}`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const product = data.product;
        const imageUrl = product.image ? `${storageBaseUrl}/${product.image}` : noImageUrl;
        document.getElementById('quickViewContent').innerHTML = `
          <div class="row">
            <div class="col-md-5">
              <img src="${imageUrl}" class="img-fluid rounded-3" alt="${product.name}" style="width:100%; height:300px; object-fit:contain; background-color: #f8f9fa;">
            </div>
            <div class="col-md-7">
              <div class="mb-2">
                ${product.brand ? `<span class="badge bg-primary me-1">${product.brand}</span>` : ''}
                ${product.type ? `<span class="badge bg-info me-1">${product.type}</span>` : ''}
                ${product.cc ? `<span class="badge bg-secondary me-1">${product.cc}cc</span>` : ''}
                ${product.grade ? `<span class="badge bg-${product.grade === 'A' ? 'success' : (product.grade === 'B' ? 'primary' : (product.grade === 'C' ? 'warning' : 'danger'))}">Grade ${product.grade}</span>` : ''}
              </div>
              ${product.location ? `<div class="small text-muted mb-2"><i class="fas fa-map-marker-alt me-1 text-primary"></i>${product.location}</div>` : ''}
              <h3 class="mb-2">${product.name}</h3>
              <p class="text-muted">${product.short_description || 'Motor berkualitas dengan kondisi prima.'}</p>
              <h4 class="text-primary mb-3">Rp ${parseInt(product.price).toLocaleString('id-ID')}</h4>
              <div class="d-flex gap-2">
                <a href="/products/${product.slug}" class="btn btn-primary flex-fill">
                  <i class="fas fa-eye me-2"></i>Lihat Detail
                </a>
                <a href="/products/${product.slug}" class="btn btn-success flex-fill">
                  <i class="fas fa-shopping-cart me-2"></i>Beli Sekarang
                </a>
              </div>
            </div>
          </div>
        `;
      } else {
        document.getElementById('quickViewContent').innerHTML = `
          <div class="text-center py-4">
            <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
            <p>Gagal memuat detail produk</p>
          </div>
        `;
      }
    })
    .catch(error => {
      console.error('Error:', error);
      document.getElementById('quickViewContent').innerHTML = `
        <div class="text-center py-4">
          <i class="fas fa-exclamation-circle fa-3x text-danger mb-3"></i>
          <p>Terjadi kesalahan saat memuat produk</p>
        </div>
      `;
    });
}
</script>
@endsection

@extends('layouts.main')

@section('title', 'Beranda - SecondCycle')

@section('content')
  <!-- Hero Section -->
  <section class="hero-section position-relative overflow-hidden">
    <div class="container">
      <div class="row min-vh-100 align-items-center">
        <div class="col-lg-6" data-aos="fade-right">
          <h1 class="display-4 fw-bold mb-4">Temukan Motor Bekas Berkualitas</h1>
          <p class="lead mb-5">Dapatkan motor impian Anda dengan harga terbaik dan kualitas terjamin. Kami menyediakan berbagai pilihan motor bekas terawat dengan kualitas premium.</p>
          <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg px-4">
              Lihat Koleksi <i class="ri-arrow-right-line ms-2"></i>
            </a>
            <a href="#featured" class="btn btn-outline-dark btn-lg px-4">
              <i class="ri-information-line me-2"></i> Pelajari Lebih Lanjut
            </a>
          </div>
          <div class="d-flex align-items-center mt-5">
            <div class="d-flex me-4">
              <div class="avatar-group">
                @forelse($reviews->take(3) as $review)
                    @if($review->user->avatar)
                        <img src="{{ asset('storage/avatars/' . $review->user->avatar) }}" class="avatar" alt="{{ $review->user->name }}" style="object-fit: cover;">
                    @else
                        <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; border-radius: 50%; border: 2px solid #fff; font-size: 14px; font-weight: bold;">
                            {{ strtoupper(substr($review->user->name, 0, 2)) }}
                        </div>
                    @endif
                @empty
                    <img src="{{ asset('images/people/Bahlil.webp') }}" class="avatar" alt="Bahlil">
                    <img src="{{ asset('images/people/raja juli.jpg') }}" class="avatar" alt="Raja Juli">
                    <img src="{{ asset('images/people/gibran.jpeg') }}" class="avatar" alt="Gibran">
                @endforelse
              </div>
            </div>
            <div>
              <div class="d-flex align-items-center">
                <div class="text-warning me-1">
                  @for($i = 1; $i <= 5; $i++)
                    @if($ratingStats['average'] >= $i)
                      <i class="ri-star-fill"></i>
                    @elseif($ratingStats['average'] >= $i - 0.5)
                      <i class="ri-star-half-fill"></i>
                    @else
                      <i class="ri-star-line"></i>
                    @endif
                  @endfor
                </div>
                <span class="ms-1">{{ $ratingStats['average'] }}/5 ({{ $ratingStats['count'] > 1000 ? number_format($ratingStats['count']/1000, 1) . 'k+' : $ratingStats['count'] }} ulasan)</span>
              </div>
              <p class="mb-0 small text-muted">{{ number_format($ratingStats['satisfied_customers'], 0, ',', '.') }} Pelanggan Puas</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block" data-aos="fade-left" data-aos-delay="200">
          <div class="hero-image">
            <img src="{{ asset('images/hero-motor.png') }}" alt="Motor SecondCycle" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
    <div class="hero-shape"></div>
  </section>

  <!-- Features Section -->
  <section class="py-5 bg-light" id="featured">
    <div class="container">
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up">
          <div class="feature-card p-4 rounded-3 h-100">
            <div class="feature-icon mb-3">
              <i class="ri-shield-check-line"></i>
            </div>
            <h4>Kualitas Terjamin</h4>
            <p class="text-muted mb-0">Setiap motor melalui proses inspeksi ketat untuk memastikan kualitas terbaik.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-card p-4 rounded-3 h-100">
            <div class="feature-icon mb-3">
              <i class="ri-24-hours-line"></i>
            </div>
            <h4>Garansi Resmi</h4>
            <p class="text-muted mb-0">Dapatkan garansi resmi untuk ketenangan berkendara Anda.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-card p-4 rounded-3 h-100">
            <div class="feature-icon mb-3">
              <i class="ri-customer-service-line"></i>
            </div>
            <h4>Dukungan 24/7</h4>
            <p class="text-muted mb-0">Tim kami siap membantu Anda kapan saja, di mana saja.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Products Section -->
  <section class="py-5">
    <div class="container">
      <div class="row mb-5">
        <div class="col-12 text-center" data-aos="fade-up">
          <span class="badge bg-primary-soft text-primary rounded-pill mb-2">Koleksi Terbaru</span>
          <h2 class="fw-bold">Motor Pilihan Terbaik</h2>
          <p class="text-muted">Temukan motor impian Anda di antara koleksi terbaik kami</p>
        </div>
      </div>
      
      <div class="row g-4">
        @foreach($products as $product)
          <div class="col-xl-3 col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
            <div class="product-card h-100">
              <div class="product-badge">
                @if($product->is_featured)
                  <span class="badge bg-danger">Featured</span>
                @endif
                @if($product->discount > 0)
                  <span class="badge bg-success">-{{ $product->discount }}%</span>
                @endif
              </div>
              <div class="product-thumb">
                <a href="{{ route('products.show', $product->slug) }}" class="d-block">
                  <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
                </a>
                <div class="product-actions">
                  <button class="btn btn-icon btn-light rounded-circle me-2" onclick="toggleWishlist(this)" data-bs-toggle="tooltip" title="Add to Wishlist">
                    <i class="ri-heart-line"></i>
                  </button>
                  <button class="btn btn-icon btn-light rounded-circle" onclick="quickView('{{ $product->slug }}')" data-bs-toggle="tooltip" title="Quick View">
                    <i class="ri-eye-line"></i>
                  </button>
                </div>
              </div>
              <div class="product-details p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                  @if($product->type)
                    <span class="badge bg-primary-soft text-primary me-1">
                      {{ $product->type }}
                    </span>
                  @endif
                  @if($product->cc)
                    <span class="badge bg-secondary-soft text-secondary">
                      {{ $product->cc }} cc
                    </span>
                  @endif
                  @if($product->grade)
                    <span class="badge bg-{{ $product->grade_color }} text-white ms-1">Grade {{ $product->grade }}</span>
                  @endif
                  <div class="rating">
                    @if($product->reviews_count > 0)
                        <i class="ri-star-fill text-warning"></i>
                        <span class="ms-1">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                    @else
                        <i class="ri-star-line text-muted"></i>
                        <span class="ms-1 text-muted small">N/A</span>
                    @endif
                  </div>
                </div>
                @if($product->location)
                  <div class="small text-muted mb-1">
                    <i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $product->location }}
                  </div>
                @endif
                <h5 class="mb-1">
                  <a href="{{ route('products.show', $product->slug) }}" class="text-dark">
                    {{ $product->name }}
                  </a>
                </h5>
                @if($product->short_description)
                  <p class="small text-muted mb-2">
                    {{ Str::limit($product->short_description, 60) }}
                  </p>
                @endif
                <div class="d-flex justify-content-between align-items-center mt-3">
                  <div>
                    @if($product->discount > 0)
                      <span class="h5 mb-0 text-primary fw-bold">
                        Rp {{ number_format($product->price - ($product->price * $product->discount / 100), 0, ',', '.') }}
                      </span>
                      <small class="text-decoration-line-through text-muted ms-2">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                      </small>
                    @else
                      <span class="h5 mb-0 text-primary fw-bold">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                      </span>
                    @endif
                  </div>
                  <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">
                    <i class="ri-shopping-cart-2-line me-1"></i> Beli
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      
      <div class="text-center mt-5" data-aos="fade-up">
        <a href="{{ route('products.index') }}" class="btn btn-outline-primary px-4">
          Lihat Semua Motor <i class="ri-arrow-right-line ms-2"></i>
        </a>
      </div>
    </div>
  </section>

  <!-- CTA Section -->
  <section class="py-5 bg-dark text-white position-relative overflow-hidden">
    <div class="container position-relative">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right">
          <h2 class="fw-bold mb-3">Butuh Bantuan Memilih Motor?</h2>
          <p class="lead mb-4">Tim ahli kami siap membantu Anda menemukan motor yang sesuai dengan kebutuhan dan budget Anda.</p>
          <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('contact.show') }}" class="btn btn-light">
              <i class="ri-whatsapp-line me-2"></i> Chat Sekarang
            </a>
            <a href="tel:+6287769002763" class="btn btn-outline-light">
              <i class="ri-phone-line me-2"></i> 0877-6900-2763
            </a>
          </div>
        </div>
        <div class="col-lg-6" data-aos="fade-left">
          <div class="cta-image">
            <img src="{{ asset('images/Pelayanan.png') }}" alt="Customer Support" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
    <div class="cta-shape"></div>
  </section>

  <!-- Testimonials -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center mb-5" data-aos="fade-up">
          <span class="badge bg-primary-soft text-primary rounded-pill mb-2">Testimoni</span>
          <h2 class="fw-bold">Apa Kata Pelanggan Kami</h2>
          <p class="text-muted">Lihat apa yang dikatakan pelanggan tentang pengalaman mereka dengan SecondCycle</p>
        </div>
      </div>
      
      <div class="row">
        <div class="col-12">
          <div class="splide" data-aos="fade-up">
            <div class="splide__track">
              <ul class="splide__list">
                @forelse($reviews as $review)
                <li class="splide__slide">
                  <div class="testimonial-card p-4 rounded-3 h-100">
                    <div class="d-flex align-items-center mb-4">
                      @if($review->user->avatar)
                        <img src="{{ asset('storage/avatars/' . $review->user->avatar) }}" alt="{{ $review->user->name }}" class="rounded-circle me-3" width="60" height="60" style="object-fit: cover;">
                      @else
                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; font-size: 1.2rem;">
                          {{ strtoupper(substr($review->user->name, 0, 2)) }}
                        </div>
                      @endif
                      <div>
                        <h5 class="mb-0">{{ $review->user->name }}</h5>
                        <span class="text-muted small">Pembeli {{ $review->product->name }}</span>
                      </div>
                    </div>
                    <div class="mb-3 text-warning">
                      @for($i = 1; $i <= 5; $i++)
                        @if($i <= $review->rating)
                          <i class="ri-star-fill"></i>
                        @else
                          <i class="ri-star-line"></i>
                        @endif
                      @endfor
                    </div>
                    <p class="mb-0">"{{ $review->comment ?? 'Pelayanan sangat memuaskan!' }}"</p>
                  </div>
                </li>
                @empty
                <!-- Static Fallback if no reviews -->
                <li class="splide__slide">
                  <div class="testimonial-card p-4 rounded-3 h-100">
                    <div class="d-flex align-items-center mb-4">
                      <img src="{{ asset('images/people/Bahlil.webp') }}" alt="Bahlil" class="rounded-circle me-3" width="60">
                      <div>
                        <h5 class="mb-0">Bahlil Lahadalia</h5>
                        <span class="text-muted">Pembeli Beat 2022</span>
                      </div>
                    </div>
                    <div class="mb-3 text-warning">
                      <i class="ri-star-fill"></i>
                      <i class="ri-star-fill"></i>
                      <i class="ri-star-fill"></i>
                      <i class="ri-star-fill"></i>
                      <i class="ri-star-fill"></i>
                    </div>
                    <p class="mb-0">"Sangat puas dengan pelayanan dan kualitas motornya. Kondisi seperti baru, mesin halus, dan harga bersaing. Terima kasih SecondCycle!"</p>
                  </div>
                </li>
                @endforelse
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Brands -->
  <section class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 text-center mb-5" data-aos="fade-up">
          <h2 class="fw-bold">Brand Ternama</h2>
          <p class="text-muted">Kami bekerja sama dengan brand-brand terpercaya</p>
        </div>
      </div>
      <div class="row align-items-center">
        <div class="col-6 col-md-2 mb-4" data-aos="fade-up" data-aos-delay="100">
          <div class="brand-logo p-3">
            <img src="{{ asset('images/brands/honda.png') }}" alt="Honda" class="img-fluid">
          </div>
        </div>
        <div class="col-6 col-md-2 mb-4" data-aos="fade-up" data-aos-delay="200">
          <div class="brand-logo p-3">
            <img src="{{ asset('images/brands/yamaha.png') }}" alt="Yamaha" class="img-fluid">
          </div>
        </div>
        <div class="col-6 col-md-2 mb-4" data-aos="fade-up" data-aos-delay="300">
          <div class="brand-logo p-3">
            <img src="{{ asset('images/brands/suzuki.png') }}" alt="Suzuki" class="img-fluid">
          </div>
        </div>
        <div class="col-6 col-md-2 mb-4" data-aos="fade-up" data-aos-delay="400">
          <div class="brand-logo p-3">
            <img src="{{ asset('images/brands/kawasaki.png') }}" alt="Kawasaki" class="img-fluid">
          </div>
        </div>
        <div class="col-6 col-md-2 mb-4" data-aos="fade-up" data-aos-delay="500">
          <div class="brand-logo p-3">
            <img src="{{ asset('images/brands/vespa.png') }}" alt="Vespa" class="img-fluid">
          </div>
        </div>
        <div class="col-6 col-md-2 mb-4" data-aos="fade-up" data-aos-delay="600">
          <div class="brand-logo p-3">
            <img src="{{ asset('images/brands/ktm.png') }}" alt="KTM" class="img-fluid">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="py-5 bg-primary text-white">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center" data-aos="fade-up">
          <h2 class="fw-bold mb-3">Dapatkan Penawaran Terbaru</h2>
          <p class="mb-4">Berlangganan newsletter kami untuk mendapatkan informasi terbaru tentang produk dan penawaran spesial.</p>
          <form class="row g-2 justify-content-center">
            <div class="col-md-8">
              <div class="input-group">
                <input type="email" class="form-control form-control-lg" placeholder="Alamat email Anda">
                <button class="btn btn-dark px-4" type="submit">
                  <i class="ri-send-plane-line me-1"></i> Berlangganan
                </button>
              </div>
            </div>
          </form>
        </div>
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
#quickViewModal .modal-content {
    pointer-events: auto !important;
}
</style>

<script>
const storageBaseUrl = "{{ asset('storage') }}";
const noImageUrl = "{{ asset('images/no-image.png') }}";

// Wishlist toggle
function toggleWishlist(btn) {
  btn.classList.toggle('active');
  const icon = btn.querySelector('i');
  if (btn.classList.contains('active')) {
    icon.classList.remove('ri-heart-line');
    icon.classList.add('ri-heart-fill');
    icon.classList.add('text-danger');
    // Add animation
    btn.style.transform = 'scale(1.2)';
    setTimeout(() => {
      btn.style.transform = 'scale(1)';
    }, 200);
  } else {
    icon.classList.remove('ri-heart-fill');
    icon.classList.remove('text-danger');
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
        const imageUrl = product.image ? `/storage/${product.image}` : '/images/no-image.png';
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

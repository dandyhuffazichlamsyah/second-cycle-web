@extends('layouts.main')

@section('title', 'Beranda - SecondCycle')

@section('content')
  <!-- Hero Section -->
  <section class="position-relative overflow-hidden py-5 bg-white border-bottom border-light" style="margin-top: 120px;">
    <div class="container py-lg-5">
      <div class="row align-items-center min-vh-75 g-5">
        <div class="col-lg-6" data-aos="fade-right">
          <div class="d-inline-flex align-items-center mb-3">
            <span class="badge-premium badge-premium-accent me-2">Terpercaya</span>
            <span class="text-muted small fw-semibold">Otomotif Kualitas Premium</span>
          </div>
          <h1 class="display-title mb-4">Temukan Motor Impian Anda Tanpa Ragu.</h1>
          <p class="lead text-secondary mb-5">Setiap unit motor bekas di SecondCycle melalui inspeksi ketat 120+ titik penilaian. Kualitas setara motor baru dengan transparansi harga dan kelengkapan dokumen yang dijamin 100% aman.</p>
          
          <div class="d-flex flex-wrap gap-3 mb-5">
            <a href="{{ route('products.index') }}" class="btn btn-primary px-4 py-3">
              Jelajahi Koleksi <i class="ri-arrow-right-line ms-2"></i>
            </a>
            <a href="#featured" class="btn btn-outline-dark px-4 py-3">
              Pelajari Standar Kami
            </a>
          </div>

          <!-- Rating Stats Minimalist -->
          <div class="d-flex align-items-center pt-3 border-top border-light">
            <div class="d-flex me-4">
              <div class="avatar-group" style="display: flex; align-items: center;">
                @forelse($reviews->take(3) as $review)
                    @if($review->user->avatar)
                        <img src="{{ asset('storage/avatars/' . $review->user->avatar) }}" class="rounded-circle border border-2 border-white" alt="{{ $review->user->name }}" style="width: 40px; height: 40px; object-fit: cover; margin-left: -10px;">
                    @else
                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center border border-2 border-white" style="width: 40px; height: 40px; font-size: 11px; font-weight: bold; margin-left: -10px;">
                            {{ strtoupper(substr($review->user->name, 0, 2)) }}
                        </div>
                    @endif
                @empty
                    <img src="{{ asset('images/people/Bahlil.webp') }}" class="rounded-circle border border-2 border-white" alt="Bahlil" style="width: 40px; height: 40px; object-fit: cover; margin-left: -10px;" onerror="this.src='https://ui-avatars.com/api/?name=B&background=random'">
                    <img src="{{ asset('images/people/raja juli.jpg') }}" class="rounded-circle border border-2 border-white" alt="Raja Juli" style="width: 40px; height: 40px; object-fit: cover; margin-left: -10px;" onerror="this.src='https://ui-avatars.com/api/?name=R&background=random'">
                    <img src="{{ asset('images/people/gibran.jpeg') }}" class="rounded-circle border border-2 border-white" alt="Gibran" style="width: 40px; height: 40px; object-fit: cover; margin-left: -10px;" onerror="this.src='https://ui-avatars.com/api/?name=G&background=random'">
                @endforelse
              </div>
            </div>
            <div>
              <div class="d-flex align-items-center">
                <div class="text-warning me-2">
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
                <span class="fw-bold small">{{ $ratingStats['average'] }}/5</span>
                <span class="text-secondary small ms-2">({{ $ratingStats['count'] }} ulasan pelanggan)</span>
              </div>
              <p class="mb-0 small text-secondary">98% Pelanggan merekomendasikan layanan kami</p>
            </div>
          </div>
        </div>
        <div class="col-lg-6 d-none d-lg-block" data-aos="zoom-in" data-aos-delay="100">
          <div class="position-relative p-4" style="background-color: var(--bg-tertiary);">
            <img src="{{ asset('images/hero-motor.png') }}" alt="Motor SecondCycle" class="img-fluid w-100" style="filter: drop-shadow(0 20px 30px rgba(0,0,0,0.15));" onerror="this.src='https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=800&q=80'">
            
            <!-- Floating overlay tech details -->
            <div class="position-absolute bottom-0 end-0 bg-dark text-white p-4 m-3" style="max-width: 240px;">
              <h6 class="text-uppercase tracking-wider small text-secondary mb-1">Featured Model</h6>
              <h5 class="fw-bold mb-2">Honda CB150R</h5>
              <div class="d-flex justify-content-between small text-secondary">
                <span>Eng: 150cc</span>
                <span>Odo: 12k km</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Features Section (Minimalist Listing) -->
  <section class="py-5 bg-white border-bottom border-light" id="featured">
    <div class="container py-lg-4">
      <div class="row g-4">
        <div class="col-md-4" data-aos="fade-up">
          <div class="p-4 border border-light h-100">
            <div class="mb-3 text-dark">
              <i class="ri-shield-check-line" style="font-size: 2rem; color: var(--accent);"></i>
            </div>
            <h5 class="fw-bold mb-2">Inspeksi Ketat 120+ Titik</h5>
            <p class="text-secondary mb-0">Setiap motor diinspeksi oleh mekanik ahli kami, mencakup rangka, mesin, kelistrikan, hingga keaslian dokumen.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="p-4 border border-light h-100">
            <div class="mb-3 text-dark">
              <i class="ri-exchange-funds-line" style="font-size: 2rem; color: var(--accent);"></i>
            </div>
            <h5 class="fw-bold mb-2">Simulasi Kredit Fleksibel</h5>
            <p class="text-secondary mb-0">Sesuaikan uang muka (DP) dan tenor pembayaran bulanan Anda secara transparan langsung dari halaman produk kami.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="p-4 border border-light h-100">
            <div class="mb-3 text-dark">
              <i class="ri-shake-hands-line" style="font-size: 2rem; color: var(--accent);"></i>
            </div>
            <h5 class="fw-bold mb-2">Jaminan 100% Dokumen Asli</h5>
            <p class="text-secondary mb-0">Garansi uang kembali penuh jika dokumen kendaraan (STNK & BPKB) terbukti bermasalah atau tidak sah secara hukum.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Products Section -->
  <section class="py-5 bg-white">
    <div class="container py-lg-4">
      <div class="row mb-5 align-items-end">
        <div class="col-md-8" data-aos="fade-right">
          <span class="badge-premium badge-premium-dark mb-2">Katalog</span>
          <h2 class="fw-bold">Koleksi Motor Pilihan Terbaik</h2>
          <p class="text-secondary mb-0">Temukan motor dengan kualitas premium yang telah lolos inspeksi mendalam kami.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0" data-aos="fade-left">
          <a href="{{ route('products.index') }}" class="btn btn-outline-dark">
            Lihat Semua Koleksi <i class="ri-arrow-right-line ms-2"></i>
          </a>
        </div>
      </div>
      
      <div class="row g-4">
        @foreach($products as $product)
          <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="modern-card h-100 d-flex flex-col justify-content-between">
              <div>
                <div class="position-relative">
                  <!-- Product Image -->
                  <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=600&q=80' }}" alt="{{ $product->name }}" class="modern-card-img" style="height: 250px; object-fit: cover;">
                  
                  <!-- Badges overlay -->
                  <div class="position-absolute top-0 start-0 p-3 d-flex flex-wrap gap-2">
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
                  <p class="text-secondary small mb-4">{{ Str::limit($product->short_description ?? 'Motor performa optimal dengan kondisi fisik terawat.', 90) }}</p>
                </div>
              </div>
              
              <div class="p-4 pt-0 border-top border-light d-flex justify-content-between align-items-center" style="margin-top: auto;">
                <div>
                  <span class="text-secondary small d-block">Harga Cash</span>
                  <span class="fw-bold text-dark h5 mb-0">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-primary btn-sm px-3">
                  Detail <i class="ri-arrow-right-line ms-1"></i>
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- CTA Section (Premium minimalist styling) -->
  <section class="py-5 bg-dark text-white border-top border-bottom border-dark">
    <div class="container py-lg-4">
      <div class="row align-items-center g-5">
        <div class="col-lg-7" data-aos="fade-right">
          <span class="badge-premium badge-premium-accent mb-3 d-inline-block">Dukungan Penjualan</span>
          <h2 class="display-5 fw-bold text-white mb-3">Ingin Konsultasi Sebelum Membeli?</h2>
          <p class="text-secondary mb-0 fs-5">Konsultan otomotif kami siap menjawab pertanyaan Anda mengenai riwayat motor, opsi pembiayaan, hingga penjadwalan test ride langsung di dealer kami.</p>
        </div>
        <div class="col-lg-5 text-lg-end" data-aos="fade-left">
          <div class="d-flex flex-wrap gap-3 justify-content-lg-end">
            <a href="{{ route('contact.show') }}" class="btn btn-light px-4 py-3 text-dark fw-bold">
              <i class="ri-whatsapp-line me-2"></i> Hubungi WhatsApp
            </a>
            <a href="tel:+6287769002763" class="btn btn-outline-light px-4 py-3">
              Call Center
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section class="py-5 bg-white border-bottom border-light">
    <div class="container py-lg-4">
      <div class="row justify-content-center mb-5">
        <div class="col-lg-8 text-center" data-aos="fade-up">
          <span class="badge-premium badge-premium-dark mb-2">Testimoni</span>
          <h2 class="fw-bold">Kata Mereka yang Telah Berkendara</h2>
          <p class="text-secondary">Ulasan jujur dari para pelanggan yang membeli motor bekas impiannya melalui SecondCycle.</p>
        </div>
      </div>
      
      <div class="row g-4">
        @forelse($reviews as $review)
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            <div class="p-4 border border-light h-100 d-flex flex-column justify-content-between">
              <div>
                <div class="d-flex align-items-center mb-3">
                  @if($review->user->avatar)
                    <img src="{{ asset('storage/avatars/' . $review->user->avatar) }}" alt="{{ $review->user->name }}" class="rounded-circle me-3" width="48" height="48" style="object-fit: cover;">
                  @else
                    <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-weight: bold; font-size: 14px;">
                      {{ strtoupper(substr($review->user->name, 0, 2)) }}
                    </div>
                  @endif
                  <div>
                    <h6 class="mb-0 fw-bold">{{ $review->user->name }}</h6>
                    <span class="text-secondary small">Pembeli {{ $review->product->name }}</span>
                  </div>
                </div>
                <div class="text-warning small mb-3">
                  @for($i = 1; $i <= 5; $i++)
                    @if($i <= $review->rating)
                      <i class="ri-star-fill"></i>
                    @else
                      <i class="ri-star-line"></i>
                    @endif
                  @endfor
                </div>
                <p class="text-secondary mb-0 italic">"{{ $review->comment ?? 'Sangat merekomendasikan SecondCycle, motor mulus dan surat lengkap!' }}"</p>
              </div>
            </div>
          </div>
        @empty
          <!-- Static Testimonial fallback -->
          <div class="col-md-4" data-aos="fade-up">
            <div class="p-4 border border-light h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-weight: bold; font-size: 14px;">BH</div>
                <div>
                  <h6 class="mb-0 fw-bold">Bahlil H.</h6>
                  <span class="text-secondary small">Pembeli Beat 2022</span>
                </div>
              </div>
              <div class="text-warning small mb-3">
                <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
              </div>
              <p class="text-secondary mb-0">"Proses cepat tanpa ribet. Kondisi motor luar biasa mulus, kelistrikan oke, langsung siap pakai harian."</p>
            </div>
          </div>
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="p-4 border border-light h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-weight: bold; font-size: 14px;">RJ</div>
                <div>
                  <h6 class="mb-0 fw-bold">Raja Juli</h6>
                  <span class="text-secondary small">Pembeli Vario 2023</span>
                </div>
              </div>
              <div class="text-warning small mb-3">
                <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i>
              </div>
              <p class="text-secondary mb-0">"Keren banget simulator kreditnya membantu banget nyesuaiin DP sama kantong, proses verifikasi di dealer ramah."</p>
            </div>
          </div>
          <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="p-4 border border-light h-100">
              <div class="d-flex align-items-center mb-3">
                <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center me-3" style="width: 48px; height: 48px; font-weight: bold; font-size: 14px;">GS</div>
                <div>
                  <h6 class="mb-0 fw-bold">Gibran S.</h6>
                  <span class="text-secondary small">Pembeli NMax 2021</span>
                </div>
              </div>
              <div class="text-warning small mb-3">
                <i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-fill"></i><i class="ri-star-half-fill"></i>
              </div>
              <p class="text-secondary mb-0">"Motornya enak banget dipakai, dokumen lengkap dan dikasih bonus helm. Mantap betul SecondCycle!"</p>
            </div>
          </div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- Brands Section -->
  <section class="py-5 bg-white border-bottom border-light">
    <div class="container py-lg-3">
      <div class="row align-items-center text-center g-4 justify-content-center">
        <div class="col-6 col-md-2" data-aos="fade-up" data-aos-delay="100">
          <img src="{{ asset('images/brands/honda.png') }}" alt="Honda" style="height: 32px; object-fit: contain; filter: grayscale(1); opacity: 0.6;" onerror="this.style.display='none'">
          <span class="fw-bold text-muted small">HONDA</span>
        </div>
        <div class="col-6 col-md-2" data-aos="fade-up" data-aos-delay="200">
          <img src="{{ asset('images/brands/yamaha.png') }}" alt="Yamaha" style="height: 32px; object-fit: contain; filter: grayscale(1); opacity: 0.6;" onerror="this.style.display='none'">
          <span class="fw-bold text-muted small">YAMAHA</span>
        </div>
        <div class="col-6 col-md-2" data-aos="fade-up" data-aos-delay="300">
          <img src="{{ asset('images/brands/suzuki.png') }}" alt="Suzuki" style="height: 32px; object-fit: contain; filter: grayscale(1); opacity: 0.6;" onerror="this.style.display='none'">
          <span class="fw-bold text-muted small">SUZUKI</span>
        </div>
        <div class="col-6 col-md-2" data-aos="fade-up" data-aos-delay="400">
          <img src="{{ asset('images/brands/kawasaki.png') }}" alt="Kawasaki" style="height: 32px; object-fit: contain; filter: grayscale(1); opacity: 0.6;" onerror="this.style.display='none'">
          <span class="fw-bold text-muted small">KAWASAKI</span>
        </div>
        <div class="col-6 col-md-2" data-aos="fade-up" data-aos-delay="500">
          <img src="{{ asset('images/brands/vespa.png') }}" alt="Vespa" style="height: 32px; object-fit: contain; filter: grayscale(1); opacity: 0.6;" onerror="this.style.display='none'">
          <span class="fw-bold text-muted small">VESPA</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Newsletter Section -->
  <section class="py-5 bg-white">
    <div class="container py-lg-4">
      <div class="p-5 border border-light text-center" style="background-color: var(--bg-tertiary);" data-aos="fade-up">
        <h2 class="fw-bold mb-2">Dapatkan Penawaran Terbaru</h2>
        <p class="text-secondary mb-4 mx-auto" style="max-width: 500px;">Dapatkan info ketersediaan stok motor bekas berkualitas dan penawaran diskon spesial langsung di inbox email Anda.</p>
        <form class="row g-2 justify-content-center" onsubmit="event.preventDefault(); alert('Terima kasih telah berlangganan!');">
          <div class="col-md-6 col-lg-5">
            <div class="d-flex">
              <input type="email" class="form-control" placeholder="Alamat email Anda" required style="border-right: none;">
              <button class="btn btn-primary px-4" type="submit">Gabung</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
@endsection

@section('modals')
<!-- Quick View Modal -->
<div class="modal fade" id="quickViewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content" style="border-radius: 0; border: 1px solid var(--border);">
      <div class="modal-header border-bottom border-light">
        <h5 class="modal-title fw-bold">Pratinjau Motor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="quickViewContent">
        <!-- Loaded via Ajax -->
      </div>
    </div>
  </div>
</div>

<script>
// Wishlist toggle function
function toggleWishlist(btn) {
  btn.classList.toggle('active');
  const icon = btn.querySelector('i');
  if (btn.classList.contains('active')) {
    icon.classList.remove('ri-heart-line');
    icon.classList.add('ri-heart-fill');
    icon.style.color = 'var(--accent)';
  } else {
    icon.classList.remove('ri-heart-fill');
    icon.classList.add('ri-heart-line');
    icon.style.color = 'inherit';
  }
}

// Quick view function
function quickView(slug) {
  const modal = new bootstrap.Modal(document.getElementById('quickViewModal'));
  document.getElementById('quickViewContent').innerHTML = `
    <div class="text-center py-5">
      <div class="spinner-minimal mx-auto"></div>
      <p class="mt-3 text-secondary small">Memuat rincian...</p>
    </div>
  `;
  modal.show();
  
  fetch(`/api/products/${slug}`)
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        const product = data.product;
        const imageUrl = product.image ? `/storage/${product.image}` : 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=600&q=80';
        document.getElementById('quickViewContent').innerHTML = `
          <div class="row g-4">
            <div class="col-md-5">
              <img src="${imageUrl}" class="img-fluid border border-light" alt="${product.name}" style="width:100%; height:280px; object-fit:cover; background-color: var(--bg-tertiary);">
            </div>
            <div class="col-md-7 d-flex flex-column justify-content-between">
              <div>
                <div class="mb-2">
                  <span class="badge-premium badge-premium-dark me-1">${product.brand}</span>
                  <span class="badge-premium badge-premium-accent me-1">Grade ${product.grade || 'A'}</span>
                  ${product.cc ? `<span class="badge-premium badge-premium-outline">${product.cc}cc</span>` : ''}
                </div>
                <h3 class="fw-bold mb-2">${product.name}</h3>
                <p class="text-secondary small mb-4">${product.short_description || 'Motor pilihan dengan kualitas terjamin dan surat lengkap.'}</p>
                <div class="mb-4">
                  <span class="text-secondary small d-block">Harga Spesial</span>
                  <span class="fw-bold text-dark h4">Rp ${parseInt(product.price).toLocaleString('id-ID')}</span>
                </div>
              </div>
              <div class="d-flex gap-2">
                <a href="/products/${product.slug}" class="btn btn-primary flex-fill text-center">
                  Lihat Detail Kendaraan
                </a>
              </div>
            </div>
          </div>
        `;
      } else {
        document.getElementById('quickViewContent').innerHTML = `
          <div class="text-center py-4">
            <i class="ri-error-warning-line text-danger" style="font-size: 3rem;"></i>
            <p class="text-secondary mt-2">Gagal memuat detail motor.</p>
          </div>
        `;
      }
    })
    .catch(error => {
      console.error('Error:', error);
      document.getElementById('quickViewContent').innerHTML = `
        <div class="text-center py-4">
          <i class="ri-error-warning-line text-danger" style="font-size: 3rem;"></i>
          <p class="text-secondary mt-2">Terjadi kesalahan koneksi.</p>
        </div>
      `;
    });
}
</script>
@endsection

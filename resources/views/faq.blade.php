@extends('layouts.main')

@section('title', 'Pusat Bantuan - SecondCycle')

@section('content')
<!-- Hero Section -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-12 mb-4 mb-lg-0">
        <h1 class="display-4 fw-bold mb-4">Pusat Bantuan</h1>
        <p class="lead text-muted mb-4">
          Temukan jawaban untuk pertanyaan Anda tentang produk, layanan, dan bantuan teknis SecondCycle. 
          Kami siap membantu 24/7.
        </p>
        <div class="d-flex gap-3 flex-wrap">
          <div class="stat-card">
            <h3 class="fw-bold text-primary">100+</h3>
            <p class="text-muted mb-0">Pertanyaan Umum</p>
          </div>
          <div class="stat-card">
            <h3 class="fw-bold text-primary">24/7</h3>
            <p class="text-muted mb-0">Dukungan Pelanggan</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-12">
        <div class="help-search-container">
          <div class="search-box">
            <i class="fas fa-search search-icon"></i>
            <input type="text" class="form-control form-control-lg search-input" 
                   id="faqSearch" placeholder="Cari pertanyaan Anda...">
          </div>
          <div class="quick-links mt-4">
            <h6 class="fw-bold mb-3">Topik Populer:</h6>
            <div class="d-flex flex-wrap gap-2">
              <button class="btn btn-outline-primary btn-sm quick-link" onclick="searchFAQ('garansi')">
                <i class="fas fa-shield-alt me-1"></i>Garansi
              </button>
              <button class="btn btn-outline-primary btn-sm quick-link" onclick="searchFAQ('pengiriman')">
                <i class="fas fa-truck me-1"></i>Pengiriman
              </button>
              <button class="btn btn-outline-primary btn-sm quick-link" onclick="searchFAQ('pembayaran')">
                <i class="fas fa-credit-card me-1"></i>Pembayaran
              </button>
              <button class="btn btn-outline-primary btn-sm quick-link" onclick="searchFAQ('service')">
                <i class="fas fa-tools me-1"></i>Service
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Help Categories -->
<section class="section-padding">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Kategori Bantuan</h2>
      <p class="text-muted">Pilih kategori yang sesuai dengan kebutuhan Anda</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="help-category-card text-center p-4" onclick="filterByCategory('general')">
          <div class="help-icon mb-3">
            <i class="fas fa-info-circle fa-3x text-primary"></i>
          </div>
          <h5 class="fw-bold mb-2">Umum</h5>
          <p class="text-muted small">Informasi dasar tentang SecondCycle</p>
          <span class="badge bg-primary rounded-pill">15 Pertanyaan</span>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="help-category-card text-center p-4" onclick="filterByCategory('produk')">
          <div class="help-icon mb-3">
            <i class="fas fa-motorcycle fa-3x text-success"></i>
          </div>
          <h5 class="fw-bold mb-2">Produk</h5>
          <p class="text-muted small">Spesifikasi dan fitur motor bekas</p>
          <span class="badge bg-success rounded-pill">25 Pertanyaan</span>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="help-category-card text-center p-4" onclick="filterByCategory('layanan')">
          <div class="help-icon mb-3">
            <i class="fas fa-cogs fa-3x text-warning"></i>
          </div>
          <h5 class="fw-bold mb-2">Layanan</h5>
          <p class="text-muted small">Service, garansi, dan dukungan</p>
          <span class="badge bg-warning rounded-pill">20 Pertanyaan</span>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="help-category-card text-center p-4" onclick="filterByCategory('teknis')">
          <div class="help-icon mb-3">
            <i class="fas fa-wrench fa-3x text-info"></i>
          </div>
          <h5 class="fw-bold mb-2">Teknis</h5>
          <p class="text-muted small">Bantuan teknis dan troubleshooting</p>
          <span class="badge bg-info rounded-pill">18 Pertanyaan</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ Section -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="fw-bold mb-0">Pertanyaan Umum</h2>
          <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary btn-sm" onclick="clearFilters()">
              <i class="fas fa-times me-1"></i>Reset Filter
            </button>
            <select class="form-select form-select-sm" id="categoryFilter" style="width: 150px;">
              <option value="">Semua Kategori</option>
              <option value="general">Umum</option>
              <option value="produk">Produk</option>
              <option value="layanan">Layanan</option>
              <option value="teknis">Teknis</option>
            </select>
          </div>
        </div>

        <div class="accordion" id="faqAccordion">
          @foreach($faqs as $faq)
            <div class="accordion-item faq-item" 
                 data-category="{{ $faq->category ?? 'general' }}" 
                 data-question="{{ strtolower($faq->question) }}"
                 data-answer="{{ strtolower($faq->answer) }}">
              <h2 class="accordion-header" id="heading{{ $faq->id }}">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $faq->id }}"
                        aria-expanded="false"
                        aria-controls="collapse{{ $faq->id }}">
                  <div class="d-flex align-items-center w-100">
                    <i class="fas fa-question-circle text-primary me-3"></i>
                    <span>{{ $faq->question }}</span>
                    <span class="badge bg-secondary ms-auto">
                      {{ ucfirst($faq->category ?? 'General') }}
                    </span>
                  </div>
                </button>
              </h2>
              <div id="collapse{{ $faq->id }}" class="accordion-collapse collapse"
                   aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#faqAccordion">
                <div class="accordion-body">
                  {!! nl2br(e($faq->answer)) !!}
                  <div class="mt-3 pt-3 border-top">
                    <small class="text-muted">
                      <i class="fas fa-thumbs-up me-1"></i>Apakah jawaban ini membantu?
                      <button class="btn btn-sm btn-outline-success ms-2" onclick="markHelpful({{ $faq->id }})">
                        <i class="fas fa-thumbs-up"></i> Ya
                      </button>
                      <button class="btn btn-sm btn-outline-danger ms-1" onclick="markNotHelpful({{ $faq->id }})">
                        <i class="fas fa-thumbs-down"></i> Tidak
                      </button>
                    </small>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        </div>

        <div id="noResults" class="text-center py-5" style="display: none;">
          <div class="alert alert-info">
            <i class="fas fa-search fa-3x mb-3"></i>
            <h5>Tidak Ada Hasil</h5>
            <p class="mb-3">Tidak ada pertanyaan yang sesuai dengan pencarian Anda.</p>
            <button class="btn btn-primary" onclick="clearFilters()">Coba Lagi</button>
          </div>
        </div>
      </div>

      <div class="col-lg-4 col-12">
        <!-- Contact Support -->
        <div class="contact-support-card p-4 mb-4">
          <h5 class="fw-bold mb-3">
            <i class="fas fa-headset text-primary me-2"></i>Butuh Bantuan Langsung?
          </h5>
          <p class="text-muted small mb-4">
            Tim customer service kami siap membantu Anda dengan pertanyaan yang lebih spesifik.
          </p>
          <div class="d-grid gap-2">
            <a href="tel:+6287769002763" class="btn btn-primary">
              <i class="fas fa-phone me-2"></i>Hubungi Kami
            </a>
            <a href="{{ route('contact.show') }}" class="btn btn-outline-primary">
              <i class="fas fa-envelope me-2"></i>Kirim Email
            </a>
            <button class="btn btn-outline-success" onclick="startLiveChat()">
              <i class="fas fa-comments me-2"></i>Live Chat
            </button>
          </div>
        </div>

        <!-- Popular Articles -->
        <div class="popular-articles-card p-4">
          <h5 class="fw-bold mb-3">
            <i class="fas fa-star text-warning me-2"></i>Artikel Populer
          </h5>
          <div class="list-group list-group-flush">
            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
              <small class="d-flex justify-content-between align-items-center">
                <span>Bagaimana cara membeli motor?</span>
                <i class="fas fa-chevron-right text-muted"></i>
              </small>
            </a>
            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
              <small class="d-flex justify-content-between align-items-center">
                <span>Garansi apa saja yang didapat?</span>
                <i class="fas fa-chevron-right text-muted"></i>
              </small>
            </a>
            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
              <small class="d-flex justify-content-between align-items-center">
                <span>Proses pengiriman motor</span>
                <i class="fas fa-chevron-right text-muted"></i>
              </small>
            </a>
            <a href="#" class="list-group-item list-group-item-action border-0 px-0">
              <small class="d-flex justify-content-between align-items-center">
                <span>Cara melakukan service</span>
                <i class="fas fa-chevron-right text-muted"></i>
              </small>
            </a>
          </div>
        </div>

        <!-- Help Stats -->
        <div class="help-stats-card p-4 mt-4">
          <h5 class="fw-bold mb-3">
            <i class="fas fa-chart-line text-info me-2"></i>Statistik Bantuan
          </h5>
          <div class="row text-center">
            <div class="col-6">
              <h4 class="fw-bold text-primary">95%</h4>
              <small class="text-muted">Kepuasan Pelanggan</small>
            </div>
            <div class="col-6">
              <h4 class="fw-bold text-success">2 Jam</h4>
              <small class="text-muted">Rata-rata Response</small>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="section-padding">
  <div class="container">
    <div class="cta-section text-center p-5 rounded">
      <h3 class="fw-bold mb-3">Masih Butuh Bantuan?</h3>
      <p class="text-muted mb-4">Jika Anda tidak menemukan jawaban yang dicari, tim kami siap membantu</p>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="{{ route('contact.show') }}" class="btn btn-primary btn-lg">
          <i class="fas fa-envelope me-2"></i>Hubungi Tim Support
        </a>
        <button class="btn btn-outline-primary btn-lg" onclick="startLiveChat()">
          <i class="fas fa-comments me-2"></i>Mulai Live Chat
        </button>
      </div>
    </div>
  </div>
</section>
@endsection

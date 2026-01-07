@extends('layouts.main')

@section('title', 'Kontak Kami - SecondCycle')

@section('content')
<!-- Hero Section -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-12 mb-4 mb-lg-0">
        <h1 class="display-4 fw-bold mb-4">Kontak Kami</h1>
        <p class="lead text-muted mb-4">
          Hubungi tim SecondCycle untuk pertanyaan, bantuan, atau informasi lebih lanjut. 
          Kami siap membantu Anda menemukan motor bekas berkualitas dengan layanan terbaik.
        </p>
        <div class="d-flex gap-3 flex-wrap">
          <div class="stat-card">
            <h3 class="fw-bold text-primary">24/7</h3>
            <p class="text-muted mb-0">Dukungan Pelanggan</p>
          </div>
          <div class="stat-card">
            <h3 class="fw-bold text-primary">< 1 Jam</h3>
            <p class="text-muted mb-0">Response Time</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-12">
        <div class="contact-hero-image">
          <img src="{{ asset('images/dilerdanworkshop.png') }}" class="img-fluid rounded shadow-lg" alt="Kontak SecondCycle">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Quick Contact Methods -->
<section class="section-padding">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Hubungi Kami</h2>
      <p class="text-muted">Pilih metode kontak yang paling nyaman untuk Anda</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="contact-method-card text-center p-4" onclick="callPhone()">
          <div class="contact-icon mb-3">
            <i class="fas fa-phone fa-3x text-primary"></i>
          </div>
          <h5 class="fw-bold mb-2">Telepon</h5>
          <p class="text-muted small">Hubungi kami langsung untuk bantuan segera</p>
          <a href="tel:+6287769002763" class="btn btn-outline-primary btn-sm">+62 877-6900-2763</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="contact-method-card text-center p-4" onclick="openWhatsApp()">
          <div class="contact-icon mb-3">
            <i class="fab fa-whatsapp fa-3x text-success"></i>
          </div>
          <h5 class="fw-bold mb-2">WhatsApp</h5>
          <p class="text-muted small">Chat cepat untuk pertanyaan umum</p>
          <a href="https://wa.me/6287769002763" target="_blank" class="btn btn-outline-success btn-sm">Chat Sekarang</a>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="contact-method-card text-center p-4" onclick="startLiveChat()">
          <div class="contact-icon mb-3">
            <i class="fas fa-comments fa-3x text-warning"></i>
          </div>
          <h5 class="fw-bold mb-2">Live Chat</h5>
          <p class="text-muted small">Dukungan real-time dengan tim kami</p>
          <button class="btn btn-outline-warning btn-sm">Mulai Chat</button>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="contact-method-card text-center p-4" onclick="scrollToForm()">
          <div class="contact-icon mb-3">
            <i class="fas fa-envelope fa-3x text-info"></i>
          </div>
          <h5 class="fw-bold mb-2">Email</h5>
          <p class="text-muted small">Kirim pesan detail untuk pertanyaan kompleks</p>
          <button class="btn btn-outline-info btn-sm">Kirim Email</button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Form & Map Section -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 col-12">
        <div class="contact-form-container">
          <h3 class="fw-bold mb-4">Kirim Pesan</h3>
          
          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle me-2"></i>
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            
            @if(session('whatsapp_url'))
            <div class="alert alert-info alert-dismissible fade show" role="alert" id="whatsappAlert">
              <i class="fab fa-whatsapp me-2"></i>
              <strong>Auto-redirect ke WhatsApp dalam <span id="countdown">5</span> detik...</strong>
              <p class="mb-2 mt-2">Kirim pesan ke WhatsApp untuk respons lebih cepat!</p>
              <div class="mt-3">
                <a href="{{ session('whatsapp_url') }}" target="_blank" class="btn btn-success btn-sm me-2" id="whatsappBtn">
                  <i class="fab fa-whatsapp me-1"></i>Buka WhatsApp Sekarang
                </a>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="cancelRedirect">
                  <i class="fas fa-times me-1"></i>Batalkan Auto-redirect
                </button>
              </div>
              <small class="text-muted d-block mt-2">atau tunggu tim kami menghubungi Anda via email</small>
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const whatsappAlert = document.getElementById('whatsappAlert');
                const countdown = document.getElementById('countdown');
                const whatsappBtn = document.getElementById('whatsappBtn');
                const cancelBtn = document.getElementById('cancelRedirect');
                const whatsappUrl = "{{ session('whatsapp_url') }}";
                
                let timeLeft = 5;
                let redirectTimer;
                
                function updateCountdown() {
                    countdown.textContent = timeLeft;
                    
                    if (timeLeft <= 0) {
                        clearInterval(redirectTimer);
                        window.open(whatsappUrl, '_blank');
                        
                        // Update alert after redirect
                        if (whatsappAlert) {
                            whatsappAlert.innerHTML = `
                                <i class="fab fa-whatsapp me-2"></i>
                                <strong>WhatsApp telah dibuka!</strong>
                                <p class="mb-0 mt-2">Pesan Anda siap dikirim. Terima kasih telah menghubungi kami!</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;
                        }
                    } else {
                        timeLeft--;
                    }
                }
                
                // Start countdown
                redirectTimer = setInterval(updateCountdown, 1000);
                
                // Cancel redirect if user clicks cancel
                cancelBtn.addEventListener('click', function() {
                    clearInterval(redirectTimer);
                    if (whatsappAlert) {
                        whatsappAlert.innerHTML = `
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Auto-redirect dibatalkan</strong>
                            <p class="mb-2 mt-2">Anda dapat menghubungi kami kapan saja melalui form kontak atau WhatsApp.</p>
                            <a href="${whatsappUrl}" target="_blank" class="btn btn-success btn-sm me-2">
                                <i class="fab fa-whatsapp me-1"></i>Buka WhatsApp
                            </a>
                            <small class="text-muted">atau tunggu tim kami menghubungi Anda via email</small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        `;
                    }
                });
                
                // Stop countdown if user clicks WhatsApp button early
                whatsappBtn.addEventListener('click', function() {
                    clearInterval(redirectTimer);
                });
                
                // Stop countdown if alert is closed
                whatsappAlert.addEventListener('close.bs.alert', function () {
                    clearInterval(redirectTimer);
                });
            });
            </script>
            @endif
          @endif

          <form class="contact-form" method="POST" action="{{ route('contact.store') }}" id="contactForm">
            @csrf

            <div class="row">
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                         placeholder="Nama Lengkap" value="{{ old('name') }}" required>
                  <label for="name">Nama Lengkap *</label>
                  @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                         placeholder="Email" value="{{ old('email') }}" required>
                  <label for="email">Email *</label>
                  @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                         placeholder="Nomor Telepon" value="{{ old('phone') }}">
                  <label for="phone">Nomor Telepon</label>
                  @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-floating mb-3">
                  <select name="department" id="department" class="form-select @error('department') is-invalid @enderror">
                    <option value="">Pilih Departemen</option>
                    <option value="sales" {{ old('department') == 'sales' ? 'selected' : '' }}>Sales</option>
                    <option value="service" {{ old('department') == 'service' ? 'selected' : '' }}>Service</option>
                    <option value="support" {{ old('department') == 'support' ? 'selected' : '' }}>Customer Support</option>
                    <option value="finance" {{ old('department') == 'finance' ? 'selected' : '' }}>Finance</option>
                  </select>
                  <label for="department">Departemen</label>
                  @error('department')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>
              </div>
            </div>

            <div class="form-floating mb-3">
              <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror"
                     placeholder="Subjek" value="{{ old('subject') }}" required>
              <label for="subject">Subjek *</label>
              @error('subject')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-floating mb-3">
              <textarea name="message" id="message"
                        class="form-control @error('message') is-invalid @enderror"
                        placeholder="Pesan Anda" style="height: 150px" required>{{ old('message') }}</textarea>
              <label for="message">Pesan Anda *</label>
              @error('message')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-check mb-3">
              <input type="checkbox" class="form-check-input" id="newsletter" name="newsletter" value="1">
              <label class="form-check-label" for="newsletter">
                Saya ingin menerima newsletter dan penawaran spesial dari SecondCycle
              </label>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-primary btn-lg px-4">
                <i class="fas fa-paper-plane me-2"></i>Kirim Pesan
              </button>
              <button type="button" class="btn btn-outline-secondary btn-lg px-4" onclick="resetForm()">
                <i class="fas fa-redo me-2"></i>Reset
              </button>
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-6 col-12">
        <!-- Office Information -->
        <div class="office-info-card p-4 mb-4">
          <h4 class="fw-bold mb-3">
            <i class="fas fa-map-marker-alt text-primary me-2"></i>Kantor Pusat
          </h4>
          <div class="office-details">
            <p class="mb-2">
              <strong>SecondCycle Indonesia</strong><br>
              Jl. Sudirman No. 123, Jakarta Pusat<br>
              DKI Jakarta 10110
            </p>
            <p class="mb-2">
              <i class="fas fa-phone text-primary me-2"></i>
              <strong>Telepon:</strong> +62 877-6900-2763
            </p>
            <p class="mb-2">
              <i class="fas fa-envelope text-primary me-2"></i>
              <strong>Email:</strong> info@secondcycle.id
            </p>
            <p class="mb-0">
              <i class="fas fa-globe text-primary me-2"></i>
              <strong>Website:</strong> www.secondcycle.id
            </p>
          </div>
        </div>

        <!-- Office Hours -->
        <div class="office-hours-card p-4 mb-4">
          <h4 class="fw-bold mb-3">
            <i class="fas fa-clock text-success me-2"></i>Jam Operasional
          </h4>
          <div class="hours-details">
            <div class="d-flex justify-content-between mb-2">
              <span>Senin - Jumat</span>
              <strong>08:00 - 18:00</strong>
            </div>
            <div class="d-flex justify-content-between mb-2">
              <span>Sabtu</span>
              <strong>09:00 - 15:00</strong>
            </div>
            <div class="d-flex justify-content-between mb-0">
              <span>Minggu & Hari Libur</span>
              <strong class="text-danger">Tutup</strong>
            </div>
          </div>
          <div class="alert alert-info mt-3 mb-0">
            <small><i class="fas fa-info-circle me-1"></i>Customer support tersedia 24/7 untuk keadaan darurat</small>
          </div>
        </div>

        <!-- Social Media -->
        <div class="social-media-card p-4 mb-4">
          <h4 class="fw-bold mb-3">
            <i class="fas fa-share-alt text-warning me-2"></i>Ikuti Kami
          </h4>
          <div class="d-flex gap-3">
            <a href="#" class="social-link">
              <i class="fab fa-facebook fa-2x text-primary"></i>
            </a>
            <a href="#" class="social-link">
              <i class="fab fa-instagram fa-2x text-danger"></i>
            </a>
            <a href="#" class="social-link">
              <i class="fab fa-twitter fa-2x text-info"></i>
            </a>
            <a href="#" class="social-link">
              <i class="fab fa-youtube fa-2x text-danger"></i>
            </a>
            <a href="#" class="social-link">
              <i class="fab fa-linkedin fa-2x text-primary"></i>
            </a>
          </div>
        </div>

        <!-- Interactive Map -->
        <div class="map-container">
          <div id="contactMap" style="height: 300px; border-radius: 8px; overflow: hidden;"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Department Contact Cards -->
<section class="section-padding">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Hubungi Departemen Terkait</h2>
      <p class="text-muted">Dapatkan bantuan spesifik sesuai kebutuhan Anda</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="department-card text-center p-4">
          <div class="dept-icon mb-3">
            <i class="fas fa-shopping-cart fa-3x text-primary"></i>
          </div>
          <h5 class="fw-bold mb-2">Sales</h5>
          <p class="text-muted small mb-3">Informasi produk dan pembelian motor</p>
          <div class="dept-contact">
            <small class="d-block mb-1">
              <i class="fas fa-phone me-1"></i> +62 877-6900-2763
            </small>
            <small class="d-block">
              <i class="fas fa-envelope me-1"></i> sales@secondcycle.id
            </small>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="department-card text-center p-4">
          <div class="dept-icon mb-3">
            <i class="fas fa-tools fa-3x text-success"></i>
          </div>
          <h5 class="fw-bold mb-2">Service</h5>
          <p class="text-muted small mb-3">Booking service dan pertanyaan teknis</p>
          <div class="dept-contact">
            <small class="d-block mb-1">
              <i class="fas fa-phone me-1"></i> +62 877-6900-2764
            </small>
            <small class="d-block">
              <i class="fas fa-envelope me-1"></i> service@secondcycle.id
            </small>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="department-card text-center p-4">
          <div class="dept-icon mb-3">
            <i class="fas fa-headset fa-3x text-warning"></i>
          </div>
          <h5 class="fw-bold mb-2">Customer Support</h5>
          <p class="text-muted small mb-3">Bantuan pelanggan dan keluhan</p>
          <div class="dept-contact">
            <small class="d-block mb-1">
              <i class="fas fa-phone me-1"></i> +62 877-6900-2765
            </small>
            <small class="d-block">
              <i class="fas fa-envelope me-1"></i> support@secondcycle.id
            </small>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="department-card text-center p-4">
          <div class="dept-icon mb-3">
            <i class="fas fa-credit-card fa-3x text-info"></i>
          </div>
          <h5 class="fw-bold mb-2">Finance</h5>
          <p class="text-muted small mb-3">Pembiayaan dan administrasi</p>
          <div class="dept-contact">
            <small class="d-block mb-1">
              <i class="fas fa-phone me-1"></i> +62 877-6900-2766
            </small>
            <small class="d-block">
              <i class="fas fa-envelope me-1"></i> finance@secondcycle.id
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="cta-section text-center p-5 rounded">
      <h3 class="fw-bold mb-3">Siap Membantu Anda</h3>
      <p class="text-muted mb-4">Tim profesional SecondCycle siap memberikan solusi terbaik untuk kebutuhan motor bekas Anda</p>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="tel:+6287769002763" class="btn btn-primary btn-lg">
          <i class="fas fa-phone me-2"></i>Hubungi Sekarang
        </a>
        <a href="{{ route('workshops') }}" class="btn btn-outline-primary btn-lg">
          <i class="fas fa-map-marker-alt me-2"></i>Kunjungi Dealer
        </a>
      </div>
    </div>
  </div>
</section>
@endsection

@extends('layouts.main')

@section('title', 'Kisah Kami - SecondCycle')

@section('content')
<!-- Hero Section -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-12 mb-4 mb-lg-0">
        <h1 class="display-4 fw-bold mb-4">Kisah Kami</h1>
        <p class="lead text-muted mb-4">
          SecondCycle hadir sebagai solusi terpercaya untuk kamu yang ingin memiliki motor bekas berkualitas 
          dengan proses inspeksi ketat dan transparan. Kami memahami bahwa motor bukan hanya alat transportasi, 
          tapi bagian dari gaya hidup dan impian setiap pengendara.
        </p>
        <div class="d-flex gap-3 flex-wrap">
          <div class="stat-card">
            <h3 class="fw-bold text-primary">2,500+</h3>
            <p class="text-muted mb-0">Motor Terjual</p>
          </div>
          <div class="stat-card">
            <h3 class="fw-bold text-primary">98%</h3>
            <p class="text-muted mb-0">Kepuasan Pelanggan</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-12">
        <img src="{{ asset('images/about.png') }}" class="img-fluid rounded shadow-lg" alt="Tentang SecondCycle">
      </div>
    </div>
  </div>
</section>

<!-- Story Timeline -->
<section class="section-padding">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Perjalanan Kami</h2>
      <p class="text-muted">Dari ide hingga menjadi marketplace motor bekas terpercaya di Indonesia</p>
    </div>
    
    <div class="row">
      <div class="col-12">
        <div class="timeline">
          <div class="timeline-item">
            <div class="timeline-dot bg-primary"></div>
            <div class="timeline-content">
              <h5>2020 - Awal Mula</h5>
              <p class="text-muted">Berawal dari pengalaman pribadi sulitnya menemukan motor bekas berkualitas dengan harga transparan.</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-dot bg-success"></div>
            <div class="timeline-content">
              <h5>2021 - Platform Digital</h5>
              <p class="text-muted">Meluncurkan platform online dengan sistem inspeksi 50 titik untuk setiap unit.</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-dot bg-warning"></div>
            <div class="timeline-content">
              <h5>2022 - Ekspansi Layanan</h5>
              <p class="text-muted">Menambah layanan pengiriman nationwide dan garansi 30 hari untuk setiap pembelian.</p>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-dot bg-info"></div>
            <div class="timeline-content">
              <h5>2023 - Leadership Market</h5>
              <p class="text-muted">Menjadi marketplace motor bekas pilihan utama dengan 2,500+ unit terjual dan rating 4.8/5.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Why Choose Us -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Mengapa Memilih SecondCycle?</h2>
      <p class="text-muted">Kami berbeda karena kami peduli dengan kepercayaan Anda</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="feature-card text-center p-4">
          <div class="feature-icon mb-3">
            <i class="fas fa-shield-alt fa-3x text-primary"></i>
          </div>
          <h5 class="fw-bold mb-2">Inspeksi 50 Titik</h5>
          <p class="text-muted small">Setiap motor melalui pemeriksaan menyeluruh oleh mekanik bersertifikat</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="feature-card text-center p-4">
          <div class="feature-icon mb-3">
            <i class="fas fa-certificate fa-3x text-success"></i>
          </div>
          <h5 class="fw-bold mb-2">Garansi 30 Hari</h5>
          <p class="text-muted small">Perlindungan penuh untuk setiap pembelian motor di platform kami</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="feature-card text-center p-4">
          <div class="feature-icon mb-3">
            <i class="fas fa-handshake fa-3x text-warning"></i>
          </div>
          <h5 class="fw-bold mb-2">Harga Transparan</h5>
          <p class="text-muted small">Tidak ada biaya tersembunyi, semua harga sudah termasuk administrasi</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="feature-card text-center p-4">
          <div class="feature-icon mb-3">
            <i class="fas fa-truck fa-3x text-info"></i>
          </div>
          <h5 class="fw-bold mb-2">Gratis Pengiriman</h5>
          <p class="text-muted small">Pengiriman gratis ke seluruh Indonesia untuk pembelian tertentu</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Vision & Mission -->
<section class="section-padding">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-12 mb-4 mb-lg-0">
        <h3 class="fw-bold mb-4">Visi & Misi Kami</h3>
        
        <div class="vision-mission-card p-4 mb-4">
          <h5 class="fw-bold text-primary mb-3">
            <i class="fas fa-eye me-2"></i>Visi
          </h5>
          <p>Menjadi marketplace motor bekas terpercaya nomor 1 di Indonesia yang menyediakan kendaraan berkualitas dengan layanan transparan dan customer-centric.</p>
        </div>
        
        <div class="vision-mission-card p-4">
          <h5 class="fw-bold text-success mb-3">
            <i class="fas fa-bullseye me-2"></i>Misi
          </h5>
          <ul class="list-unstyled">
            <li class="mb-2">
              <i class="fas fa-check-circle text-success me-2"></i>
              <strong>Quality First:</strong> Seleksi unit dengan inspeksi 50 titik oleh mekanik bersertifikat
            </li>
            <li class="mb-2">
              <i class="fas fa-check-circle text-success me-2"></i>
              <strong>Transparency:</strong> Memberikan informasi lengkap dan jujur tentang kondisi setiap unit
            </li>
            <li class="mb-2">
              <i class="fas fa-check-circle text-success me-2"></i>
              <strong>Customer Success:</strong> Membantu pelanggan menemukan motor impian yang sesuai kebutuhan
            </li>
            <li class="mb-2">
              <i class="fas fa-check-circle text-success me-2"></i>
              <strong>Innovation:</strong> Terus mengembangkan teknologi untuk pengalaman belanja motor yang lebih baik
            </li>
          </ul>
        </div>
      </div>
      
      <div class="col-lg-6 col-12">
        <div class="inspection-process">
          <h4 class="fw-bold mb-4">Proses Inspeksi Kami</h4>
          <div class="process-steps">
            <div class="step-item">
              <div class="step-number">1</div>
              <div class="step-content">
                <h6>Dokumentasi</h6>
                <p class="text-muted small">Verifikasi kelengkapan dokumen dan legalitas unit</p>
              </div>
            </div>
            <div class="step-item">
              <div class="step-number">2</div>
              <div class="step-content">
                <h6>Fisik & Mesin</h6>
                <p class="text-muted small">Pemeriksaan menyeluruh kondisi fisik dan performa mesin</p>
              </div>
            </div>
            <div class="step-item">
              <div class="step-number">3</div>
              <div class="step-content">
                <h6>Test Drive</h6>
                <p class="text-muted small">Uji coba performa di berbagai kondisi jalan</p>
              </div>
            </div>
            <div class="step-item">
              <div class="step-number">4</div>
              <div class="step-content">
                <h6>Final Check</h6>
                <p class="text-muted small">Pemeriksaan akhir sebelum unit siap dijual</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Team Section -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Tim Profesional Kami</h2>
      <p class="text-muted">Dedikasi dan expertise untuk layanan terbaik</p>
    </div>
    
    <div class="row g-4 justify-content-center">
      <div class="col-lg-2 col-md-4 col-6">
        <div class="team-card text-center">
          <div class="team-avatar mb-3">
            <img src="{{ asset('images/people/Dandy.png') }}" class="img-fluid rounded-circle" alt="Dandy" style="width: 100px; height: 100px; object-fit: cover; object-position: top;">
          </div>
          <h6 class="fw-bold">Dandy</h6>
          <p class="text-muted small mb-2">CEO & Founder</p>
          <p class="small">15+ tahun pengalaman</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6">
        <div class="team-card text-center">
          <div class="team-avatar mb-3">
            <img src="{{ asset('images/people/naftali.png') }}" class="img-fluid rounded-circle" alt="Naftali" style="width: 100px; height: 100px; object-fit: cover; object-position: top;">
          </div>
          <h6 class="fw-bold">Naftali</h6>
          <p class="text-muted small mb-2">Head of Inspection</p>
          <p class="small">Mekanik bersertifikat</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6">
        <div class="team-card text-center">
          <div class="team-avatar mb-3">
            <img src="{{ asset('images/people/lauren.jpg') }}" class="img-fluid rounded-circle" alt="Lauren" style="width: 100px; height: 100px; object-fit: cover; object-position: top;">
          </div>
          <h6 class="fw-bold">Lauren</h6>
          <p class="text-muted small mb-2">Customer Service Lead</p>
          <p class="small">Dedikasi 24/7</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6">
        <div class="team-card text-center">
          <div class="team-avatar mb-3">
            <img src="{{ asset('images/people/nindy.png') }}" class="img-fluid rounded-circle" alt="Nindy" style="width: 100px; height: 100px; object-fit: cover; object-position: top;">
          </div>
          <h6 class="fw-bold">Nindy</h6>
          <p class="text-muted small mb-2">Business Development</p>
          <p class="small">Jaringan nasional</p>
        </div>
      </div>
      <div class="col-lg-2 col-md-4 col-6">
        <div class="team-card text-center">
          <div class="team-avatar mb-3">
            <img src="{{ asset('images/people/aul.png') }}" class="img-fluid rounded-circle" alt="Aul" style="width: 100px; height: 100px; object-fit: cover; object-position: top;">
          </div>
          <h6 class="fw-bold">Aul</h6>
          <p class="text-muted small mb-2">Marketing Specialist</p>
          <p class="small">Digital branding</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="section-padding">
  <div class="container">
    <div class="cta-section text-center p-5 rounded">
      <h3 class="fw-bold mb-3">Siap Menemukan Motor Impian Anda?</h3>
      <p class="text-muted mb-4">Bergabung dengan ribuan pelanggan yang telah mempercayai kami</p>
      <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
        <i class="fas fa-search me-2"></i>Jelajahi Koleksi Motor
      </a>
    </div>
  </div>
</section>
@endsection

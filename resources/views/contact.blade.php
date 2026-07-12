@extends('layouts.main')

@section('title', 'Kontak Kami - SecondCycle')

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-white border-bottom border-light" style="margin-top: 120px;">
  <div class="container py-lg-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="badge-premium badge-premium-dark mb-2">Hubungi</span>
        <h1 class="display-5 fw-bold mb-4">Kami Siap Membantu Anda</h1>
        <p class="text-secondary mb-4 fs-5" style="line-height: 1.7;">
          Ada pertanyaan tentang unit, kelengkapan berkas, opsi kredit, atau kerjasama diler? Jangan ragu hubungi tim customer service kami yang bersahabat.
        </p>
      </div>
      <div class="col-lg-6">
        <div class="p-3 bg-light border border-light">
          <img src="{{ asset('images/dilerdanworkshop.png') }}" class="img-fluid w-100" alt="Kontak SecondCycle" style="height: 240px; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1423666639041-f56000c27a9a?auto=format&fit=crop&w=800&q=80'">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Info Cards -->
<section class="py-5 bg-white border-bottom border-light">
  <div class="container py-lg-3">
    <div class="row g-4 text-center">
      <div class="col-md-4">
        <div class="p-4 border border-light h-100">
          <i class="ri-phone-line fs-2 mb-3 d-block text-dark"></i>
          <h5 class="fw-bold mb-2">Telepon Langsung</h5>
          <p class="text-secondary small mb-3">Dapatkan respon tercepat untuk pertanyaan darurat.</p>
          <a href="tel:+6287769002763" class="btn btn-outline-dark btn-sm">+62 877-6900-2763</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border border-light h-100">
          <i class="ri-whatsapp-line fs-2 mb-3 d-block text-dark"></i>
          <h5 class="fw-bold mb-2">Whatsapp Chat</h5>
          <p class="text-secondary small mb-3">Hubungi tim penjualan kami secara kasual.</p>
          <a href="https://wa.me/6287769002763" target="_blank" class="btn btn-primary btn-sm">Kirim Chat</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border border-light h-100">
          <i class="ri-mail-line fs-2 mb-3 d-block text-dark"></i>
          <h5 class="fw-bold mb-2">Surat Elektronik</h5>
          <p class="text-secondary small mb-3">Kirim penawaran bisnis atau komplain resmi.</p>
          <a href="mailto:support@secondcycle.id" class="btn btn-outline-dark btn-sm">support@secondcycle.id</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact Form -->
<section class="py-5 bg-white">
  <div class="container py-lg-4">
    <div class="row g-5">
      <div class="col-lg-6">
        <h3 class="fw-bold mb-4">Kirim Pesan Langsung</h3>
        
        @if(session('success'))
          <div class="alert alert-success border-0 mb-4 p-3 d-flex align-items-center" style="border-radius: 0; background-color: var(--bg-tertiary);">
            <i class="ri-checkbox-circle-fill text-success fs-4 me-2"></i>
            <span class="small fw-semibold text-dark">{{ session('success') }}</span>
          </div>
        @endif

        <form action="{{ route('contact.store') }}" method="POST">
          @csrf
          <div class="row g-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label small text-secondary fw-semibold">Nama Lengkap</label>
                <input type="text" class="form-control" name="name" required placeholder="Nama Anda">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label small text-secondary fw-semibold">Email Anda</label>
                <input type="email" class="form-control" name="email" required placeholder="email@domain.com">
              </div>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label small text-secondary fw-semibold">Nomor Telepon</label>
                <input type="tel" class="form-control" name="phone" placeholder="08xxxxxxxx">
              </div>
            </div>
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label small text-secondary fw-semibold">Subjek</label>
                <input type="text" class="form-control" name="subject" required placeholder="Pertanyaan Layanan/Kemitraan">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label small text-secondary fw-semibold">Detail Pesan</label>
            <textarea class="form-control" name="message" rows="4" required placeholder="Tuliskan pesan Anda di sini..."></textarea>
          </div>
          <button type="submit" class="btn btn-primary px-4 py-3">Kirim Pesan</button>
        </form>
      </div>

      <div class="col-lg-6">
        <h3 class="fw-bold mb-4">Kantor Pusat Kami</h3>
        <p class="text-secondary small mb-4">
          Jl. Raya Otomotif No. 45, Kebayoran Baru, Jakarta Selatan, DKI Jakarta 12130.<br>
          Operasional: Senin - Minggu (08.00 - 18.00 WIB)
        </p>
        
        <div class="border border-light p-2 bg-light">
          <div id="contactMap" style="height: 300px;"></div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mini Map initialization for Headquarters
    const map = L.map('contactMap').setView([-6.2443, 106.8006], 14); // Southern Jakarta center
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    L.marker([-6.2443, 106.8006])
        .addTo(map)
        .bindPopup('<b>SecondCycle HQ</b><br>Jl. Raya Otomotif No. 45, Jaksel')
        .openPopup();
});
</script>
@endsection

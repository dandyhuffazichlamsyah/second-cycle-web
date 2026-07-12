@extends('layouts.main')

@section('title', 'Kisah Kami - SecondCycle')

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-white border-bottom border-light" style="margin-top: 120px;">
  <div class="container py-lg-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="badge-premium badge-premium-dark mb-2">Tentang</span>
        <h1 class="display-5 fw-bold mb-4">Kisah Perjalanan Kami</h1>
        <p class="text-secondary mb-4 fs-5" style="line-height: 1.7;">
          SecondCycle hadir sebagai pionir dalam menghadirkan keterbukaan informasi pada pasar motor bekas. Kami berdedikasi penuh untuk menghapus ketidakpastian kondisi dan dokumen, sehingga Anda bisa membeli unit dengan kepercayaan diri penuh.
        </p>
        
        <div class="d-flex gap-4 pt-3">
          <div>
            <h3 class="fw-bold mb-0 text-dark">2.500+</h3>
            <small class="text-secondary uppercase tracking-wider" style="font-size: 0.7rem; font-weight: 700;">Motor Terjual</small>
          </div>
          <div class="border-start border-light ps-4">
            <h3 class="fw-bold mb-0 text-dark">98%</h3>
            <small class="text-secondary uppercase tracking-wider" style="font-size: 0.7rem; font-weight: 700;">Pelanggan Puas</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="p-3 bg-light border border-light">
          <img src="{{ asset('images/about.png') }}" class="img-fluid w-100" alt="Tentang SecondCycle" style="height: 320px; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1558981806-ec527fa84c39?auto=format&fit=crop&w=800&q=80'">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Timeline (Minimal Design) -->
<section class="py-5 bg-white border-bottom border-light">
  <div class="container py-lg-4">
    <div class="text-center mb-5">
      <span class="badge-premium badge-premium-accent mb-2">Milestone</span>
      <h2 class="fw-bold">Perjalanan Sejarah Kami</h2>
      <p class="text-secondary">Langkah demi langkah dalam membangun platform terpercaya.</p>
    </div>
    
    <div class="row g-4 justify-content-center">
      <div class="col-md-3">
        <div class="p-4 border border-light h-100">
          <div class="fw-bold text-dark mb-2">2020</div>
          <h5 class="fw-bold mb-2">Awal Gagasan</h5>
          <p class="text-secondary small mb-0">Didirikan atas dasar kegelisahan sulitnya mencari motor bekas dengan kondisi mesin yang jujur.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 border border-light h-100">
          <div class="fw-bold text-dark mb-2">2021</div>
          <h5 class="fw-bold mb-2">Platform Digital</h5>
          <p class="text-secondary small mb-0">Meluncurkan katalog online pertama dengan verifikasi fisik 50 titik inspeksi terpadu.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 border border-light h-100">
          <div class="fw-bold text-dark mb-2">2022</div>
          <h5 class="fw-bold mb-2">Garansi Penuh</h5>
          <p class="text-secondary small mb-0">Memulai inisiatif garansi mesin 30 hari pertama di Indonesia untuk semua tipe motor bekas.</p>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 border border-light h-100">
          <div class="fw-bold text-dark mb-2">2023</div>
          <h5 class="fw-bold mb-2">Ekspansi Regional</h5>
          <p class="text-secondary small mb-0">Membuka 5 pusat diler baru dan bekerjasama dengan puluhan bengkel service center mitra.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Values Section -->
<section class="py-5 bg-white">
  <div class="container py-lg-4">
    <div class="text-center mb-5">
      <span class="badge-premium badge-premium-dark mb-2">Nilai Utama</span>
      <h2 class="fw-bold">Prinsip Kerja SecondCycle</h2>
      <p class="text-secondary">Kami menempatkan kepuasan dan keselamatan Anda di atas segalanya.</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-4">
        <div class="p-4 border border-light h-100">
          <i class="ri-shield-line fs-2 mb-3 d-block text-dark"></i>
          <h5 class="fw-bold mb-2">Transparansi Mutlak</h5>
          <p class="text-secondary small mb-0">Kami membuka seluruh hasil penilaian inspeksi motor apa adanya, baik lecet bodi maupun kondisi kaki-kaki.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border border-light h-100">
          <i class="ri-heart-line fs-2 mb-3 d-block text-dark"></i>
          <h5 class="fw-bold mb-2">Keluargaan</h5>
          <p class="text-secondary small mb-0">Layanan purna jual kami siap membantu kapan pun Anda menemui kendala pada motor pasca pembelian.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="p-4 border border-light h-100">
          <i class="ri-star-line fs-2 mb-3 d-block text-dark"></i>
          <h5 class="fw-bold mb-2">Integritas Legal</h5>
          <p class="text-secondary small mb-0">Seluruh dokumen (STNK & BPKB) melewati pemeriksaan kepolisian resmi sebelum dilepas ke pembeli.</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

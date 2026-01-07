@php
  use Illuminate\Support\Str;
@endphp
@extends('layouts.main')

@section('title', 'Diler & WorkShop Kami - SecondCycle')

@section('content')
<!-- Hero Section -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6 col-12 mb-4 mb-lg-0">
        <h1 class="display-4 fw-bold mb-4">Diler & WorkShop Kami</h1>
        <p class="lead text-muted mb-4">
          Jaringan dealer dan workshop resmi SecondCycle tersebar di seluruh Indonesia. 
          Layanan terpercaya dengan teknisi bersertifikat dan suku cadang original.
        </p>
        <div class="d-flex gap-3 flex-wrap">
          <div class="stat-card">
            <h3 class="fw-bold text-primary">{{ $locations->whereIn('type', ['Dealer', 'Dealer & Service', 'Dealer & Service Center'])->count() }}+</h3>
            <p class="text-muted mb-0">Lokasi Dealer</p>
          </div>
          <div class="stat-card">
            <h3 class="fw-bold text-primary">{{ $locations->whereIn('type', ['Service', 'Workshop', 'Dealer & Service', 'Dealer & Service Center'])->count() }}+</h3>
            <p class="text-muted mb-0">Workshop Resmi</p>
          </div>
        </div>
      </div>
      <div class="col-lg-6 col-12">
        <img src="{{ asset('images/dilerdanworkshop.png') }}" class="img-fluid rounded shadow-lg" alt="Diler & Workshop SecondCycle">
      </div>
    </div>
  </div>
</section>

<!-- Filter Section -->
<section class="section-padding">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Temukan Lokasi Terdekat</h2>
      <p class="text-muted">Filter berdasarkan kota dan jenis layanan</p>
    </div>
    
    <div class="row justify-content-center mb-5">
      <div class="col-lg-8">
        <div class="filter-container">
          <div class="row">
          <div class="col-md-6 col-12">
            <select class="form-select form-select-lg" id="cityFilter">
              <option value="">Semua Kota</option>
              @foreach($locations->pluck('city')->unique()->sort() as $city)
                <option value="{{ Str::slug($city) }}">{{ $city }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6 col-12">
            <select class="form-select form-select-lg" id="typeFilter">
              <option value="">Semua Jenis</option>
              @foreach($locations->pluck('type')->unique()->sort() as $type)
                <option value="{{ Str::slug($type) }}">{{ $type }}</option>
              @endforeach
            </select>
          </div>
        </div>
        
        <div class="row mt-4">
          <div class="col-12 text-center">
            <button class="btn btn-primary btn-lg px-5" onclick="scrollToLocations()">
              <i class="fas fa-search me-2"></i>Cari Lokasi
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Service Features -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Layanan Unggulan Kami</h2>
      <p class="text-muted">Keuntungan menggunakan jasa dealer & workshop resmi SecondCycle</p>
    </div>
    
    <div class="row g-4">
      <div class="col-md-6 col-lg-3">
        <div class="service-feature-card text-center p-4">
          <div class="service-icon mb-3">
            <i class="fas fa-tools fa-3x text-primary"></i>
          </div>
          <h5 class="fw-bold mb-2">Teknisi Bersertifikat</h5>
          <p class="text-muted small">Tim mekanik profesional dengan sertifikat resmi dari pabrikan</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="service-feature-card text-center p-4">
          <div class="service-icon mb-3">
            <i class="fas fa-cogs fa-3x text-success"></i>
          </div>
          <h5 class="fw-bold mb-2">Suku Cadang Original</h5>
          <p class="text-muted small">Garansi suku cadang asli 100% untuk semua motor</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="service-feature-card text-center p-4">
          <div class="service-icon mb-3">
            <i class="fas fa-shield-alt fa-3x text-warning"></i>
          </div>
          <h5 class="fw-bold mb-2">Garansi Resmi</h5>
          <p class="text-muted small">Garansi layanan hingga 6 bulan untuk semua perbaikan</p>
        </div>
      </div>
      <div class="col-md-6 col-lg-3">
        <div class="service-feature-card text-center p-4">
          <div class="service-icon mb-3">
            <i class="fas fa-clock fa-3x text-info"></i>
          </div>
          <h5 class="fw-bold mb-2">Pelayanan Cepat</h5>
          <p class="text-muted small">Service regular 1-2 jam, booking online tersedia</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Locations Grid -->
<section class="section-padding">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Lokasi Kami</h2>
      <p class="text-muted">Dealer dan workshop resmi di kota-kota besar Pulau Jawa</p>
    </div>
    
    <div class="row g-4" id="locationsGrid">
      @foreach($locations as $location)
      <div class="col-lg-4 col-md-6 col-12 location-item" 
           data-city="{{ Str::slug($location->city) }}" 
           data-type="{{ Str::slug($location->type) }}">
        <div class="location-card h-100">
          <div class="location-image-container">
            <img src="{{ asset('images/' . ($location->image ?? 'dilerdanworkshop.png')) }}" class="location-image" alt="{{ $location->name }}">
            <div class="location-badge">
              <span class="badge-type">{{ $location->type }}</span>
            </div>
          </div>
          <div class="location-body">
            <h5 class="location-title">{{ $location->name }}</h5>
            <div class="location-info">
              <p class="location-detail">
                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                <strong>{{ $location->city }}</strong>
              </p>
              <p class="location-detail">
                <i class="fas fa-tachometer-alt text-success me-2"></i>
                <strong>Range CC:</strong> {{ $location->range_cc }}
              </p>
              <p class="location-address">
                <i class="fas fa-home text-info me-2"></i>
                {{ $location->address }}
              </p>
            </div>
            <div class="location-actions">
              <button class="btn btn-outline-primary btn-sm w-100 mb-2" 
                      onclick="showLocationOnMap('{{ $location->name }}', '{{ $location->city }}')">
                <i class="fas fa-map me-2"></i>Lihat di Peta
              </button>
              <button class="btn btn-primary btn-sm w-100" 
                      onclick="window.open('tel:+6287769002763', '_self')">
                <i class="fas fa-phone me-2"></i>Hubungi Kami
              </button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Map Section -->
<section class="section-padding bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold mb-3">Peta Lokasi</h2>
      <p class="text-muted">Temukan dealer dan workshop terdekat dari lokasi Anda</p>
    </div>
    
    <div class="row">
      <div class="col-12">
        <div class="map-container">
          <div id="locationsMap" style="height: 500px; border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.1);"></div>
          <div class="mt-3 text-center">
            <small class="text-muted">
              <i class="fas fa-info-circle me-1"></i>
              Klik pada pin untuk melihat detail lokasi. Gunakan scroll untuk zoom in/out.
            </small>
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
      <h3 class="fw-bold mb-3">Butuh Bantuan Menemukan Lokasi?</h3>
      <p class="text-muted mb-4">Tim customer service kami siap membantu Anda 24/7</p>
      <div class="d-flex gap-3 justify-content-center flex-wrap">
        <a href="tel:+6287769002763" class="btn btn-primary btn-lg">
          <i class="fas fa-phone me-2"></i>Hubungi Sekarang
        </a>
        <a href="{{ route('contact.show') }}" class="btn btn-outline-primary btn-lg">
          <i class="fas fa-envelope me-2"></i>Kirim Pesan
        </a>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Map
    const map = L.map('locationsMap').setView([-6.200000, 106.816666], 9);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add markers for all locations
    const locations = @json($locations);
    const markers = {};

    locations.forEach(loc => {
        if (loc.latitude && loc.longitude) {
            const marker = L.marker([loc.latitude, loc.longitude])
                .addTo(map)
                .bindPopup(`<b>${loc.name}</b><br>${loc.address}`);
            markers[loc.name] = marker;
        }
    });

    // Expose function to global scope for onclick
    window.showLocationOnMap = function(name, city) {
        const loc = locations.find(l => l.name === name);
        
        if (loc && loc.latitude && loc.longitude) {
            map.setView([loc.latitude, loc.longitude], 15);
            if (markers[name]) {
                markers[name].openPopup();
            }
            document.getElementById('locationsMap').scrollIntoView({ behavior: 'smooth' });
        }
    };

    // Filter Logic
    const cityFilter = document.getElementById('cityFilter');
    const typeFilter = document.getElementById('typeFilter');
    const items = document.querySelectorAll('.location-item');

    function filterItems() {
        const city = cityFilter.value;
        const type = typeFilter.value;

        items.forEach(item => {
            const itemCity = item.dataset.city;
            const itemType = item.dataset.type;
            
            const cityMatch = !city || itemCity === city;
            const typeMatch = !type || itemType === type;

            if (cityMatch && typeMatch) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    cityFilter.addEventListener('change', filterItems);
    typeFilter.addEventListener('change', filterItems);

    // Scroll function
    window.scrollToLocations = function() {
        document.getElementById('locationsGrid').scrollIntoView({ behavior: 'smooth' });
    };
});
</script>
@endsection

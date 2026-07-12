@php
  use Illuminate\Support\Str;
@endphp
@extends('layouts.main')

@section('title', 'Diler & WorkShop Kami - SecondCycle')

@section('content')
<!-- Hero Section -->
<section class="py-5 bg-white border-bottom border-light" style="margin-top: 120px;">
  <div class="container py-lg-4">
    <div class="row align-items-center g-5">
      <div class="col-lg-6">
        <span class="badge-premium badge-premium-dark mb-2">Jaringan</span>
        <h1 class="display-5 fw-bold mb-4">Diler & WorkShop Resmi Kami</h1>
        <p class="text-secondary mb-4 fs-5" style="line-height: 1.7;">
          Jaringan dealer dan workshop resmi SecondCycle tersebar di seluruh Pulau Jawa. 
          Setiap lokasi dilengkapi suku cadang original dan teknisi bersertifikat demi kenyamanan berkendara Anda.
        </p>
        
        <div class="d-flex gap-4 pt-3">
          <div>
            <h3 class="fw-bold mb-0 text-dark">{{ $locations->whereIn('type', ['Dealer', 'Dealer & Service', 'Dealer & Service Center'])->count() }}</h3>
            <small class="text-secondary uppercase tracking-wider" style="font-size: 0.7rem; font-weight: 700;">Lokasi Dealer</small>
          </div>
          <div class="border-start border-light ps-4">
            <h3 class="fw-bold mb-0 text-dark">{{ $locations->whereIn('type', ['Service', 'Workshop', 'Dealer & Service', 'Dealer & Service Center'])->count() }}</h3>
            <small class="text-secondary uppercase tracking-wider" style="font-size: 0.7rem; font-weight: 700;">Workshop Resmi</small>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="p-3 bg-light border border-light">
          <img src="{{ asset('images/dilerdanworkshop.png') }}" class="img-fluid w-100" alt="Diler & Workshop SecondCycle" style="height: 320px; object-fit: cover;" onerror="this.src='https://images.unsplash.com/photo-1616422285623-13ff0162193c?auto=format&fit=crop&w=800&q=80'">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Filter Section -->
<section class="py-5 bg-white border-bottom border-light">
  <div class="container">
    <div class="row mb-5 justify-content-center">
      <div class="col-lg-6 text-center">
        <span class="badge-premium badge-premium-accent mb-2">Lokasi</span>
        <h2 class="fw-bold">Temukan Cabang Terdekat</h2>
        <p class="text-secondary">Pilih kota atau jenis layanan untuk mempermudah pencarian.</p>
      </div>
    </div>
    
    <div class="row g-3 justify-content-center mb-5">
      <div class="col-md-4 col-12">
        <select class="form-select" id="cityFilter">
          <option value="">Semua Kota</option>
          @foreach($locations->pluck('city')->unique()->sort() as $city)
            <option value="{{ Str::slug($city) }}">{{ $city }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4 col-12">
        <select class="form-select" id="typeFilter">
          <option value="">Semua Layanan</option>
          @foreach($locations->pluck('type')->unique()->sort() as $type)
            <option value="{{ Str::slug($type) }}">{{ $type }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
</section>

<!-- Locations Grid -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="row g-4" id="locationsGrid">
      @foreach($locations as $location)
      <div class="col-lg-4 col-md-6 col-12 location-item" 
           data-city="{{ Str::slug($location->city) }}" 
           data-type="{{ Str::slug($location->type) }}">
        <div class="modern-card h-100 d-flex flex-column justify-content-between">
          <div>
            <div class="position-relative">
              <img src="{{ asset('images/' . ($location->image ?? 'dilerdanworkshop.png')) }}" class="modern-card-img" alt="{{ $location->name }}" style="height: 180px;" onerror="this.src='https://images.unsplash.com/photo-1616422285623-13ff0162193c?auto=format&fit=crop&w=600&q=80'">
              <div class="position-absolute top-0 start-0 p-3">
                <span class="badge-premium badge-premium-dark">{{ $location->type }}</span>
              </div>
            </div>
            <div class="p-4">
              <h5 class="fw-bold mb-3">{{ $location->name }}</h5>
              <div class="small text-secondary mb-3">
                <p class="mb-2"><i class="ri-map-pin-line me-2 text-dark"></i><strong>{{ $location->city }}</strong></p>
                <p class="mb-2"><i class="ri-steering-line me-2 text-dark"></i><strong>Layanan CC:</strong> {{ $location->range_cc }}</p>
                <p class="mb-0"><i class="ri-home-line me-2 text-dark"></i>{{ $location->address }}</p>
              </div>
            </div>
          </div>
          <div class="p-4 pt-0 d-flex gap-2">
            <button class="btn btn-outline-dark btn-sm flex-fill" 
                    onclick="showLocationOnMap('{{ $location->name }}', '{{ $location->city }}')">
              <i class="ri-map-pin-2-line me-1"></i>Peta
            </button>
            <a href="tel:+6287769002763" class="btn btn-primary btn-sm flex-fill text-center">
              Hubungi
            </a>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<!-- Map Section -->
<section class="py-5 bg-white border-top border-light">
  <div class="container">
    <div class="row mb-4">
      <div class="col-12 text-center">
        <h4 class="fw-bold">Peta Interaktif Jaringan</h4>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        <div class="border border-light p-2 bg-light">
          <div id="locationsMap" style="height: 480px;"></div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('scripts')
{{-- Wait, Leaflet JS & CSS are loaded in main layout. We just initialize map here. --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Map
    const map = L.map('locationsMap').setView([-6.200000, 106.816666], 9);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

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
});
</script>
@endsection

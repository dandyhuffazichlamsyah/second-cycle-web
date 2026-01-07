@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Kelola Produk</h1>
        <nav class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a> / Produk
        </nav>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class="fas fa-plus me-1"></i> Tambah Produk
        </button>
        <a href="{{ route('admin.products.export') }}" class="btn btn-outline-success">
            <i class="fas fa-download me-1"></i> Export
        </a>
    </div>
</div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\Product::count() }}</h4>
                            <p class="card-text">Total Produk</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-motorcycle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\Product::distinct('brand')->count('brand') }}</h4>
                            <p class="card-text">Merek</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-tags fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ \App\Models\Product::whereDate('created_at', today())->count() }}</h4>
                            <p class="card-text">Baru Hari Ini</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-plus-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Rp {{ number_format(\App\Models\Product::sum('price'), 0, ',', '.') }}</h4>
                            <p class="card-text">Total Nilai</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chart-line fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.products') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari Produk</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Nama merek atau model...">
                    </div>
                    <div class="col-md-3">
                        <label for="brand" class="form-label">Merek</label>
                        <select class="form-select" id="brand" name="brand">
                            <option value="">Semua Merek</option>
                            @foreach(\App\Models\Product::distinct()->pluck('brand')->filter() as $brand)
                                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="sort" class="form-label">Urutkan</label>
                        <select class="form-select" id="sort" name="sort">
                            <option value="latest">Terbaru</option>
                            <option value="oldest">Terlama</option>
                            <option value="price_high">Harga Tertinggi</option>
                            <option value="price_low">Harga Terendah</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-body">
            @if(isset($products) && $products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Gambar</th>
                                <th>Informasi Produk</th>
                                <th>Harga</th>
                                <th>Grade</th>
                                <th>Tipe</th>
                                <th>Ditambahkan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" 
                                             alt="{{ $product->name }}" class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary d-flex align-items-center justify-content-center rounded" style="width: 60px; height: 60px;">
                                            <i class="fas fa-motorcycle text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold">{{ $product->name }}</div>
                                    <small class="text-muted">{{ $product->brand ?? 'N/A' }}</small><br>
                                    @if($product->cc)
                                    <small class="text-muted">{{ $product->cc }}cc</small>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                </td>
                                <td>
                                    @if($product->grade)
                                        <span class="badge bg-{{ $product->grade_color }}">Grade {{ $product->grade }}</span>
                                    @else
                                        <span class="badge bg-secondary">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $product->type ?? 'Motor' }}</span>
                                </td>
                                <td>
                                    <small>{{ $product->created_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $product->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button class="btn btn-outline-primary" onclick="viewProduct({{ $product->id }})" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-outline-warning" onclick="editProduct({{ $product->id }})" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-success" onclick="duplicateProduct({{ $product->id }})" title="Duplikat">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                        <button class="btn btn-outline-danger" onclick="deleteProduct({{ $product->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <div>
                        <small class="text-muted">
                            Menampilkan {{ $products->firstItem() }} - {{ $products->lastItem() }} 
                            dari {{ $products->total() }} produk
                        </small>
                    </div>
                    <div>
                        {{ $products->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-motorcycle fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada produk</h5>
                    <p class="text-muted">Mulai tambahkan produk motor bekas untuk dijual.</p>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus me-1"></i> Tambah Produk Pertama
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">➕ Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addProductForm">
                    @csrf
                    
                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs mb-3" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">Informasi Utama</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="specs-tab" data-bs-toggle="tab" data-bs-target="#specs" type="button" role="tab">Spesifikasi & Mesin</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="body-tab" data-bs-toggle="tab" data-bs-target="#body" type="button" role="tab">Fisik & Body</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="docs-tab" data-bs-toggle="tab" data-bs-target="#docs" type="button" role="tab">Dokumen</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">Riwayat & Lainnya</button>
                        </li>
                    </ul>

                    <!-- Tabs Content -->
                    <div class="tab-content" id="productTabsContent">
                        <!-- 1. Informasi Utama -->
                        <div class="tab-pane fade show active" id="info" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" class="form-control" id="productName" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Merek</label>
                                    <select class="form-select" id="productBrand" name="brand" required>
                                        <option value="">Pilih Merek</option>
                                        <option value="Honda">Honda</option>
                                        <option value="Yamaha">Yamaha</option>
                                        <option value="Suzuki">Suzuki</option>
                                        <option value="Kawasaki">Kawasaki</option>
                                        <option value="Vespa">Vespa</option>
                                        <option value="KTM">KTM</option>
                                        <option value="Other">Lainnya</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tipe</label>
                                    <select class="form-select" id="productType" name="type">
                                        <option value="">Pilih Tipe</option>
                                        <option value="Matic">Matic</option>
                                        <option value="Sport">Sport</option>
                                        <option value="Bebek">Bebek</option>
                                        <option value="Trail">Trail</option>
                                        <option value="Naked">Naked</option>
                                        <option value="Touring">Touring</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">CC</label>
                                    <input type="number" class="form-control" id="productCC" name="cc">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Warna</label>
                                    <input type="text" class="form-control" id="productColor" name="color">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tahun Pembuatan</label>
                                    <input type="number" class="form-control" id="yearManufacture" name="year_manufacture" min="1900" max="{{ date('Y')+1 }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Tahun Perakitan</label>
                                    <input type="number" class="form-control" id="yearAssembly" name="year_assembly" min="1900" max="{{ date('Y')+1 }}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Lokasi Unit</label>
                                    <select class="form-select" id="productLocation" name="location">
                                        <option value="">Pilih Lokasi</option>
                                        @if(isset($locations))
                                            @foreach($locations as $location)
                                                <option value="{{ $location->name }}">{{ $location->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" class="form-control" id="productPrice" name="price" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Gambar Produk</label>
                                <input type="file" class="form-control" id="productImage" name="image" accept="image/*">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Singkat</label>
                                <textarea class="form-control" id="productShortDescription" name="short_description" rows="2"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi Lengkap</label>
                                <textarea class="form-control" id="productDescription" name="description" rows="3"></textarea>
                            </div>
                        </div>

                        <!-- 2. Spesifikasi & Mesin -->
                        <div class="tab-pane fade" id="specs" role="tabpanel">
                            <h6 class="mb-3">Kondisi Mesin</h6>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Suara Mesin</label>
                                    <select class="form-select" id="engineSound" name="engine_sound">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Normal">Normal (Halus)</option>
                                        <option value="Menggelitik">Menggelitik (Kasar)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kebocoran Oli</label>
                                    <select class="form-select" id="oilLeak" name="oil_leak">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Kering">Kering (Tidak ada)</option>
                                        <option value="Rembes">Rembes (Sedikit)</option>
                                        <option value="Bocor">Bocor (Parah)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Asap Knalpot</label>
                                    <select class="form-select" id="exhaustSmoke" name="exhaust_smoke">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Normal">Normal (Tidak berasap)</option>
                                        <option value="Putih">Asap Putih</option>
                                        <option value="Hitam">Asap Hitam</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Tarikan Mesin</label>
                                    <select class="form-select" id="enginePull" name="engine_pull">
                                        <option value="">Pilih Kondisi</option>
                                        <option value="Responsif">Responsif</option>
                                        <option value="Berat">Berat/Lemot</option>
                                    </select>
                                </div>
                            </div>
                            <h6 class="mb-3 mt-2">Odometer & Penggunaan</h6>
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Kilometer (KM)</label>
                                    <input type="number" class="form-control" id="odometer" name="odometer">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Jenis Penggunaan</label>
                                    <select class="form-select" id="usageType" name="usage_type">
                                        <option value="">Pilih</option>
                                        <option value="Harian">Harian</option>
                                        <option value="Touring">Touring</option>
                                        <option value="Jarang Pakai">Jarang Pakai</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Lokasi Penggunaan</label>
                                    <select class="form-select" id="usageLocation" name="usage_location">
                                        <option value="">Pilih</option>
                                        <option value="Dalam Kota">Dalam Kota</option>
                                        <option value="Luar Kota">Luar Kota</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 3. Fisik & Body -->
                        <div class="tab-pane fade" id="body" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kondisi Cat Body</label>
                                    <select class="form-select" id="bodyCondition" name="body_condition">
                                        <option value="Mulus">Mulus (Original)</option>
                                        <option value="Lecet Pemakaian">Lecet Pemakaian Wajar</option>
                                        <option value="Lecet Parah">Lecet Parah</option>
                                        <option value="Repaint">Cat Ulang (Repaint)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kondisi Rangka</label>
                                    <select class="form-select" id="frameCondition" name="frame_condition">
                                        <option value="Normal">Normal (Lurus)</option>
                                        <option value="Karat">Berkarat</option>
                                        <option value="Bengkok">Bengkok/Bekas Tabrak</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kaki-kaki</label>
                                    <select class="form-select" id="legsCondition" name="legs_condition">
                                        <option value="Stabil">Stabil</option>
                                        <option value="Oblak">Oblak/Bunyi</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Kelistrikan & Lampu</label>
                                    <select class="form-select" id="electricalCondition" name="electrical_condition">
                                        <option value="Normal">Normal (Semua Nyala)</option>
                                        <option value="Perlu Perbaikan">Ada yang Mati</option>
                                    </select>
                                </div>
                            </div>
                            <h6 class="mb-3 mt-2">Modifikasi</h6>
                            <div class="mb-3">
                                <label class="form-label">Knalpot</label>
                                <select class="form-select" id="exhaustType" name="exhaust_type">
                                    <option value="Standar">Standar Original</option>
                                    <option value="Racing">Racing (Aftermarket)</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Daftar Modifikasi</label>
                                <textarea class="form-control" id="modifications" name="modifications" rows="2" placeholder="Contoh: Spion tomok, Handgrip RCB..."></textarea>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="modificationsLegal" name="modifications_legal" value="1" checked>
                                <label class="form-check-label" for="modificationsLegal">Modifikasi Legal (Aman Tilang)</label>
                            </div>
                        </div>

                        <!-- 4. Dokumen & Legalitas -->
                        <div class="tab-pane fade" id="docs" role="tabpanel">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status STNK</label>
                                    <select class="form-select" id="stnkStatus" name="stnk_status">
                                        <option value="Ada">Ada</option>
                                        <option value="Hilang">Hilang</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status BPKB</label>
                                    <select class="form-select" id="bpkbStatus" name="bpkb_status">
                                        <option value="Ada">Ada (Ready)</option>
                                        <option value="Sekolah">Sekolah (Digadaikan)</option>
                                        <option value="Hilang">Hilang</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Status Pajak</label>
                                    <select class="form-select" id="taxStatus" name="tax_status">
                                        <option value="Hidup">Hidup (Taat Pajak)</option>
                                        <option value="Mati">Mati (Telat Pajak)</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Masa Berlaku Pajak/STNK</label>
                                    <input type="date" class="form-control" id="taxExpiry" name="tax_expiry">
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Status Plat Nomor</label>
                                    <select class="form-select" id="plateNumberStatus" name="plate_number_status">
                                        <option value="Asli">Asli (Sesuai Unit)</option>
                                        <option value="Mutasi">Sedang Mutasi</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 5. Riwayat & Lainnya -->
                        <div class="tab-pane fade" id="history" role="tabpanel">
                            <h6 class="mb-3">Riwayat Servis</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="routineService" name="routine_service" value="1">
                                        <label class="form-check-label" for="routineService">Servis Rutin</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="serviceBook" name="service_book" value="1">
                                        <label class="form-check-label" for="serviceBook">Buku Servis Ada</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Catatan Servis/Part Baru</label>
                                <textarea class="form-control" id="serviceNotes" name="service_notes" rows="2" placeholder="Contoh: Baru ganti ban, ganti oli..."></textarea>
                            </div>

                            <h6 class="mb-3 mt-4">Inspeksi Keamanan</h6>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="accidentHistory" name="accident_history" value="1">
                                        <label class="form-check-label" for="accidentHistory">Bekas Tabrakan</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="floodHistory" name="flood_history" value="1">
                                        <label class="form-check-label" for="floodHistory">Bekas Banjir</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="engineOverhaul" name="engine_overhaul" value="1">
                                        <label class="form-check-label" for="engineOverhaul">Pernah Turun Mesin</label>
                                    </div>
                                </div>
                            </div>

                            <h6 class="mb-3 mt-4">Kelengkapan Unit</h6>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="spareKey" name="spare_key" value="1">
                                        <label class="form-check-label" for="spareKey">Kunci Cadangan</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="toolkit" name="toolkit" value="1">
                                        <label class="form-check-label" for="toolkit">Toolkit</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="manualBook" name="manual_book" value="1">
                                        <label class="form-check-label" for="manualBook">Buku Manual</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="bonusHelmet" name="bonus_helmet" value="1">
                                        <label class="form-check-label" for="bonusHelmet">Bonus Helm</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="saveProduct()">
                    <i class="fas fa-save me-1"></i> Simpan Produk
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let editingProductId = null;

function viewProduct(id) {
    fetch(`/admin/products/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const product = data.product;
            const modalHtml = `
                <div class="modal fade" id="viewProductModal" tabindex="-1">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">📋 Detail Produk: ${product.name}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row mb-4">
                                    <div class="col-md-4 text-center">
                                        ${product.image ? 
                                            `<img src="${window.location.origin}/storage/${product.image}" class="img-fluid rounded mb-2" alt="${product.name}">` :
                                            `<div class="bg-secondary d-flex align-items-center justify-content-center rounded mb-2" style="height: 200px; color: white;"><i class="fas fa-motorcycle fa-3x"></i></div>`
                                        }
                                        <h4 class="text-primary fw-bold">Rp ${parseInt(product.price).toLocaleString('id-ID')}</h4>
                                        <div class="mb-2">
                                            <span class="badge bg-info">${product.type} ${product.cc}cc</span>
                                            ${product.grade ? `<span class="badge bg-${getGradeColor(product.grade)}">Grade ${product.grade}</span>` : ''}
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <table class="table table-striped table-sm">
                                            <tr><th width="40%">Merek & Model</th><td>${product.brand} ${product.name}</td></tr>
                                            <tr><th>Lokasi Unit</th><td>${product.location || '-'}</td></tr>
                                            <tr><th>Tahun</th><td>${product.year_manufacture || '-'} (Perakitan: ${product.year_assembly || '-'})</td></tr>
                                            <tr><th>Warna</th><td>${product.color || '-'}</td></tr>
                                            <tr><th>Odometer</th><td>${product.odometer ? product.odometer.toLocaleString('id-ID') + ' KM' : '-'}</td></tr>
                                            <tr><th>Penggunaan</th><td>${product.usage_type || '-'} (${product.usage_location || '-'})</td></tr>
                                        </table>
                                    </div>
                                </div>

                                <h6 class="border-bottom pb-2">Dokumen & Legalitas</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><strong>STNK:</strong> ${product.stnk_status || '-'}</li>
                                            <li><strong>BPKB:</strong> ${product.bpkb_status || '-'}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><strong>Pajak:</strong> ${product.tax_status || '-'} (Exp: ${product.tax_expiry || '-'})</li>
                                            <li><strong>Plat Nomor:</strong> ${product.plate_number_status || '-'}</li>
                                        </ul>
                                    </div>
                                </div>

                                <h6 class="border-bottom pb-2">Kondisi Fisik & Mesin</h6>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><strong>Body:</strong> ${product.body_condition || '-'}</li>
                                            <li><strong>Rangka:</strong> ${product.frame_condition || '-'}</li>
                                            <li><strong>Kaki-kaki:</strong> ${product.legs_condition || '-'}</li>
                                            <li><strong>Kelistrikan:</strong> ${product.electrical_condition || '-'}</li>
                                        </ul>
                                    </div>
                                    <div class="col-md-6">
                                        <ul class="list-unstyled">
                                            <li><strong>Suara Mesin:</strong> ${product.engine_sound || '-'}</li>
                                            <li><strong>Kebocoran Oli:</strong> ${product.oil_leak || '-'}</li>
                                            <li><strong>Asap Knalpot:</strong> ${product.exhaust_smoke || '-'}</li>
                                            <li><strong>Tarikan:</strong> ${product.engine_pull || '-'}</li>
                                        </ul>
                                    </div>
                                </div>

                                <h6 class="border-bottom pb-2">Riwayat & Lainnya</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <p><strong>Modifikasi:</strong> ${product.modifications || '-'}</p>
                                        <p><strong>Catatan Servis:</strong> ${product.service_notes || '-'}</p>
                                        <div>
                                            ${product.routine_service ? '<span class="badge bg-success me-1">Servis Rutin</span>' : ''}
                                            ${product.service_book ? '<span class="badge bg-success me-1">Buku Servis</span>' : ''}
                                            ${product.accident_history ? '<span class="badge bg-danger me-1">Bekas Tabrakan</span>' : '<span class="badge bg-success me-1">Bebas Tabrakan</span>'}
                                            ${product.flood_history ? '<span class="badge bg-danger me-1">Bekas Banjir</span>' : '<span class="badge bg-success me-1">Bebas Banjir</span>'}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            const existingModal = document.getElementById('viewProductModal');
            if (existingModal) existingModal.remove();
            
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const modal = new bootstrap.Modal(document.getElementById('viewProductModal'));
            modal.show();
        } else {
            showAlert('error', 'Gagal memuat detail produk');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat memuat detail produk');
    });
}

function editProduct(id) {
    fetch(`/admin/products/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const product = data.product;
            editingProductId = id;
            
            // 1. Informasi Utama
            document.getElementById('productName').value = product.name;
            document.getElementById('productBrand').value = product.brand || '';
            document.getElementById('productType').value = product.type || '';
            document.getElementById('productCC').value = product.cc || '';
            document.getElementById('productColor').value = product.color || '';
            document.getElementById('yearManufacture').value = product.year_manufacture || '';
            document.getElementById('yearAssembly').value = product.year_assembly || '';
            document.getElementById('productLocation').value = product.location || '';
            document.getElementById('productPrice').value = product.price;
            document.getElementById('productShortDescription').value = product.short_description || '';
            document.getElementById('productDescription').value = product.description || '';

            // 2. Spesifikasi & Mesin
            document.getElementById('engineSound').value = product.engine_sound || '';
            document.getElementById('oilLeak').value = product.oil_leak || '';
            document.getElementById('exhaustSmoke').value = product.exhaust_smoke || '';
            document.getElementById('enginePull').value = product.engine_pull || '';
            document.getElementById('odometer').value = product.odometer || '';
            document.getElementById('usageType').value = product.usage_type || '';
            document.getElementById('usageLocation').value = product.usage_location || '';

            // 3. Fisik & Body
            document.getElementById('bodyCondition').value = product.body_condition || '';
            document.getElementById('frameCondition').value = product.frame_condition || '';
            document.getElementById('legsCondition').value = product.legs_condition || '';
            document.getElementById('electricalCondition').value = product.electrical_condition || '';
            document.getElementById('exhaustType').value = product.exhaust_type || '';
            document.getElementById('modifications').value = product.modifications || '';
            document.getElementById('modificationsLegal').checked = product.modifications_legal == 1;

            // 4. Dokumen
            document.getElementById('stnkStatus').value = product.stnk_status || '';
            document.getElementById('bpkbStatus').value = product.bpkb_status || '';
            document.getElementById('taxStatus').value = product.tax_status || '';
            document.getElementById('taxExpiry').value = product.tax_expiry ? product.tax_expiry.split('T')[0] : '';
            document.getElementById('plateNumberStatus').value = product.plate_number_status || '';

            // 5. Riwayat
            document.getElementById('routineService').checked = product.routine_service == 1;
            document.getElementById('serviceBook').checked = product.service_book == 1;
            document.getElementById('serviceNotes').value = product.service_notes || '';
            document.getElementById('accidentHistory').checked = product.accident_history == 1;
            document.getElementById('floodHistory').checked = product.flood_history == 1;
            document.getElementById('engineOverhaul').checked = product.engine_overhaul == 1;
            document.getElementById('spareKey').checked = product.spare_key == 1;
            document.getElementById('toolkit').checked = product.toolkit == 1;
            document.getElementById('manualBook').checked = product.manual_book == 1;
            document.getElementById('bonusHelmet').checked = product.bonus_helmet == 1;
            
            document.querySelector('#addProductModal .modal-title').innerHTML = '✏️ Edit Produk';
            
            // Switch to first tab
            const firstTab = new bootstrap.Tab(document.querySelector('#productTabs button:first-child'));
            firstTab.show();

            const modal = new bootstrap.Modal(document.getElementById('addProductModal'));
            modal.show();
        } else {
            showAlert('error', 'Gagal memuat data produk');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat memuat data produk');
    });
}

function duplicateProduct(id) {
    if (confirm('Apakah Anda ingin menduplikasi produk ini?')) {
        fetch(`/admin/products/${id}/duplicate`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                location.reload();
            } else {
                showAlert('error', 'Gagal menduplikasi produk');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat menduplikasi produk');
        });
    }
}

function deleteProduct(id) {
    if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
        fetch(`/admin/products/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert('success', data.message);
                location.reload();
            } else {
                showAlert('error', 'Gagal menghapus produk');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showAlert('error', 'Terjadi kesalahan saat menghapus produk');
        });
    }
}

function saveProduct() {
    const form = document.getElementById('addProductForm');
    const formData = new FormData(form);
    const isEdit = editingProductId !== null;
    
    const url = isEdit ? `/admin/products/${editingProductId}` : '/admin/products';
    const method = isEdit ? 'PUT' : 'POST';
    
    // Add method for PUT request
    if (isEdit) {
        formData.append('_method', 'PUT');
    }
    
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showAlert('success', data.message);
            
            // Close modal
            const modal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
            modal.hide();
            
            // Reset form and editing state
            form.reset();
            editingProductId = null;
            document.querySelector('#addProductModal .modal-title').innerHTML = '➕ Tambah Produk Baru';
            
            // Reload page to show updated data
            location.reload();
        } else {
            showAlert('error', 'Gagal menyimpan produk');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert('error', 'Terjadi kesalahan saat menyimpan produk');
    });
}

function showAlert(type, message) {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show position-fixed" style="top: 20px; right: 20px; z-index: 9999;" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert.position-fixed');
        if (alert) alert.remove();
    }, 5000);
}

// Reset form when modal is closed
document.getElementById('addProductModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('addProductForm').reset();
    editingProductId = null;
    document.querySelector('#addProductModal .modal-title').innerHTML = '➕ Tambah Produk Baru';
    // Reset tabs
    const firstTab = new bootstrap.Tab(document.querySelector('#productTabs button:first-child'));
    firstTab.show();
});

function getGradeColor(grade) {
    const colors = {
        'A': 'success',
        'B': 'primary',
        'C': 'warning',
        'D': 'danger'
    };
    return colors[grade] || 'secondary';
}
</script>
@endsection

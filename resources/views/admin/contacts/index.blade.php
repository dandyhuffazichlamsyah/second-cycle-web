@extends('layouts.admin')

@section('title', 'Kelola Pesan Kontak')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Kelola Pesan Kontak</h1>
        <nav class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a> / Pesan Kontak
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.contacts.export') }}" class="btn btn-outline-success">
            <i class="fas fa-download me-1"></i> Export CSV
        </a>
    </div>
</div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['total'] }}</h4>
                            <p class="card-text">Total Pesan</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-envelope fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['unread'] }}</h4>
                            <p class="card-text">Belum Dibaca</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-envelope-open-text fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">{{ $stats['today'] }}</h4>
                            <p class="card-text">Hari Ini</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-day fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.contacts') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">Cari (Nama/Email/Subjek)</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="Kata kunci...">
                    </div>
                    <div class="col-md-3">
                        <label for="department" class="form-label">Departemen</label>
                        <select class="form-select" id="department" name="department">
                            <option value="">Semua Departemen</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>
                                    {{ ucfirst($dept) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="read" class="form-label">Status</label>
                        <select class="form-select" id="read" name="read">
                            <option value="">Semua Status</option>
                            <option value="0" {{ request('read') === '0' ? 'selected' : '' }}>Belum Dibaca</option>
                            <option value="1" {{ request('read') === '1' ? 'selected' : '' }}>Sudah Dibaca</option>
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

    <!-- Messages Table -->
    <div class="card">
        <div class="card-body">
            @if($messages->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Telepon</th>
                                <th>Departemen</th>
                                <th>Subjek</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                            <tr class="{{ !$message->read ? 'table-warning' : '' }}">
                                <td>
                                    @if($message->read)
                                        <span class="badge bg-success">
                                            <i class="fas fa-check me-1"></i>Dibaca
                                        </span>
                                    @else
                                        <span class="badge bg-warning">
                                            <i class="fas fa-envelope me-1"></i>Baru
                                        </span>
                                    @endif
                                    @if($message->replied_at)
                                        <span class="badge bg-info">
                                            <i class="fas fa-reply me-1"></i>Dibalas
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $message->created_at->format('d M Y') }}</small><br>
                                    <small class="text-muted">{{ $message->created_at->format('H:i') }}</small>
                                </td>
                                <td>
                                    <strong>{{ $message->name }}</strong>
                                </td>
                                <td>
                                    <a href="mailto:{{ $message->email }}" class="text-decoration-none">
                                        {{ $message->email }}
                                    </a>
                                </td>
                                <td>
                                    @if($message->phone)
                                        <a href="tel:{{ $message->phone }}" class="text-decoration-none">
                                            {{ $message->phone }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($message->department)
                                        <span class="badge bg-secondary">
                                            {{ ucfirst($message->department) }}
                                        </span>
                                    @else
                                        <span class="text-muted">Umum</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-truncate d-block" style="max-width: 200px;">
                                        {{ $message->subject }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.contacts.show', $message) }}" 
                                           class="btn btn-outline-primary" title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.contacts.toggle-read', $message) }}" 
                                              class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-info" 
                                                    title="{{ $message->read ? 'Tandai Belum Dibaca' : 'Tandai Dibaca' }}">
                                                <i class="fas {{ $message->read ? 'fa-envelope' : 'fa-envelope-open' }}"></i>
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.contacts.destroy', $message) }}" 
                                              class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
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
                            Menampilkan {{ $messages->firstItem() }} - {{ $messages->lastItem() }} 
                            dari {{ $messages->total() }} pesan
                        </small>
                    </div>
                    <div>
                        {{ $messages->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Tidak ada pesan ditemukan</h5>
                    <p class="text-muted">Coba ubah filter atau tunggu pesan baru dari customer.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.table-warning {
    background-color: #fff3cd !important;
}
.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
@endsection

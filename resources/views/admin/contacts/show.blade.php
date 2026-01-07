@extends('layouts.admin')

@section('title', 'Detail Pesan')

@section('content')
<!-- Page Header -->
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Detail Pesan</h1>
        <nav class="page-breadcrumb">
            <a href="{{ route('admin.dashboard') }}">Admin</a> / <a href="{{ route('admin.contacts') }}">Pesan Kontak</a> / Detail
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.contacts') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

    <div class="row">
        <!-- Message Details -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">📝 Informasi Pesan</h5>
                    <div>
                        @if($message->read)
                            <span class="badge bg-success me-2">
                                <i class="fas fa-check me-1"></i>Sudah Dibaca
                            </span>
                        @else
                            <span class="badge bg-warning me-2">
                                <i class="fas fa-envelope me-1"></i>Belum Dibaca
                            </span>
                        @endif
                        @if($message->replied_at)
                            <span class="badge bg-info">
                                <i class="fas fa-reply me-1"></i>Dibalas
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>👤 Nama:</strong> {{ $message->name }}
                        </div>
                        <div class="col-md-6">
                            <strong>📧 Email:</strong> 
                            <a href="mailto:{{ $message->email }}" class="text-decoration-none">
                                {{ $message->email }}
                            </a>
                        </div>
                    </div>
                    
                    @if($message->phone)
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>📱 Telepon:</strong> 
                            <a href="tel:{{ $message->phone }}" class="text-decoration-none">
                                {{ $message->phone }}
                            </a>
                        </div>
                        <div class="col-md-6">
                            <strong>🏢 Departemen:</strong> 
                            @if($message->department)
                                <span class="badge bg-secondary">{{ ucfirst($message->department) }}</span>
                            @else
                                <span class="text-muted">Umum</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>📅 Tanggal:</strong> {{ $message->created_at->format('d M Y H:i') }}
                        </div>
                        <div class="col-md-6">
                            <strong>📢 Newsletter:</strong> 
                            @if($message->newsletter)
                                <span class="badge bg-success">Ya</span>
                            @else
                                <span class="badge bg-secondary">Tidak</span>
                            @endif
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="mb-3">
                        <strong>📝 Subjek:</strong>
                        <h6 class="mt-2">{{ $message->subject }}</h6>
                    </div>
                    
                    <div class="mb-3">
                        <strong>💬 Pesan:</strong>
                        <div class="mt-2 p-3 bg-light rounded">
                            {{ nl2br(e($message->message)) }}
                        </div>
                    </div>

                    @if($message->replied_at && $message->reply_content)
                    <div class="mb-3">
                        <strong>📨 Riwayat Balasan:</strong>
                        <div class="mt-2 p-3 bg-info bg-opacity-10 rounded">
                            <small class="text-muted d-block mb-2">
                                Dibalas pada: {{ $message->replied_at->format('d M Y H:i') }}
                            </small>
                            {{ nl2br(e($message->reply_content)) }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">⚡ Aksi Cepat</h5>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('admin.contacts.toggle-read', $message) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-info w-100">
                                    <i class="fas {{ $message->read ? 'fa-envelope' : 'fa-envelope-open' }} me-1"></i>
                                    {{ $message->read ? 'Tandai Belum Dibaca' : 'Tandai Dibaca' }}
                                </button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <a href="mailto:{{ $message->email }}?subject=Re: {{ $message->subject }}" 
                               class="btn btn-outline-primary w-100">
                                <i class="fas fa-external-link-alt me-1"></i>
                                Buka Email Client
                            </a>
                        </div>
                        <div class="col-md-4">
                            <form method="POST" action="{{ route('admin.contacts.destroy', $message) }}" 
                                  onsubmit="return confirm('Yakin ingin menghapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-trash me-1"></i>
                                    Hapus Pesan
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reply Form -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">💬 Balas Pesan</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.contacts.reply', $message) }}">
                        @csrf
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subjek Balasan</label>
                            <input type="text" class="form-control" id="subject" name="subject" 
                                   value="Re: {{ $message->subject }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="reply" class="form-label">Isi Balasan</label>
                            <textarea class="form-control" id="reply" name="reply" rows="8" 
                                      placeholder="Tulis balasan Anda di sini..." required></textarea>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Balasan akan dikirim ke {{ $message->email }}
                            </small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>
                                Kirim Balasan Email
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="clearReplyForm()">
                                <i class="fas fa-eraser me-1"></i>
                                Reset Form
                            </button>
                        </div>
                    </form>

                    <hr>

                    <div class="alert alert-info">
                        <h6 class="alert-heading">📞 Kontak Customer:</h6>
                        <p class="mb-1">
                            <strong>Email:</strong> 
                            <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                        </p>
                        @if($message->phone)
                        <p class="mb-0">
                            <strong>Telepon:</strong> 
                            <a href="tel:{{ $message->phone }}">{{ $message->phone }}</a>
                        </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function clearReplyForm() {
    document.getElementById('reply').value = '';
    document.getElementById('subject').value = 'Re: {{ $message->subject }}';
}

// Auto-save draft reply
let replyDraft = '';
const replyTextarea = document.getElementById('reply');

if (replyTextarea) {
    replyTextarea.addEventListener('input', function() {
        replyDraft = this.value;
        localStorage.setItem('replyDraft_{{ $message->id }}', replyDraft);
    });

    // Load draft if exists
    const savedDraft = localStorage.getItem('replyDraft_{{ $message->id }}');
    if (savedDraft) {
        replyTextarea.value = savedDraft;
    }

    // Clear draft after successful submission
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        localStorage.removeItem('replyDraft_{{ $message->id }}');
    }
}
</script>
@endsection

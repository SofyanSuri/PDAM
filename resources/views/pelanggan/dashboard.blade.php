@extends('layouts.app')

@section('title', 'Dashboard Pelanggan')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Dashboard Pelanggan</h1>
            <p class="page-subtitle mb-0">Kelola pengaduan dan pantau status layanan PDAM</p>
        </div>
        <div class="dashboard-date">
            <i class="fas fa-calendar-alt me-2"></i>
            <span id="currentDate"></span>
        </div>
    </div>

    <div class="row g-4">
        <!-- Form Pengaduan -->
        <div class="col-xl-5 col-lg-6">
            <div class="form-container">
                <div class="form-header">
                    <div class="form-icon">
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div>
                        <h4 class="form-title mb-1">Buat Pengaduan Baru</h4>
                        <p class="form-subtitle mb-0">Sampaikan keluhan atau saran Anda</p>
                    </div>
                </div>
                
                <div class="form-body">
                    <form action="{{ route('pengaduan.store') }}" method="POST" id="pengaduanForm">
                        @csrf
                        <div class="form-group">
                            <label for="judul" class="form-label">
                                <i class="fas fa-heading me-2"></i>Judul Pengaduan
                            </label>
                            <input type="text" name="judul" id="judul" class="form-control modern-input" 
                                   placeholder="Masukkan judul pengaduan..." required>
                        </div>
                        
                        <div class="form-group">
                            <label for="isi" class="form-label">
                                <i class="fas fa-edit me-2"></i>Isi Pengaduan
                            </label>
                            <textarea name="isi" id="isi" class="form-control modern-textarea" rows="5" 
                                      placeholder="Jelaskan detail pengaduan Anda..." required></textarea>
                            <div class="char-counter">
                                <span id="charCount">0</span> karakter
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-submit">
                            <i class="fas fa-paper-plane me-2"></i>
                            Kirim Pengaduan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Riwayat Pengaduan -->
        <div class="col-xl-7 col-lg-6">
            <div class="history-container">
                <div class="history-header mb-3">
                    <div class="history-title">
                        <h4 class="mb-1">
                            <i class="fas fa-history me-2"></i>
                            Riwayat Pengaduan Saya
                        </h4>
                        <p class="history-subtitle mb-0">Pantau status dan progres pengaduan Anda</p>
                    </div>
                    <div class="history-stats">
                        <span class="stat-badge">{{ count($pengaduanSaya) }} Total</span>
                    </div>
                </div>

                <div class="history-body">
                    @if(count($pengaduanSaya) > 0)
                        <div class="pengaduan-list">
                            @foreach($pengaduanSaya as $index => $p)
                            <div class="pengaduan-item card mb-3 shadow-sm border-0" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="card-title mb-0">{{ $p->judul }}</h5>
                                        <span class="badge bg-{{ $p->status == 'selesai' ? 'success' : ($p->status == 'proses' ? 'warning' : 'secondary') }}">
                                            @if($p->status == 'baru')
                                                <i class="fas fa-clock"></i> Baru
                                            @elseif($p->status == 'proses')
                                                <i class="fas fa-spinner fa-spin"></i> Diproses
                                            @else
                                                <i class="fas fa-check-circle"></i> Selesai
                                            @endif
                                        </span>
                                    </div>

                                    <p class="card-text mt-2 mb-2 text-muted">
                                        {{ \Illuminate\Support\Str::limit($p->isi, 150) }}
                                    </p>

                                    <div class="d-flex justify-content-between text-muted small">
                                        <span><i class="fas fa-calendar-alt me-1"></i>{{ $p->created_at->format('d M Y') }}</span>
                                        <span><i class="fas fa-clock me-1"></i>{{ $p->created_at->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center p-5 bg-light rounded shadow-sm">
                            <i class="fas fa-inbox fa-3x mb-3 text-muted"></i>
                            <h5 class="text-muted">Belum Ada Pengaduan</h5>
                            <p class="text-muted">Silakan buat pengaduan baru melalui form yang tersedia.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .container-fluid {
        max-width: 1400px;
    }

    .page-title {
        color: var(--text-dark);
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.025em;
    }

    .page-subtitle {
        color: var(--text-muted);
        font-size: 1rem;
    }

    .dashboard-date {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Form Container */
    .form-container {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .form-header {
        padding: 2rem 2rem 1rem;
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--soft-blue) 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.25rem;
        flex-shrink: 0;
    }

    .form-title {
        color: var(--text-dark);
        font-weight: 700;
        font-size: 1.25rem;
    }

    .form-subtitle {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .form-body {
        padding: 2rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    .modern-input, .modern-textarea {
        background: rgba(255, 255, 255, 0.9);
        border: 2px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .modern-input:focus, .modern-textarea:focus {
        outline: none;
        border-color: var(--soft-blue);
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background: white;
        transform: translateY(-1px);
    }

    .modern-textarea {
        resize: vertical;
        min-height: 120px;
    }

    .char-counter {
        text-align: right;
        font-size: 0.875rem;
        color: var(--text-muted);
        margin-top: 0.5rem;
    }

    .btn-submit {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--soft-blue) 100%);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-weight: 600;
        font-size: 0.95rem;
        color: white;
        transition: all 0.3s ease;
        width: 100%;
        position: relative;
        overflow: hidden;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, var(--soft-blue) 0%, var(--primary-blue) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(37, 99, 235, 0.3);
        color: white;
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    /* History Container */
    .history-container {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        height: fit-content;
    }

    .history-header {
        padding: 2rem 2rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid var(--border-color);
    }

    .history-title h4 {
        color: var(--text-dark);
        font-weight: 700;
        font-size: 1.25rem;
    }

    .history-subtitle {
        color: var(--text-muted);
        font-size: 0.9rem;
    }

    .stat-badge {
        background: var(--light-blue);
        color: var(--primary-blue);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .history-body {
        padding: 1rem 2rem 2rem;
        max-height: 600px;
        overflow-y: auto;
    }

    /* Pengaduan Items */
    .pengaduan-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .pengaduan-item {
        background: rgba(255, 255, 255, 0.7);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .pengaduan-item:hover {
        background: rgba(255, 255, 255, 0.9);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .pengaduan-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 0.75rem;
        gap: 1rem;
    }

    .pengaduan-title {
        color: var(--text-dark);
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
        flex: 1;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.375rem;
        flex-shrink: 0;
    }

    .status-baru {
        background: rgba(37, 99, 235, 0.1);
        color: var(--primary-blue);
    }

    .status-proses {
        background: rgba(245, 158, 11, 0.1);
        color: #d97706;
    }

    .status-selesai {
        background: rgba(16, 185, 129, 0.1);
        color: #059669;
    }

    .pengaduan-meta {
        display: flex;
        gap: 1.5rem;
        margin-bottom: 0.75rem;
    }

    .pengaduan-date, .pengaduan-time {
        color: var(--text-muted);
        font-size: 0.875rem;
        display: flex;
        align-items: center;
    }

    .pengaduan-preview {
        color: var(--text-muted);
        font-size: 0.9rem;
        line-height: 1.5;
        margin-top: 0.5rem;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-icon {
        font-size: 3rem;
        color: var(--text-muted);
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .empty-title {
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-text {
        color: var(--text-muted);
        font-size: 0.95rem;
        max-width: 300px;
        margin: 0 auto;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .form-container {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .dashboard-date {
            display: none;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
        
        .form-header, .history-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
        .pengaduan-header {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .pengaduan-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
        
        .form-body, .history-body {
            padding: 1.5rem;
        }
    }

    /* Custom Scrollbar */
    .history-body::-webkit-scrollbar {
        width: 6px;
    }

    .history-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .history-body::-webkit-scrollbar-thumb {
        background: var(--border-color);
        border-radius: 3px;
    }

    .history-body::-webkit-scrollbar-thumb:hover {
        background: var(--text-muted);
    }
</style>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set tanggal hari ini
        const dateEl = document.getElementById('currentDate');
        if (dateEl) {
            dateEl.textContent = new Date().toLocaleDateString('id-ID', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        const textarea = document.getElementById('isi');
        const charCount = document.getElementById('charCount');
        const form = document.getElementById('pengaduanForm');

        // Auto character count
        if (textarea && charCount) {
            textarea.addEventListener('input', () => {
                charCount.textContent = textarea.value.length;
            });

            // Initial count on page load
            charCount.textContent = textarea.value.length;
        }

        // Auto-resize textarea
        if (textarea) {
            const autoResize = () => {
                textarea.style.height = 'auto';
                textarea.style.height = Math.max(120, textarea.scrollHeight) + 'px';
            };

            textarea.addEventListener('input', autoResize);
            autoResize(); // trigger initial resize
        }

        // Submit button state
        if (form) {
            form.addEventListener('submit', function () {
                const submitBtn = form.querySelector('.btn-submit');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
                    submitBtn.disabled = true;
                }
            });
        }
    });
</script>
@endpush

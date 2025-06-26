@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid px-4">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="page-title mb-1">Dashboard Admin</h1>
            <p class="page-subtitle mb-0">Pantau pengaduan dan statistik PDAM</p>
        </div>
        <div class="dashboard-date">
            <i class="fas fa-calendar-alt me-2"></i>
            <span id="currentDate"></span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-5">
        <div class="col-xl-4 col-lg-6">
            <div class="stat-card stat-card-new">
                <div class="stat-card-body">
                    <div class="stat-content">
                        <div class="stat-icon">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div class="stat-details">
                            <h3 class="stat-number">{{ $baru }}</h3>
                            <p class="stat-label">Pengaduan Baru</p>
                            <div class="stat-badge">
                                <i class="fas fa-arrow-up me-1"></i>
                                Memerlukan Perhatian
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-6">
            <div class="stat-card stat-card-process">
                <div class="stat-card-body">
                    <div class="stat-content">
                        <div class="stat-icon">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <div class="stat-details">
                            <h3 class="stat-number">{{ $proses }}</h3>
                            <p class="stat-label">Sedang Diproses</p>
                            <div class="stat-badge">
                                <i class="fas fa-clock me-1"></i>
                                Dalam Penanganan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-lg-6">
            <div class="stat-card stat-card-done">
                <div class="stat-card-body">
                    <div class="stat-content">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-details">
                            <h3 class="stat-number">{{ $selesai }}</h3>
                            <p class="stat-label">Selesai</p>
                            <div class="stat-badge">
                                <i class="fas fa-check me-1"></i>
                                Terselesaikan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="row">
        <div class="col-12">
            <div class="chart-container">
                <div class="chart-header">
                    <div class="chart-title">
                        <h4 class="mb-1">Tren Pengaduan</h4>
                        <p class="chart-subtitle mb-0">Grafik perkembangan status pengaduan</p>
                    </div>
                    <div class="chart-controls">
                        <button class="btn btn-chart-filter active" data-period="all">Semua</button>
                        <button class="btn btn-chart-filter" data-period="month">Bulan Ini</button>
                        <button class="btn btn-chart-filter" data-period="week">Minggu Ini</button>
                    </div>
                </div>
                <div class="chart-body">
                    <canvas id="pengaduanChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Pengaduan Table Section -->
<div class="chart-container mt-5">
    <div class="chart-header">
        <div class="chart-title">
            <h4 class="mb-1 ">Daftar Pengaduan Terkini</h4>
            <p class="chart-subtitle mb-0">Lihat dan kelola pengaduan pelanggan</p>
        </div>
    </div>
    <div class="p-4">
        <div class="table-responsive">
            <table class="table align-center text-sm">
                <thead class="text-muted border-bottom">
                    <tr>
                        <th>Nama Pelapor</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengaduan as $item)
                    <tr>
                        <td class="fw-medium">{{ $item['nama'] ?? '-' }}</td>
                        <td>{{ $item['judul'] ?? '-' }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($item['isi'] ?? '-', 80) }}</td>
                        <td>
                            @php
                                $statusColor = [
                                    'baru' => 'secondary',
                                    'proses' => 'warning',
                                    'selesai' => 'success'
                                ];
                                $badgeColor = $statusColor[$item['status']] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $badgeColor }} px-3 py-2 rounded-pill text-capitalize">
                                {{ $item['status'] ?? 'baru' }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($item['created_at'])->format('d-m-Y') }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.pengaduan.updateStatus', $item['id']) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm rounded">
                                    <option value="baru" {{ $item['status'] === 'baru' ? 'selected' : '' }}>Baru</option>
                                    <option value="proses" {{ $item['status'] === 'proses' ? 'selected' : '' }}>Diproses</option>
                                    <option value="selesai" {{ $item['status'] === 'selesai' ? 'selected' : '' }}>Selesai</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Tidak ada data pengaduan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


</div>

<style>
    .form-select.form-select-sm.rounded {
        background-color: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
        box-shadow: none;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 140 140' fill='%2364774b' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M70 90L30 50h80L70 90z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 0.65rem auto;
    }

    .form-select.form-select-sm.rounded:hover {
        background-color: var(--light-blue);
        color: var(--primary-blue);
        border-color: var(--primary-blue);
    }

    .table {
        background-color: transparent !important;
    }

    .table thead,
    .table tbody,
    .table tr,
    .table td,
    .table th {
        background-color: transparent !important;
    }
    
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

    .stat-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        border-radius: 20px 20px 0 0;
    }

    .stat-card-new::before {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--soft-blue) 100%);
    }

    .stat-card-process::before {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .stat-card-done::before {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-card-body {
        padding: 2rem;
    }

    .stat-content {
        display: flex;
        align-items: flex-start;
        gap: 1.5rem;
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        flex-shrink: 0;
    }

    .stat-card-new .stat-icon {
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.1) 0%, rgba(59, 130, 246, 0.1) 100%);
        color: var(--primary-blue);
    }

    .stat-card-process .stat-icon {
        background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.1) 100%);
        color: #d97706;
    }

    .stat-card-done .stat-icon {
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.1) 100%);
        color: #059669;
    }

    .stat-details {
        flex: 1;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.75rem;
    }

    .stat-badge {
        background: rgba(0, 0, 0, 0.05);
        color: var(--text-muted);
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
    }

    .chart-container {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        overflow: hidden;
    }

    .chart-header {
        padding: 2rem 2rem 1rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 1px solid var(--border-color);
    }

    .chart-title h4 {
        color: var(--text-dark);
        font-weight: 700;
        font-size: 1.5rem;
    }

    .chart-subtitle {
        color: var(--text-muted);
        font-size: 0.95rem;
    }

    .chart-controls {
        display: flex;
        gap: 0.5rem;
    }

    .btn-chart-filter {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-muted);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .btn-chart-filter:hover {
        background: var(--light-blue);
        color: var(--primary-blue);
        border-color: var(--primary-blue);
    }

    .btn-chart-filter.active {
        background: var(--primary-blue);
        color: white;
        border-color: var(--primary-blue);
    }

    .chart-body {
        padding: 2rem;
        height: 400px;
    }

    #pengaduanChart {
        max-height: 100%;
    }

    @media (max-width: 768px) {
        .chart-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }
        
        .chart-controls {
            justify-content: center;
        }
        
        .stat-content {
            gap: 1rem;
        }
        
        .stat-number {
            font-size: 2rem;
        }
        
        .page-title {
            font-size: 1.5rem;
        }
    }
</style>
@endsection

@push('scripts')
<script>
    // Set current date
    document.getElementById('currentDate').textContent = new Date().toLocaleDateString('id-ID', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });

    // Chart configuration
    const ctx = document.getElementById('pengaduanChart').getContext('2d');
    
    // Current status data (no dummy data)
    const chartData = {
        labels: ['Baru', 'Proses', 'Selesai'],
        datasets: [{
            label: 'Jumlah Pengaduan',
            data: [{{ $baru }}, {{ $proses }}, {{ $selesai }}],
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: ['#2563eb', '#f59e0b', '#10b981'],
            pointBorderColor: '#ffffff',
            pointBorderWidth: 3,
            pointRadius: 8,
            pointHoverRadius: 12
        }]
    };

    const chart = new Chart(ctx, {
        type: 'line',
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                intersect: false,
                mode: 'index'
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    align: 'end',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '500'
                        }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(255, 255, 255, 0.95)',
                    titleColor: '#1e293b',
                    bodyColor: '#64748b',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    cornerRadius: 12,
                    padding: 12,
                    titleFont: {
                        size: 14,
                        weight: '600'
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        color: '#64748b'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)',
                        drawBorder: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        stepSize: 1,
                        font: {
                            size: 12,
                            weight: '500'
                        },
                        color: '#64748b',
                        padding: 10
                    }
                }
            }
        }
    });

    // Chart filter functionality
    document.querySelectorAll('.btn-chart-filter').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.btn-chart-filter').forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Here you can add logic to filter chart data based on the selected period
            // For now, it's just visual feedback
        });
    });
</script>
@endpush
@extends('layouts.admin')

@section('title', 'Dashboard Kelas')

@section('content')
<div class="row mb-4 animate-fade-in">
    <div class="col-12">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
            <div>
                <h2 class="fw-bold mb-1">Dashboard Kelas - {{ $kelas->nama_kelas ?? 'XI RPL 1' }}</h2>
                <p class="text-muted mb-0">Pemantauan data siswa dan kehadiran absensi harian secara langsung.</p>
            </div>
            <div class="bg-white px-3 py-2 rounded-4 border shadow-sm d-flex align-items-center gap-2">
                <div class="bg-primary-subtle text-primary p-2 rounded-3 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                    <i class="bi bi-calendar-event-fill fs-5"></i>
                </div>
                <div>
                    <small class="text-muted d-block" style="font-size: 11px; font-weight: 600; text-transform: uppercase;">Tanggal Hari Ini</small>
                    <span class="fw-bold text-dark" style="font-size: 14px;">{{ \Carbon\Carbon::parse($hariIni)->translatedFormat('l, d F Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-4 g-3 animate-fade-in">
    <!-- Total Siswa -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 p-3" style="border-left: 5px solid #4f46e5;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Total Siswa Kelas</span>
                    <h3 class="fw-extrabold mb-0">{{ $totalSiswa }}</h3>
                </div>
                <div class="stat-card-icon bg-primary shadow-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="mt-3 text-muted" style="font-size: 13px;">
                <span class="text-primary fw-bold"><i class="bi bi-gender-male"></i> {{ $siswaLaki }}</span> Laki-laki & 
                <span class="text-danger fw-bold"><i class="bi bi-gender-female"></i> {{ $siswaPerempuan }}</span> Perempuan
            </div>
        </div>
    </div>

    <!-- Sudah Absen -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 p-3" style="border-left: 5px solid #10b981;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Sudah Absen</span>
                    <h3 class="fw-extrabold mb-0">{{ $hadirHariIni + $sakitHariIni + $izinHariIni + $alpaHariIni }} <span class="fs-6 fw-normal text-muted">Siswa</span></h3>
                </div>
                <div class="stat-card-icon bg-success">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            <div class="mt-3 text-muted" style="font-size: 12px;">
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Hadir: {{ $hadirHariIni }}</span>
                <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill">Sakit: {{ $sakitHariIni }}</span>
                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill">Izin: {{ $izinHariIni }}</span>
            </div>
        </div>
    </div>

    <!-- Belum Absen -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 p-3" style="border-left: 5px solid #ef4444;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Belum Absen</span>
                    <h3 class="fw-extrabold mb-0 text-danger">{{ $belumAbsenHariIni }} <span class="fs-6 fw-normal text-muted">Siswa</span></h3>
                </div>
                <div class="stat-card-icon bg-danger">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                </div>
            </div>
            <div class="mt-3 text-muted" style="font-size: 13px;">
                @if($belumAbsenHariIni > 0)
                    <span class="text-danger fw-bold"><i class="bi bi-hourglass-split"></i> Menunggu absensi mandiri siswa</span>
                @else
                    <span class="text-success fw-bold"><i class="bi bi-check-all"></i> Semua siswa sudah terdata hari ini!</span>
                @endif
            </div>
        </div>
    </div>

    <!-- Persentase Kehadiran -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 p-3" style="border-left: 5px solid #f59e0b;">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold text-uppercase d-block mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Tingkat Kehadiran</span>
                    <h3 class="fw-extrabold mb-0 text-warning-emphasis">{{ $totalSiswa > 0 ? round(($hadirHariIni / $totalSiswa) * 100) : 0 }}%</h3>
                </div>
                <div class="stat-card-icon bg-warning">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
            </div>
            <div class="mt-3">
                <div class="progress rounded-pill" style="height: 6px;">
                    <div class="progress-bar bg-warning rounded-pill" role="progressbar" style="width: {{ $totalSiswa > 0 ? ($hadirHariIni / $totalSiswa) * 100 : 0 }}%" aria-valuenow="{{ $hadirHariIni }}" aria-valuemin="0" aria-valuemax="{{ $totalSiswa }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Section: All-In-One Control Panel -->
<div class="row animate-fade-in">
    <div class="col-12">
        <div class="card p-4">
            
            <!-- Tab Controls -->
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center border-bottom pb-3 mb-4 gap-3">
                <ul class="nav nav-pills gap-2" id="dashboardTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active px-4 py-2 rounded-3 fw-bold d-flex align-items-center gap-2" id="absensi-tab" data-bs-toggle="tab" data-bs-target="#absensi-pane" type="button" role="tab" aria-controls="absensi-pane" aria-selected="true">
                            <i class="bi bi-calendar-check-fill"></i>
                            Kehadiran Absensi Hari Ini
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link px-4 py-2 rounded-3 fw-bold d-flex align-items-center gap-2 text-secondary" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#siswa-pane" type="button" role="tab" aria-controls="siswa-pane" aria-selected="false">
                            <i class="bi bi-people-fill"></i>
                            Daftar & Profil Lengkap Siswa
                        </button>
                    </li>
                </ul>

                <!-- Dynamic Search Bar (shared/client side) -->
                <div class="search-box position-relative" style="max-width: 300px; width: 100%;">
                    <i class="bi bi-search position-absolute text-muted" style="top: 50%; left: 14px; transform: translateY(-50%);"></i>
                    <input type="text" id="dashboardSearch" class="form-control form-control-premium ps-5" placeholder="Cari nama atau NIS siswa...">
                </div>
            </div>

            <!-- Tab Contents -->
            <div class="tab-content" id="dashboardTabContent">
                
                <!-- PANE 1: Kehadiran Absensi Hari Ini -->
                <div class="tab-pane fade show active" id="absensi-pane" role="tabpanel" aria-labelledby="absensi-tab" tabindex="0">
                    
                    <!-- Quick Filters for Attendance -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <button class="btn btn-sm btn-outline-secondary px-3 py-2 rounded-3 active attendance-filter-btn" data-filter="all">Semua Siswa</button>
                        <button class="btn btn-sm btn-outline-success px-3 py-2 rounded-3 attendance-filter-btn" data-filter="Hadir">Hadir ({{ $hadirHariIni }})</button>
                        <button class="btn btn-sm btn-outline-danger px-3 py-2 rounded-3 attendance-filter-btn" data-filter="Sakit">Sakit ({{ $sakitHariIni }})</button>
                        <button class="btn btn-sm btn-outline-warning px-3 py-2 rounded-3 attendance-filter-btn" data-filter="Izin">Izin ({{ $izinHariIni }})</button>
                        <button class="btn btn-sm btn-outline-dark px-3 py-2 rounded-3 attendance-filter-btn" data-filter="Alpa">Alpa ({{ $alpaHariIni }})</button>
                        <button class="btn btn-sm btn-outline-danger px-3 py-2 rounded-3 attendance-filter-btn" data-filter="Belum Absen">Belum Absen ({{ $belumAbsenHariIni }})</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover table-premium align-middle" id="attendanceTable">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">NIS</th>
                                    <th>Nama Siswa</th>
                                    <th style="width: 120px;">Jenis Kelamin</th>
                                    <th style="width: 160px;">Status Kehadiran</th>
                                    <th style="width: 150px;">Waktu Absen</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswas as $siswa)
                                    @php
                                        $absen = $absensiHariIni->get($siswa->id);
                                        $statusClass = 'Belum Absen';
                                        if ($absen) {
                                            $statusClass = $absen->status;
                                        }
                                    @endphp
                                    <tr class="attendance-row" data-name="{{ strtolower($siswa->nama) }}" data-nis="{{ $siswa->nis }}" data-status="{{ $statusClass }}">
                                        <td class="fw-semibold text-muted">{{ $siswa->nis }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 36px; height: 36px; font-size: 13px;">
                                                    {{ substr($siswa->nama, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="fw-bold d-block text-dark">{{ $siswa->nama }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($siswa->jenis_kelamin === 'Laki-laki')
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-3" style="font-size: 11.5px;">Laki-laki</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-3" style="font-size: 11.5px;">Perempuan</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($absen)
                                                @if($absen->status === 'Hadir')
                                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-3 fw-semibold"><i class="bi bi-check-circle-fill me-1"></i> Hadir</span>
                                                @elseif($absen->status === 'Sakit')
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-3 fw-semibold"><i class="bi bi-heart-pulse-fill me-1"></i> Sakit</span>
                                                @elseif($absen->status === 'Izin')
                                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-3 fw-semibold"><i class="bi bi-envelope-open-fill me-1"></i> Izin</span>
                                                @else
                                                    <span class="badge bg-dark-subtle text-dark border border-dark-subtle px-3 py-2 rounded-3 fw-semibold"><i class="bi bi-x-circle-fill me-1"></i> Alpa</span>
                                                @endif
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-2 rounded-3 fw-semibold" style="border-style: dashed !important;"><i class="bi bi-hourglass me-1"></i> Belum Absen</span>
                                            @endif
                                        </td>
                                        <td class="text-muted">
                                            @if($absen)
                                                <i class="bi bi-clock me-1" style="font-size: 13px;"></i> {{ $absen->created_at->format('H:i') }} WIB
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($absen && $absen->keterangan)
                                                <span class="text-dark bg-light px-2 py-1 rounded-3 border" style="font-size: 13px;"><i class="bi bi-chat-left-text text-muted me-2"></i>{{ $absen->keterangan }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="no-results-row">
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class="bi bi-people-fill fs-1 d-block mb-3 text-muted opacity-40"></i>
                                            Belum ada data siswa terdaftar di kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                                <tr id="noAttendanceMatch" style="display: none;">
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="bi bi-search fs-1 d-block mb-3 text-muted opacity-40"></i>
                                        Siswa yang Anda cari tidak ditemukan.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- PANE 2: Daftar & Profil Lengkap Siswa -->
                <div class="tab-pane fade" id="siswa-pane" role="tabpanel" aria-labelledby="siswa-tab" tabindex="0">
                    <div class="table-responsive">
                        <table class="table table-hover table-premium align-middle" id="studentDatabaseTable">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">NIS</th>
                                    <th>Nama Lengkap</th>
                                    <th style="width: 150px;">Jenis Kelamin</th>
                                    <th>Alamat Lengkap</th>
                                    <th style="width: 180px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($siswas as $siswa)
                                    <tr class="siswa-row" data-name="{{ strtolower($siswa->nama) }}" data-nis="{{ $siswa->nis }}">
                                        <td class="fw-bold text-indigo">{{ $siswa->nis }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="bg-primary-subtle text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 38px; height: 38px; font-size: 13.5px;">
                                                    {{ substr($siswa->nama, 0, 1) }}
                                                </div>
                                                <div>
                                                    <span class="fw-bold d-block text-dark">{{ $siswa->nama }}</span>
                                                    <small class="text-muted">Kelas: {{ $kelas->nama_kelas ?? 'XI RPL 1' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($siswa->jenis_kelamin === 'Laki-laki')
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-3" style="font-size: 11.5px;"><i class="bi bi-gender-male me-1"></i> Laki-laki</span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1 rounded-3" style="font-size: 11.5px;"><i class="bi bi-gender-female me-1"></i> Perempuan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-dark-emphasis" style="font-size: 13.5px;"><i class="bi bi-geo-alt-fill text-muted me-1"></i>{{ $siswa->alamat ?? 'Surabaya' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-3 d-inline-flex align-items-center gap-2">
                                                    <i class="bi bi-eye"></i> Detail Profil
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="no-results-row">
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="bi bi-people-fill fs-1 d-block mb-3 text-muted opacity-40"></i>
                                            Belum ada data siswa terdaftar di kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                                <tr id="noStudentMatch" style="display: none;">
                                    <td colspan="5" class="text-center py-5 text-muted">
                                        <i class="bi bi-search fs-1 d-block mb-3 text-muted opacity-40"></i>
                                        Siswa yang Anda cari tidak ditemukan.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('dashboardSearch');
    const filterBtns = document.querySelectorAll('.attendance-filter-btn');
    let activeFilter = 'all';

    // Gabungan fungsi pencarian dan filter instan
    function applyFilters() {
        const query = searchInput.value.toLowerCase().trim();

        // 1. Filter Tabel Absensi
        let absMatch = 0;
        document.querySelectorAll('.attendance-row').forEach(row => {
            const matchQuery = row.dataset.name.includes(query) || row.dataset.nis.includes(query);
            const matchFilter = activeFilter === 'all' || row.dataset.status === activeFilter;
            
            const visible = matchQuery && matchFilter;
            row.style.display = visible ? '' : 'none';
            if (visible) absMatch++;
        });
        document.getElementById('noAttendanceMatch').style.display = (absMatch === 0) ? '' : 'none';

        // 2. Filter Tabel Database Siswa
        let sisMatch = 0;
        document.querySelectorAll('.siswa-row').forEach(row => {
            const visible = row.dataset.name.includes(query) || row.dataset.nis.includes(query);
            row.style.display = visible ? '' : 'none';
            if (visible) sisMatch++;
        });
        document.getElementById('noStudentMatch').style.display = (sisMatch === 0) ? '' : 'none';
    }

    searchInput.addEventListener('input', applyFilters);

    filterBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            activeFilter = this.getAttribute('data-filter');
            applyFilters();
        });
    });

    // Pengaturan transisi warna teks Tab Bootstrap
    const tabs = [document.getElementById('siswa-tab'), document.getElementById('absensi-tab')];
    tabs.forEach(tab => {
        tab?.addEventListener('shown.bs.tab', () => {
            tabs.forEach(t => t?.classList.add('text-secondary'));
            tab.classList.remove('text-secondary');
        });
    });
});
</script>
@endsection

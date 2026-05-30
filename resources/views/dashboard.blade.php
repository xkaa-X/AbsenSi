@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold mb-1">Dashboard Guru</h2>
        <p class="text-muted">Selamat datang di sistem manajemen kesiswaan & absensi sekolah.</p>
    </div>
</div>

<!-- Statistik Cards -->
<div class="row mb-4 g-3">
    <!-- Total Siswa -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold text-uppercase d-block mb-1" style="font-size: 12px; letter-spacing: 0.5px;">Total Siswa</span>
                    <h3 class="fw-extrabold mb-0">{{ $totalSiswa }}</h3>
                </div>
                <div class="stat-card-icon bg-primary shadow-primary">
                    <i class="bi bi-people-fill"></i>
                </div>
            </div>
            <div class="mt-3 text-muted" style="font-size: 13.5px;">
                <span class="text-success fw-bold"><i class="bi bi-arrow-up"></i> {{ $siswaLaki }}</span> Laki-laki & 
                <span class="text-danger fw-bold">{{ $siswaPerempuan }}</span> Perempuan
            </div>
        </div>
    </div>

    <!-- Total Kelas -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold text-uppercase d-block mb-1" style="font-size: 12px; letter-spacing: 0.5px;">Total Kelas</span>
                    <h3 class="fw-extrabold mb-0">{{ $totalKelas }}</h3>
                </div>
                <div class="stat-card-icon bg-success">
                    <i class="bi bi-building-fill"></i>
                </div>
            </div>
            <div class="mt-3 text-muted" style="font-size: 13.5px;">
                Terbagi dalam beberapa tingkat kelas
            </div>
        </div>
    </div>

    <!-- Total Jurusan -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold text-uppercase d-block mb-1" style="font-size: 12px; letter-spacing: 0.5px;">Total Jurusan</span>
                    <h3 class="fw-extrabold mb-0">{{ $totalJurusan }}</h3>
                </div>
                <div class="stat-card-icon bg-info">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
            </div>
            <div class="mt-3 text-muted" style="font-size: 13.5px;">
                Bidang keahlian Rekayasa Perangkat Lunak (RPL)
            </div>
        </div>
    </div>

    <!-- Kehadiran Hari Ini -->
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="card h-100 p-3">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <span class="text-muted fw-semibold text-uppercase d-block mb-1" style="font-size: 12px; letter-spacing: 0.5px;">Absensi Hari Ini</span>
                    <h3 class="fw-extrabold mb-0">{{ $hadirHariIni }} <span class="fs-6 fw-normal text-muted">Hadir</span></h3>
                </div>
                <div class="stat-card-icon bg-warning">
                    <i class="bi bi-calendar-check"></i>
                </div>
            </div>
            <div class="mt-3 text-muted" style="font-size: 12.5px;">
                <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill">Sakit: {{ $sakitHariIni }}</span>
                <span class="badge bg-warning bg-opacity-10 text-warning-emphasis rounded-pill">Izin: {{ $izinHariIni }}</span>
                <span class="badge bg-dark bg-opacity-10 text-dark rounded-pill">Alpa: {{ $alpaHariIni }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Grafik dan Informasi Tambahan -->
<div class="row mb-4 g-4">
    <!-- Visual Gender & shortcut -->
    <div class="col-12 col-lg-4">
        <div class="card h-100 p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-pie-chart-fill text-indigo me-2"></i>Distribusi Siswa</h5>
            <hr class="text-muted opacity-25">
            
            <div class="my-4 text-center">
                <div class="d-inline-flex align-items-center gap-3">
                    <div class="text-center p-3 rounded-4 bg-light" style="width: 100px;">
                        <i class="bi bi-gender-male text-primary fs-2"></i>
                        <div class="fw-bold fs-5 mt-1">{{ $totalSiswa > 0 ? round(($siswaLaki/$totalSiswa)*100) : 0 }}%</div>
                        <small class="text-muted">Laki-laki</small>
                    </div>
                    <div class="text-center p-3 rounded-4 bg-light" style="width: 100px;">
                        <i class="bi bi-gender-female text-danger fs-2"></i>
                        <div class="fw-bold fs-5 mt-1">{{ $totalSiswa > 0 ? round(($siswaPerempuan/$totalSiswa)*100) : 0 }}%</div>
                        <small class="text-muted">Perempuan</small>
                    </div>
                </div>
            </div>

            <h6 class="fw-semibold mt-3 mb-2">Akses Cepat:</h6>
            <div class="d-grid gap-2">
                <a href="{{ route('siswa.create') }}" class="btn btn-outline-primary text-start rounded-3 py-2">
                    <i class="bi bi-person-plus-fill me-2"></i> Tambah Siswa Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Absensi Siswa Terbaru -->
    <div class="col-12 col-lg-8">
        <div class="card h-100 p-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-clock-history text-warning me-2"></i>Catatan Absensi Terbaru</h5>
                <a href="{{ route('absensi.index') }}" class="btn btn-link text-decoration-none fw-semibold p-0">Lihat Semua</a>
            </div>
            <hr class="text-muted opacity-25">
            
            <div class="table-responsive">
                <table class="table table-hover table-premium">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Tanggal</th>
                            <th>Status Kehadiran</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensiTerbaru as $absen)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="bg-light p-2 rounded-3 text-center d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                            <i class="bi bi-person text-primary"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold d-block text-truncate" style="max-width: 140px;">{{ $absen->siswa->nama }}</span>
                                            <small class="text-muted">{{ $absen->siswa->kelas->nama_kelas }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($absen->tanggal_absen)->translatedFormat('d M Y') }}</td>
                                <td>
                                    @if($absen->status == 'Hadir')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-3">Hadir</span>
                                    @elseif($absen->status == 'Sakit')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-3">Sakit</span>
                                    @elseif($absen->status == 'Izin')
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-3">Izin</span>
                                    @else
                                        <span class="badge bg-dark-subtle text-dark border border-dark-subtle px-3 py-2 rounded-3">Alpa</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark border p-2 rounded-3">{{ $absen->keterangan ?? '-' }}</span></td>
                                <td>
                                    <a href="{{ route('siswa.show', $absen->siswa_id) }}" class="btn btn-sm btn-outline-primary rounded-3">
                                        <i class="bi bi-eye"></i> Profil
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-calendar2-x fs-2 d-block mb-2 text-muted opacity-50"></i>
                                    Belum ada catatan absensi terbaru.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

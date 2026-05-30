@extends('layouts.admin')

@section('title', 'Profil Siswa')

@section('content')
<div class="mb-4">
    <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
        <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Kembali
    </a>
</div>

<div class="row g-4">
    <!-- Left Column: Student Information -->
    <div class="col-12 col-lg-5">
        <div class="card p-4 h-100">
            <div class="text-center mb-4">
                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center fw-bold shadow-sm mb-3" 
                     style="width: 80px; height: 80px; font-size: 32px;">
                    {{ substr($siswa->nama, 0, 1) }}
                </div>
                <h4 class="fw-bold mb-1">{{ $siswa->nama }}</h4>
                <p class="text-muted mb-0">NIS: <strong class="text-dark">{{ $siswa->nis }}</strong></p>
                <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 mt-2 rounded-3">
                    <i class="bi bi-building"></i> {{ $siswa->kelas->nama_kelas }}
                </span>
            </div>
            
            <hr class="text-muted opacity-25">
            
            <div class="mt-2">
                <h6 class="fw-bold text-uppercase text-muted mb-3" style="font-size: 12px; letter-spacing: 0.5px;">Rincian Data Profil:</h6>
                
                <div class="mb-3">
                    <small class="text-muted d-block">Program Keahlian (Jurusan):</small>
                    <span class="fw-semibold text-dark">{{ $siswa->kelas->jurusan->nama_jurusan }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Jenis Kelamin:</small>
                    <span class="fw-semibold text-dark">
                        <i class="bi {{ $siswa->jenis_kelamin == 'Laki-laki' ? 'bi-gender-male text-primary' : 'bi-gender-female text-danger' }} me-1"></i>
                        {{ $siswa->jenis_kelamin }}
                    </span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Alamat Lengkap:</small>
                    <span class="fw-semibold text-dark">{{ $siswa->alamat }}</span>
                </div>

                <div class="mb-3">
                    <small class="text-muted d-block">Terdaftar Pada:</small>
                    <span class="fw-semibold text-muted">{{ $siswa->created_at->translatedFormat('d F Y, H:i') }}</span>
                </div>
            </div>

            <div class="d-grid gap-2 mt-5">
                <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-outline-warning rounded-3">
                    <i class="bi bi-pencil-square me-1"></i> Edit Profil Siswa
                </a>
            </div>
        </div>
    </div>

    <!-- Right Column: Attendance History -->
    <div class="col-12 col-lg-7">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-clock-history text-warning me-2"></i>Riwayat Absensi Siswa
                </h5>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-3">
                    Total: {{ $siswa->absensis->count() }} Transaksi
                </span>
            </div>
            <hr class="text-muted opacity-25">

            <div class="table-responsive">
                <table class="table table-hover table-premium">
                    <thead>
                        <tr>
                            <th>Tanggal Absen</th>
                            <th>Status Kehadiran</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswa->absensis as $absensi)
                            <tr>
                                <td class="fw-semibold text-dark">
                                    {{ \Carbon\Carbon::parse($absensi->tanggal_absen)->translatedFormat('d F Y') }}
                                </td>
                                <td>
                                    @if($absensi->status == 'Hadir')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-3">Hadir</span>
                                    @elseif($absensi->status == 'Sakit')
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2 rounded-3">Sakit</span>
                                    @elseif($absensi->status == 'Izin')
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-3">Izin</span>
                                    @else
                                        <span class="badge bg-dark-subtle text-dark border border-dark-subtle px-3 py-2 rounded-3">Alpa</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border p-2 rounded-3">
                                        {{ $absensi->keterangan ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar2-x fs-1 d-block mb-2 text-muted opacity-50"></i>
                                    Siswa ini belum memiliki catatan riwayat absensi.
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

@extends('layouts.admin')

@section('title', 'Dashboard Siswa')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold mb-1">Dashboard Mandiri Siswa</h2>
        <p class="text-muted">Selamat datang, Anda login sebagai siswa. Silakan lakukan absensi harian secara mandiri.</p>
    </div>
</div>

<div class="row g-4">
    <!-- Left Column: Student Info & Clock In Form -->
    <div class="col-12 col-lg-5">
        <!-- Student Profile Card -->
        <div class="card p-4 mb-4">
            <div class="text-center mb-4">
                <div class="bg-indigo-500 bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center fw-bold shadow-sm mb-3" 
                     style="width: 80px; height: 80px; font-size: 32px; background-color: #eef2ff;">
                    {{ substr($siswa->nama, 0, 1) }}
                </div>
                <h4 class="fw-bold mb-1 text-dark">{{ $siswa->nama }}</h4>
                <p class="text-muted mb-0">NIS: <strong class="text-dark">{{ $siswa->nis }}</strong></p>
                <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 mt-2 rounded-3">
                    <i class="bi bi-building"></i> {{ $siswa->kelas->nama_kelas }}
                </span>
            </div>
            
            <hr class="text-muted opacity-25">
            
            <div class="mt-2">
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
                    <small class="text-muted d-block">Alamat:</small>
                    <span class="fw-semibold text-dark">{{ $siswa->alamat }}</span>
                </div>
            </div>
        </div>

        <!-- Attendance Clock In Form -->
        <div class="card p-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-calendar2-check text-primary me-2"></i>Absensi Hari Ini</h5>
            <hr class="text-muted opacity-25">

            @if($todayAbsen)
                <div class="text-center py-4">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center fw-bold mb-3" 
                         style="width: 60px; height: 60px; font-size: 24px;">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <h5 class="fw-bold text-success">Sudah Absen Hari Ini</h5>
                    <p class="text-muted mb-3">Absensi Anda untuk hari ini telah berhasil terekam di sistem.</p>
                    
                    <div class="p-3 bg-light rounded-4 border text-start">
                        <div class="mb-2">
                            <small class="text-muted d-block">Waktu Absen:</small>
                            <span class="fw-semibold text-dark">{{ $todayAbsen->created_at->translatedFormat('H:i') }} WIB</span>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted d-block">Status Kehadiran:</small>
                            @if($todayAbsen->status == 'Hadir')
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-3">Hadir</span>
                            @elseif($todayAbsen->status == 'Sakit')
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1 rounded-3">Sakit</span>
                            @else
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-1 rounded-3">Izin</span>
                            @endif
                        </div>
                        <div>
                            <small class="text-muted d-block">Keterangan:</small>
                            <span class="fw-medium text-dark">{{ $todayAbsen->keterangan ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            @else
                <form action="{{ route('siswa.absen.proses') }}" method="POST">
                    @csrf
                    
                    <!-- Status Kehadiran Radio Buttons -->
                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Pilih Kehadiran <span class="text-danger">*</span></label>
                        
                        <div class="row g-2">
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="status" id="hadir_btn" value="Hadir" checked required>
                                <label class="btn btn-outline-success w-100 rounded-3 py-2" for="hadir_btn">
                                    <i class="bi bi-check-circle d-block mb-1"></i> Hadir
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="status" id="sakit_btn" value="Sakit" required>
                                <label class="btn btn-outline-danger w-100 rounded-3 py-2" for="sakit_btn">
                                    <i class="bi bi-heart-pulse d-block mb-1"></i> Sakit
                                </label>
                            </div>
                            <div class="col-4">
                                <input type="radio" class="btn-check" name="status" id="izin_btn" value="Izin" required>
                                <label class="btn btn-outline-warning w-100 rounded-3 py-2" for="izin_btn">
                                    <i class="bi bi-envelope-open d-block mb-1"></i> Izin
                                </label>
                            </div>
                        </div>
                        
                        @error('status')
                            <div class="invalid-feedback d-block fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keterangan Textarea -->
                    <div class="mb-4">
                        <label for="keterangan" class="form-label fw-bold">Keterangan / Alasan</label>
                        <textarea class="form-control form-control-premium @error('keterangan') is-invalid @enderror" 
                                  id="keterangan" name="keterangan" rows="2" 
                                  placeholder="Contoh: Surat dokter dilampirkan, Keperluan keluarga..."></textarea>
                        @error('keterangan')
                            <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-premium-primary w-100 py-2.5">
                        <i class="bi bi-send me-1"></i> Kirim Absensi Hari Ini
                    </button>
                </form>
            @endif
        </div>
    </div>

    <!-- Right Column: Personal Attendance History -->
    <div class="col-12 col-lg-7">
        <div class="card p-4 h-100">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-clock-history text-warning me-2"></i>Riwayat Kehadiran Anda
                </h5>
                <span class="badge bg-light text-dark border px-3 py-2 rounded-3">
                    Total: {{ $absensis->count() }} Kali Hadir / Izin
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
                        @forelse($absensis as $absen)
                            <tr>
                                <td class="fw-semibold text-dark">
                                    {{ \Carbon\Carbon::parse($absen->tanggal_absen)->translatedFormat('d F Y') }}
                                </td>
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
                                <td>
                                    <span class="badge bg-light text-dark border p-2 rounded-3">
                                        {{ $absen->keterangan ?? '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-calendar2-x fs-1 d-block mb-2 text-muted opacity-50"></i>
                                    Anda belum memiliki riwayat absensi.
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

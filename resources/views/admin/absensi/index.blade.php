@extends('layouts.admin')

@section('title', 'Data Absensi Hari Ini')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1">Absensi Hari Ini</h2>
        <p class="text-muted mb-0">Daftar kehadiran siswa yang mencatat absensi mandiri pada hari ini.</p>
    </div>
</div>

<div class="card p-4">
    <!-- Search Bar -->
    <div class="row mb-3 justify-content-end">
        <div class="col-12 col-md-5 col-lg-4">
            <form action="{{ route('absensi.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-premium" 
                           placeholder="Cari siswa, NIS, atau status..." value="{{ $search }}">
                    <button class="btn btn-primary px-3 rounded-end-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                        <a href="{{ route('absensi.index') }}" class="btn btn-outline-secondary px-3 d-flex align-items-center">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-hover table-premium">
            <thead>
                <tr>
                    <th style="width: 80px;">No</th>
                    <th>Siswa</th>
                    <th>Tanggal Absen</th>
                    <th>Status Kehadiran</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensis as $index => $absen)
                    <tr>
                        <td>{{ $absensis->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light p-2 rounded-3 text-center d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                                    <i class="bi bi-person text-primary"></i>
                                </div>
                                <div>
                                    <a href="{{ route('siswa.show', $absen->siswa_id) }}" class="fw-bold d-block text-dark text-decoration-none hover-indigo">
                                        {{ $absen->siswa->nama }}
                                    </a>
                                    <small class="text-muted">{{ $absen->siswa->nis }} — {{ $absen->siswa->kelas->nama_kelas }}</small>
                                </div>
                            </div>
                        </td>
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
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-calendar2-x fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Tidak ada data absensi ditemukan untuk hari ini.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="text-muted" style="font-size: 14px;">
            Menampilkan {{ $absensis->firstItem() ?? 0 }} sampai {{ $absensis->lastItem() ?? 0 }} dari {{ $absensis->total() }} data
        </span>
        <div>
            {{ $absensis->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

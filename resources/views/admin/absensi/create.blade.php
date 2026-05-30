@extends('layouts.admin')

@section('title', 'Catat Absensi')

@section('content')
<div class="mb-4">
    @if($selectedSiswaId)
        <a href="{{ route('siswa.show', $selectedSiswaId) }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Kembali ke Profil
        </a>
    @else
        <a href="{{ route('absensi.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
            <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Kembali
        </a>
    @endif
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">
        <div class="card p-4">
            <h4 class="fw-bold mb-1">Catat Absensi Baru</h4>
            <p class="text-muted">Masukkan detail transaksi kehadiran harian siswa.</p>
            <hr class="text-muted opacity-25 mb-4">

            <form action="{{ route('absensi.store') }}" method="POST">
                @csrf
                
                @if($selectedSiswaId)
                    <!-- Hidden field to redirect back to student profile page on success -->
                    <input type="hidden" name="redirect_to_siswa" value="true">
                @endif

                <!-- Siswa Select Dropdown -->
                <div class="mb-3">
                    <label for="siswa_id" class="form-label fw-bold">Siswa <span class="text-danger">*</span></label>
                    <select class="form-select form-select-premium @error('siswa_id') is-invalid @enderror" 
                            id="siswa_id" name="siswa_id" required {{ $selectedSiswaId ? 'style=pointer-events:none;background-color:#f1f5f9;' : '' }}>
                        <option value="" disabled selected>-- Pilih Siswa --</option>
                        @foreach($siswas as $siswa)
                            <option value="{{ $siswa->id }}" 
                                    {{ (old('siswa_id') == $siswa->id || $selectedSiswaId == $siswa->id) ? 'selected' : '' }}>
                                {{ $siswa->nama }} ({{ $siswa->nis }}) — {{ $siswa->kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    @if($selectedSiswaId)
                        <!-- Keep input values secure -->
                        <input type="hidden" name="siswa_id" value="{{ $selectedSiswaId }}">
                    @endif
                    @error('siswa_id')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Absen Input -->
                <div class="mb-3">
                    <label for="tanggal_absen" class="form-label fw-bold">Tanggal Absensi <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-premium @error('tanggal_absen') is-invalid @enderror" 
                           id="tanggal_absen" name="tanggal_absen" 
                           value="{{ old('tanggal_absen', \Carbon\Carbon::now()->format('Y-m-d')) }}" required>
                    @error('tanggal_absen')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Kehadiran Radio/Select -->
                <div class="mb-3">
                    <label class="form-label fw-bold d-block">Status Kehadiran <span class="text-danger">*</span></label>
                    <div class="form-check form-check-inline mt-1">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" 
                               name="status" id="status_hadir" value="Hadir" 
                               {{ old('status', 'Hadir') == 'Hadir' ? 'checked' : '' }} required>
                        <label class="form-check-label fw-medium text-success" for="status_hadir">Hadir</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" 
                               name="status" id="status_sakit" value="Sakit" 
                               {{ old('status') == 'Sakit' ? 'checked' : '' }} required>
                        <label class="form-check-label fw-medium text-danger" for="status_sakit">Sakit</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" 
                               name="status" id="status_izin" value="Izin" 
                               {{ old('status') == 'Izin' ? 'checked' : '' }} required>
                        <label class="form-check-label fw-medium text-warning" for="status_izin">Izin</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('status') is-invalid @enderror" type="radio" 
                               name="status" id="status_alpa" value="Alpa" 
                               {{ old('status') == 'Alpa' ? 'checked' : '' }} required>
                        <label class="form-check-label fw-medium text-dark" for="status_alpa">Alpa</label>
                    </div>
                    @error('status')
                        <div class="invalid-feedback d-block fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Keterangan Input -->
                <div class="mb-4">
                    <label for="keterangan" class="form-label fw-bold">Keterangan / Alasan</label>
                    <input type="text" class="form-control form-control-premium @error('keterangan') is-invalid @enderror" 
                           id="keterangan" name="keterangan" value="{{ old('keterangan') }}" 
                           placeholder="Contoh: Sakit flu, Izin acara keluarga, Masuk tepat waktu">
                    <div class="form-text text-muted">Bisa diisi dengan alasan izin/sakit atau catatan tambahan kehadiran.</div>
                    @error('keterangan')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-5">
                    @if($selectedSiswaId)
                        <a href="{{ route('siswa.show', $selectedSiswaId) }}" class="btn btn-light rounded-3 px-4">Batal</a>
                    @else
                        <a href="{{ route('absensi.index') }}" class="btn btn-light rounded-3 px-4">Batal</a>
                    @endif
                    <button type="submit" class="btn btn-premium-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

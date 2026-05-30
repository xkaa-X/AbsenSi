@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')
<div class="mb-4">
    <a href="{{ route('kelas.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
        <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">
        <div class="card p-4">
            <h4 class="fw-bold mb-1">Perbarui Kelas</h4>
            <p class="text-muted">Ubah rincian informasi untuk memperbarui data kelas.</p>
            <hr class="text-muted opacity-25 mb-4">

            <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Nama Kelas Input -->
                <div class="mb-3">
                    <label for="nama_kelas" class="form-label fw-bold">Nama Kelas <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-premium @error('nama_kelas') is-invalid @enderror" 
                           id="nama_kelas" name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" 
                           placeholder="Contoh: XII RPL 1" required>
                    <div class="form-text text-muted">Pastikan menggunakan format standar (Angka Romawi - Singkatan Jurusan - Nomor Rombel).</div>
                    @error('nama_kelas')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jurusan Select Dropdown -->
                <div class="mb-4">
                    <label for="jurusan_id" class="form-label fw-bold">Jurusan <span class="text-danger">*</span></label>
                    <select class="form-select form-select-premium @error('jurusan_id') is-invalid @enderror" 
                            id="jurusan_id" name="jurusan_id" required>
                        <option value="" disabled>-- Pilih Jurusan --</option>
                        @foreach($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" {{ old('jurusan_id', $kelas->jurusan_id) == $jurusan->id ? 'selected' : '' }}>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                    @error('jurusan_id')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-5">
                    <a href="{{ route('kelas.index') }}" class="btn btn-light rounded-3 px-4">Batal</a>
                    <button type="submit" class="btn btn-premium-primary px-4">
                        <i class="bi bi-check2-all me-1"></i> Perbarui Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

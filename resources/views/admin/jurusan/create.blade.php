@extends('layouts.admin')

@section('title', 'Tambah Jurusan')

@section('content')
<div class="mb-4">
    <a href="{{ route('jurusan.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
        <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">
        <div class="card p-4">
            <h4 class="fw-bold mb-1">Tambah Jurusan Baru</h4>
            <p class="text-muted">Masukkan rincian informasi untuk menambahkan jurusan baru.</p>
            <hr class="text-muted opacity-25 mb-4">

            <form action="{{ route('jurusan.store') }}" method="POST">
                @csrf
                
                <!-- Nama Jurusan Input -->
                <div class="mb-4">
                    <label for="nama_jurusan" class="form-label fw-bold">Nama Jurusan <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-premium @error('nama_jurusan') is-invalid @enderror" 
                           id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan') }}" 
                           placeholder="Contoh: Rekayasa Perangkat Lunak (RPL)" required>
                    <div class="form-text text-muted">Pastikan nama jurusan lengkap beserta singkatannya di dalam kurung.</div>
                    @error('nama_jurusan')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-5">
                    <a href="{{ route('jurusan.index') }}" class="btn btn-light rounded-3 px-4">Batal</a>
                    <button type="submit" class="btn btn-premium-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Jurusan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

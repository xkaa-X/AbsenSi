@extends('layouts.admin')

@section('title', 'Tambah Siswa')

@section('content')
<div class="mb-4">
    <a href="{{ route('siswa.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3">
        <i class="bi bi-arrow-left-short fs-5 align-middle"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8 col-xl-7">
        <div class="card p-4">
            <h4 class="fw-bold mb-1">Tambah Siswa Baru</h4>
            <p class="text-muted">Masukkan rincian profil lengkap untuk mendaftarkan siswa baru.</p>
            <hr class="text-muted opacity-25 mb-4">

            <form action="{{ route('siswa.store') }}" method="POST">
                @csrf
                
                <!-- NIS Input -->
                <div class="mb-3">
                    <label for="nis" class="form-label fw-bold">Nomor Induk Siswa (NIS) <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-premium @error('nis') is-invalid @enderror" 
                           id="nis" name="nis" value="{{ old('nis') }}" 
                           placeholder="Contoh: 12003" required>
                    <div class="form-text text-muted">NIS harus unik dan hanya berupa angka.</div>
                    @error('nis')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nama Lengkap Input -->
                <div class="mb-3">
                    <label for="nama" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-premium @error('nama') is-invalid @enderror" 
                           id="nama" name="nama" value="{{ old('nama') }}" 
                           placeholder="Contoh: Arvinda Pratama" required>
                    @error('nama')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Jenis Kelamin Radio Buttons -->
                <div class="mb-3">
                    <label class="form-label fw-bold d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                    <div class="form-check form-check-inline mt-1">
                        <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" 
                               name="jenis_kelamin" id="jk_l" value="Laki-laki" 
                               {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }} required>
                        <label class="form-check-label fw-medium" for="jk_l">Laki-laki</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" 
                               name="jenis_kelamin" id="jk_p" value="Perempuan" 
                               {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }} required>
                        <label class="form-check-label fw-medium" for="jk_p">Perempuan</label>
                    </div>
                    @error('jenis_kelamin')
                        <div class="invalid-feedback d-block fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kelas Select Dropdown -->
                <div class="mb-3">
                    <label for="kelas_id" class="form-label fw-bold">Kelas & Jurusan <span class="text-danger">*</span></label>
                    <select class="form-select form-select-premium @error('kelas_id') is-invalid @enderror" 
                            id="kelas_id" name="kelas_id" required>
                        <option value="" disabled selected>-- Pilih Kelas --</option>
                        @foreach($kelas as $k)
                            <option value="{{ $k->id }}" {{ old('kelas_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kelas }} — {{ $k->jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                    @error('kelas_id')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Alamat Textarea -->
                <div class="mb-4">
                    <label for="alamat" class="form-label fw-bold">Alamat Lengkap <span class="text-danger">*</span></label>
                    <textarea class="form-control form-control-premium @error('alamat') is-invalid @enderror" 
                              id="alamat" name="alamat" rows="3" 
                              placeholder="Contoh: Jl. Kebon Jeruk No. 12, Jakarta" required>{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-5">
                    <a href="{{ route('siswa.index') }}" class="btn btn-light rounded-3 px-4">Batal</a>
                    <button type="submit" class="btn btn-premium-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

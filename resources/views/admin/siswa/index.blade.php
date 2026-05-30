@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1">Data Siswa</h2>
        <p class="text-muted mb-0">Kelola informasi profil siswa terdaftar.</p>
    </div>
    <div>
        <a href="{{ route('siswa.create') }}" class="btn btn-premium-primary">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Siswa
        </a>
    </div>
</div>

<div class="card p-4">
    <!-- Search Bar -->
    <div class="row mb-3 justify-content-end">
        <div class="col-12 col-md-5 col-lg-4">
            <form action="{{ route('siswa.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-premium" 
                           placeholder="Cari NIS, nama, atau alamat..." value="{{ $search }}">
                    <button class="btn btn-primary px-3 rounded-end-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                        <a href="{{ route('siswa.index') }}" class="btn btn-outline-secondary px-3 d-flex align-items-center">
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
                    <th>NIS</th>
                    <th>Nama Lengkap</th>
                    <th>Kelas</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th style="width: 260px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                    <tr>
                        <td class="fw-bold text-indigo-700">{{ $siswa->nis }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $siswa->nama }}</div>
                        </td>
                        <td>
                            <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-3" 
                                  title="{{ $siswa->kelas->jurusan->nama_jurusan }}">
                                <i class="bi bi-building me-1"></i> {{ $siswa->kelas->nama_kelas }}
                            </span>
                        </td>
                        <td>
                            @if($siswa->jenis_kelamin == 'Laki-laki')
                                <span class="badge bg-blue-50 text-primary border border-primary-subtle px-3 py-2 rounded-3">
                                    <i class="bi bi-gender-male me-1"></i> Laki-laki
                                </span>
                            @else
                                <span class="badge bg-pink-50 text-danger border border-danger-subtle px-3 py-2 rounded-3">
                                    <i class="bi bi-gender-female me-1"></i> Perempuan
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted text-truncate d-inline-block" style="max-width: 200px;">
                                {{ $siswa->alamat }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('siswa.show', $siswa->id) }}" class="btn btn-sm btn-outline-primary rounded-3 px-2 py-2">
                                    <i class="bi bi-eye-fill"></i> Detail & Absen
                                </a>
                                
                                <a href="{{ route('siswa.edit', $siswa->id) }}" class="btn btn-sm btn-outline-warning rounded-3 px-2 py-2">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-2" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $siswa->id }}">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal{{ $siswa->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold text-danger" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-3">
                                    Apakah Anda yakin ingin menghapus data siswa <strong class="text-dark">{{ $siswa->nama }} ({{ $siswa->nis }})</strong>?
                                    <p class="text-muted mb-0 mt-2" style="font-size: 13px;">Tindakan ini juga akan menghapus seluruh data absensi terkait siswa ini secara permanen.</p>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger rounded-3 px-4">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-people-fill fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Tidak ada data siswa ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="text-muted" style="font-size: 14px;">
            Menampilkan {{ $siswas->firstItem() ?? 0 }} sampai {{ $siswas->lastItem() ?? 0 }} dari {{ $siswas->total() }} data
        </span>
        <div>
            {{ $siswas->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

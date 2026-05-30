@extends('layouts.admin')

@section('title', 'Data Jurusan')

@section('content')
<div class="d-flex flex-column flex-sm-row align-items-sm-center justify-content-between mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1">Data Jurusan</h2>
        <p class="text-muted mb-0">Kelola daftar jurusan atau program keahlian sekolah.</p>
    </div>
    <div>
        <a href="{{ route('jurusan.create') }}" class="btn btn-premium-primary">
            <i class="bi bi-plus-circle me-1"></i> Tambah Jurusan
        </a>
    </div>
</div>

<div class="card p-4">
    <!-- Search Bar -->
    <div class="row mb-3 justify-content-end">
        <div class="col-12 col-md-5 col-lg-4">
            <form action="{{ route('jurusan.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control form-control-premium" 
                           placeholder="Cari nama jurusan..." value="{{ $search }}">
                    <button class="btn btn-primary px-3 rounded-end-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    @if($search)
                        <a href="{{ route('jurusan.index') }}" class="btn btn-outline-secondary px-3 d-flex align-items-center">
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
                    <th>Nama Jurusan</th>
                    <th>Jumlah Kelas Terkait</th>
                    <th style="width: 200px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jurusans as $index => $jurusan)
                    <tr>
                        <td>{{ $jurusans->firstItem() + $index }}</td>
                        <td class="fw-bold text-dark">{{ $jurusan->nama_jurusan }}</td>
                        <td>
                            <span class="badge bg-light text-primary border border-primary-subtle px-3 py-2 rounded-3">
                                <i class="bi bi-building me-1"></i> {{ $jurusan->kelas_count }} Kelas
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('jurusan.edit', $jurusan->id) }}" class="btn btn-sm btn-outline-warning rounded-3 px-3 py-2">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                
                                <button type="button" class="btn btn-sm btn-outline-danger rounded-3 px-3 py-2" 
                                        data-bs-toggle="modal" data-bs-target="#deleteModal{{ $jurusan->id }}">
                                    <i class="bi bi-trash-fill"></i> Hapus
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteModal{{ $jurusan->id }}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold text-danger" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body py-3">
                                    Apakah Anda yakin ingin menghapus jurusan <strong class="text-dark">{{ $jurusan->nama_jurusan }}</strong>?
                                    <p class="text-muted mb-0 mt-2" style="font-size: 13px;">Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Batal</button>
                                    <form action="{{ route('jurusan.destroy', $jurusan->id) }}" method="POST">
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
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-x fs-1 d-block mb-2 text-muted opacity-50"></i>
                            Tidak ada data jurusan ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <span class="text-muted" style="font-size: 14px;">
            Menampilkan {{ $jurusans->firstItem() ?? 0 }} sampai {{ $jurusans->lastItem() ?? 0 }} dari {{ $jurusans->total() }} data
        </span>
        <div>
            {{ $jurusans->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection

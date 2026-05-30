<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /**
     * Tampilkan data absensi hari ini untuk Admin.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $hariIni = Carbon::today()->format('Y-m-d');

        $absensis = Absensi::with('siswa.kelas')
            ->where('tanggal_absen', $hariIni)
            ->when($search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('status', 'like', '%' . $search . '%')
                      ->orWhere('keterangan', 'like', '%' . $search . '%')
                      ->orWhereHas('siswa', function ($q2) use ($search) {
                          $q2->where('nama', 'like', '%' . $search . '%')
                             ->orWhere('nis', 'like', '%' . $search . '%')
                             ->orWhereHas('kelas', function ($q3) use ($search) {
                                 $q3->where('nama_kelas', 'like', '%' . $search . '%');
                             });
                      });
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.absensi.index', compact('absensis', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     * Dinonaktifkan: Siswa melakukan absen secara mandiri.
     */
    public function create(Request $request)
    {
        abort(403, 'Aksi ini tidak diizinkan. Absensi hanya dapat diisi secara mandiri oleh Siswa.');
    }

    /**
     * Store a newly created resource in storage.
     * Dinonaktifkan: Siswa melakukan absen secara mandiri.
     */
    public function store(Request $request)
    {
        abort(403, 'Aksi ini tidak diizinkan. Absensi hanya dapat diisi secara mandiri oleh Siswa.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Absensi $absensi)
    {
        return redirect()->route('absensi.index');
    }

    /**
     * Show the form for editing the specified resource.
     * Dinonaktifkan: Admin hanya bisa melihat.
     */
    public function edit(Absensi $absensi)
    {
        abort(403, 'Aksi ini tidak diizinkan. Catatan absensi tidak dapat diubah oleh Admin.');
    }

    /**
     * Update the specified resource in storage.
     * Dinonaktifkan: Admin hanya bisa melihat.
     */
    public function update(Request $request, Absensi $absensi)
    {
        abort(403, 'Aksi ini tidak diizinkan. Catatan absensi tidak dapat diubah oleh Admin.');
    }

    /**
     * Remove the specified resource from storage.
     * Dinonaktifkan: Admin hanya bisa melihat.
     */
    public function destroy(Absensi $absensi)
    {
        abort(403, 'Aksi ini tidak diizinkan. Catatan absensi tidak dapat dihapus oleh Admin.');
    }
}

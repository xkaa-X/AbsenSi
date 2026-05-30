<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaDashboardController extends Controller
{
    /**
     * Tampilkan dashboard khusus siswa.
     */
    public function index()
    {
        // Cari data siswa berdasarkan username (NIS) yang sedang login
        $siswa = Siswa::with('kelas.jurusan', 'absensis')
            ->where('nis', Auth::user()->username)
            ->first();

        if (!$siswa) {
            Auth::logout();
            return redirect()->route('login')->withErrors([
                'loginError' => 'Data profil siswa Anda tidak ditemukan di sistem. Silakan hubungi admin.',
            ]);
        }

        // Cek apakah siswa sudah melakukan absensi hari ini
        $hariIni = Carbon::today()->format('Y-m-d');
        $todayAbsen = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal_absen', $hariIni)
            ->first();

        // Riwayat absensi siswa tersebut
        $absensis = Absensi::where('siswa_id', $siswa->id)
            ->orderBy('tanggal_absen', 'desc')
            ->get();

        return view('siswa.dashboard', compact('siswa', 'todayAbsen', 'absensis'));
    }

    /**
     * Simpan absensi mandiri oleh siswa.
     */
    public function absen(Request $request)
    {
        $siswa = Siswa::where('nis', Auth::user()->username)->first();

        if (!$siswa) {
            return back()->with('error', 'Siswa tidak ditemukan.');
        }

        $request->validate([
            'status' => 'required|in:Hadir,Sakit,Izin',
            'keterangan' => 'nullable|string|max:255',
        ], [
            'status.required' => 'Status kehadiran wajib dipilih!',
            'status.in' => 'Status kehadiran tidak valid!',
        ]);

        $hariIni = Carbon::today()->format('Y-m-d');

        // Cek jika siswa sudah absen hari ini
        $exists = Absensi::where('siswa_id', $siswa->id)
            ->where('tanggal_absen', $hariIni)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Anda sudah melakukan absensi hari ini!');
        }

        Absensi::create([
            'siswa_id' => $siswa->id,
            'tanggal_absen' => $hariIni,
            'status' => $request->status,
            'keterangan' => $request->keterangan ?? ($request->status == 'Hadir' ? 'Absen Mandiri (Hadir)' : '-'),
        ]);

        return back()->with('success', 'Absensi hari ini berhasil dicatat! Terima kasih.');
    }
}

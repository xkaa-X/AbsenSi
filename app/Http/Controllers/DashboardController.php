<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\Absensi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Tampilkan halaman dashboard guru beserta statistik.
     */
    public function index()
    {
        if (auth()->user()->role === 'siswa') {
            return redirect()->route('siswa.dashboard');
        }

        // Ambil kelas pertama (XI RPL 1)
        $kelas = Kelas::with('jurusan')->first();
        
        if ($kelas) {
            $siswas = Siswa::where('kelas_id', $kelas->id)->orderBy('nama', 'asc')->get();
            $totalSiswa = $siswas->count();
        } else {
            $siswas = collect();
            $totalSiswa = 0;
        }

        // Hari ini
        $hariIni = Carbon::today()->format('Y-m-d');
        
        // Ambil absensi hari ini dan keyBy siswa_id
        $absensiHariIni = Absensi::where('tanggal_absen', $hariIni)
            ->get()
            ->keyBy('siswa_id');

        // Statistik Absensi Hari Ini
        $hadirHariIni = $absensiHariIni->where('status', 'Hadir')->count();
        $sakitHariIni = $absensiHariIni->where('status', 'Sakit')->count();
        $izinHariIni = $absensiHariIni->where('status', 'Izin')->count();
        $alpaHariIni = $absensiHariIni->where('status', 'Alpa')->count();
        $belumAbsenHariIni = max(0, $totalSiswa - $absensiHariIni->count());

        // Statistik Gender Siswa
        $siswaLaki = $siswas->where('jenis_kelamin', 'Laki-laki')->count();
        $siswaPerempuan = $siswas->where('jenis_kelamin', 'Perempuan')->count();

        return view('dashboard', compact(
            'kelas',
            'siswas',
            'totalSiswa',
            'hadirHariIni',
            'sakitHariIni',
            'izinHariIni',
            'alpaHariIni',
            'belumAbsenHariIni',
            'siswaLaki',
            'siswaPerempuan',
            'absensiHariIni',
            'hariIni'
        ));
    }
}

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

        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalJurusan = Jurusan::count();

        // Hari ini
        $hariIni = Carbon::today()->format('Y-m-d');
        
        // Statistik Absensi Hari Ini
        $hadirHariIni = Absensi::where('tanggal_absen', $hariIni)->where('status', 'Hadir')->count();
        $sakitHariIni = Absensi::where('tanggal_absen', $hariIni)->where('status', 'Sakit')->count();
        $izinHariIni = Absensi::where('tanggal_absen', $hariIni)->where('status', 'Izin')->count();
        $alpaHariIni = Absensi::where('tanggal_absen', $hariIni)->where('status', 'Alpa')->count();
        
        $totalAbsenHariIni = Absensi::where('tanggal_absen', $hariIni)->count();
        $belumAbsenHariIni = max(0, $totalSiswa - $totalAbsenHariIni);

        // Statistik Gender Siswa
        $siswaLaki = Siswa::where('jenis_kelamin', 'Laki-laki')->count();
        $siswaPerempuan = Siswa::where('jenis_kelamin', 'Perempuan')->count();

        // 5 Absensi Terbaru
        $absensiTerbaru = Absensi::with('siswa.kelas')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalSiswa',
            'totalKelas',
            'totalJurusan',
            'hadirHariIni',
            'sakitHariIni',
            'izinHariIni',
            'alpaHariIni',
            'belumAbsenHariIni',
            'siswaLaki',
            'siswaPerempuan',
            'absensiTerbaru'
        ));
    }
}

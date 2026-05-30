<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Default Guru
        User::create([
            'username' => 'guru',
            'password' => Hash::make('guru123'),
            'role' => 'guru',
        ]);

        // 2. Seed Jurusan (Hanya yang diperlukan untuk data siswa)
        $rpl = Jurusan::create(['nama_jurusan' => 'Rekayasa Perangkat Lunak (RPL)']);

        // 3. Seed Kelas (Hanya yang diperlukan untuk data siswa)
        $rpl11_1 = Kelas::create([
            'nama_kelas' => 'XI RPL 1',
            'jurusan_id' => $rpl->id
        ]);

        // 4. Seed Siswas based on the user's provided list
        $data = [
            ['nama' => 'ADINDA AYU SEPTIA RAHMADANI', 'nis' => '1', 'kelas' => 'XI RPL 1'],
            ['nama' => 'AGUNG RAMADHAN PRATAMA PUTRA', 'nis' => '2', 'kelas' => 'XI RPL 1'],
            ['nama' => 'AHNAF HAIMA ATHA SAMUDRA', 'nis' => '3', 'kelas' => 'XI RPL 1'],
            ['nama' => 'AISYAH SYIFA WULAN RAHMADANI', 'nis' => '4', 'kelas' => 'XI RPL 1'],
            ['nama' => 'ALDEN SETYAWAN', 'nis' => '5', 'kelas' => 'XI RPL 1'],
            ['nama' => 'AMELYA AYU FITRIANI', 'nis' => '6', 'kelas' => 'XI RPL 1'],
            ['nama' => 'ANIDATUR ROHMAH', 'nis' => '7', 'kelas' => 'XI RPL 1'],
            ['nama' => 'ASMIRANDA PUSPANINGTYAS', 'nis' => '8', 'kelas' => 'XI RPL 1'],
            ['nama' => 'ATHARYA NUGRAHA KRISDIWAN', 'nis' => '9', 'kelas' => 'XI RPL 1'],
            ['nama' => 'AUREL AYU ISTINA', 'nis' => '10', 'kelas' => 'XI RPL 1'],
            ['nama' => 'AVIVA KHUSNUN NAZILA', 'nis' => '11', 'kelas' => 'XI RPL 1'],
            ['nama' => 'AXEL BAYU GHAZIR MUHAMMAD', 'nis' => '12', 'kelas' => 'XI RPL 1'],
            ['nama' => 'AYU NINDYA RAFASATI', 'nis' => '13', 'kelas' => 'XI RPL 1'],
            ['nama' => 'DEWA MAULANA FEBRI ANDIKA', 'nis' => '14', 'kelas' => 'XI RPL 1'],
            ['nama' => 'DEWI SRI WAHYUNI ASIH', 'nis' => '15', 'kelas' => 'XI RPL 1'],
            ['nama' => 'DINAR PUTRI YULIANTI', 'nis' => '16', 'kelas' => 'XI RPL 1'],
            ['nama' => 'ERLIN KHALIA MUFIDA', 'nis' => '17', 'kelas' => 'XI RPL 1'],
            ['nama' => 'FAIZAH LINTANG JUWITA DAMARA', 'nis' => '18', 'kelas' => 'XI RPL 1'],
            ['nama' => 'GALVIN AGUSTIAN PUTRA', 'nis' => '19', 'kelas' => 'XI RPL 1'],
            ['nama' => 'HAVIZA ANDARA AGUSTINA', 'nis' => '20', 'kelas' => 'XI RPL 1'],
            ['nama' => 'INTAN PERMATASARI DWI ANJANI', 'nis' => '21', 'kelas' => 'XI RPL 1'],
            ['nama' => 'MARIA ULFIA', 'nis' => '22', 'kelas' => 'XI RPL 1'],
            ['nama' => 'MOCHAMAD FARID GIUSTINO', 'nis' => '23', 'kelas' => 'XI RPL 1'],
            ['nama' => 'MOCHAMAD ROMI SYAH PUTRA', 'nis' => '24', 'kelas' => 'XI RPL 1'],
            ['nama' => 'MOFASYA PUTRA PRATAMA', 'nis' => '25', 'kelas' => 'XI RPL 1'],
            ['nama' => 'MOHAMAD RAFI CAHYA R', 'nis' => '26', 'kelas' => 'XI RPL 1'],
            ['nama' => 'MUHAMMAD ABDUL ROZAQ AL FAQIH', 'nis' => '27', 'kelas' => 'XI RPL 1'],
            ['nama' => 'MUHAMMAD FADILAN', 'nis' => '28', 'kelas' => 'XI RPL 1'],
            ['nama' => 'NADYA ZIEZIELYA', 'nis' => '29', 'kelas' => 'XI RPL 1'],
            ['nama' => 'NAQA NAYAKA', 'nis' => '30', 'kelas' => 'XI RPL 1'],
            ['nama' => 'NASYWA NATA NELLA RAHMAN', 'nis' => '31', 'kelas' => 'XI RPL 1'],
            ['nama' => 'NAYLA RAHMATIKA RAMADHANI', 'nis' => '32', 'kelas' => 'XI RPL 1'],
            ['nama' => 'NUR WIJAYA KUSUMA', 'nis' => '33', 'kelas' => 'XI RPL 1'],
            ['nama' => 'RADEN AJENG AURORA SAPUTRA', 'nis' => '34', 'kelas' => 'XI RPL 1'],
            ['nama' => 'REVALINA AULIA DWI', 'nis' => '35', 'kelas' => 'XI RPL 1'],
            ['nama' => 'SIVA PUTRI ATMA DESTY', 'nis' => '36', 'kelas' => 'XI RPL 1'],
            ['nama' => 'SYARIF ADITYA PUTRA', 'nis' => '37', 'kelas' => 'XI RPL 1'],
            ['nama' => 'VIRA AULIA SOFA', 'nis' => '38', 'kelas' => 'XI RPL 1'],
            ['nama' => 'YUNITA INDAH SARI', 'nis' => '39', 'kelas' => 'XI RPL 1'],
            ['nama' => 'YUSUF USMAN', 'nis' => '40', 'kelas' => 'XI RPL 1'],
        ];

        foreach ($data as $s) {
            // Tentukan jenis kelamin berdasarkan kata kunci nama
            $femaleKeywords = ['PUTRI', 'AYU', 'SITI', 'DEWI', 'AMELYA', 'ANIDATUR', 'ASMIRANDA', 'AVIVA', 'FAIZAH', 'HAVIZA', 'INTAN', 'MARIA', 'NADYA', 'NASYWA', 'NAYLA', 'REVALINA', 'SIVA', 'VIRA', 'YUNITA', 'ADINDA', 'AISYAH', 'ERLIN', 'CITRA'];
            $isFemale = false;
            foreach ($femaleKeywords as $keyword) {
                if (str_contains($s['nama'], $keyword)) {
                    $isFemale = true;
                    break;
                }
            }
            $jenisKelamin = $isFemale ? 'Perempuan' : 'Laki-laki';

            // Masukkan data siswa ke tabel siswas
            Siswa::create([
                'nis' => $s['nis'],
                'nama' => $s['nama'],
                'alamat' => 'Jl. Ketintang No. ' . $s['nis'] . ', Surabaya',
                'jenis_kelamin' => $jenisKelamin,
                'kelas_id' => $rpl11_1->id,
            ]);

            // Buat akun login siswa di tabel users
            User::create([
                'username' => $s['nis'],
                'password' => Hash::make('siswa123'),
                'role' => 'siswa',
            ]);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $siswas = Siswa::with('kelas.jurusan')
            ->when($search, function ($query, $search) {
                return $query->where('nis', 'like', '%' . $search . '%')
                    ->orWhere('nama', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('jenis_kelamin', 'like', '%' . $search . '%')
                    ->orWhereHas('kelas', function ($q) use ($search) {
                        $q->where('nama_kelas', 'like', '%' . $search . '%')
                            ->orWhereHas('jurusan', function ($q2) use ($search) {
                                $q2->where('nama_jurusan', 'like', '%' . $search . '%');
                            });
                    });
            })
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('admin.siswa.index', compact('siswas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas', 'asc')->get();
        return view('admin.siswa.create', compact('kelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|numeric|unique:siswas,nis',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'nis.required' => 'NIS wajib diisi!',
            'nis.numeric' => 'NIS harus berupa angka!',
            'nis.unique' => 'NIS sudah terdaftar untuk siswa lain!',
            'nama.required' => 'Nama lengkap wajib diisi!',
            'alamat.required' => 'Alamat wajib diisi!',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih!',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid!',
            'kelas_id.required' => 'Kelas wajib dipilih!',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid!',
        ]);

        $siswa = Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $request->kelas_id,
        ]);

        // Otomatis buat akun user login untuk siswa baru
        \App\Models\User::create([
            'username' => $request->nis,
            'password' => \Illuminate\Support\Facades\Hash::make('siswa123'),
            'role' => 'siswa',
        ]);

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa dan akun login berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        // Memuat relasi agar relasi tampil otomatis menggunakan eloquent
        $siswa->load(['kelas.jurusan', 'absensis' => function ($query) {
            $query->orderBy('tanggal_absen', 'desc');
        }]);
        
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = Kelas::with('jurusan')->orderBy('nama_kelas', 'asc')->get();
        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nis' => 'required|numeric|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'nis.required' => 'NIS wajib diisi!',
            'nis.numeric' => 'NIS harus berupa angka!',
            'nis.unique' => 'NIS sudah terdaftar untuk siswa lain!',
            'nama.required' => 'Nama lengkap wajib diisi!',
            'alamat.required' => 'Alamat wajib diisi!',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih!',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid!',
            'kelas_id.required' => 'Kelas wajib dipilih!',
            'kelas_id.exists' => 'Kelas yang dipilih tidak valid!',
        ]);

        $oldNis = $siswa->nis;

        $siswa->update([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'jenis_kelamin' => $request->jenis_kelamin,
            'kelas_id' => $request->kelas_id,
        ]);

        // Otomatis perbarui username (NIS) pada akun user login terkait jika berubah
        $user = \App\Models\User::where('username', $oldNis)->where('role', 'siswa')->first();
        if ($user) {
            $user->update([
                'username' => $request->nis,
            ]);
        } else {
            // Jika akun user tidak sengaja terhapus/belum ada, buat baru
            \App\Models\User::create([
                'username' => $request->nis,
                'password' => \Illuminate\Support\Facades\Hash::make('siswa123'),
                'role' => 'siswa',
            ]);
        }

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa dan akun login berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $nis = $siswa->nis;
        
        $siswa->delete();

        // Otomatis hapus akun user login terkait
        \App\Models\User::where('username', $nis)->where('role', 'siswa')->delete();

        // Urutkan ulang NIS seluruh siswa yang tersisa agar berurutan mulai dari 1
        $remainingSiswa = Siswa::orderBy('id', 'asc')->get();
        
        $newNis = 1;
        foreach ($remainingSiswa as $s) {
            $oldNis = $s->nis;
            
            // Jika NIS siswa perlu disesuaikan
            if ($oldNis != $newNis) {
                // Perbarui username pada tabel users terlebih dahulu
                \App\Models\User::where('username', $oldNis)
                    ->where('role', 'siswa')
                    ->update(['username' => (string)$newNis]);
                
                // Perbarui NIS siswa pada tabel siswas
                $s->update(['nis' => (string)$newNis]);
            }
            $newNis++;
        }

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus dan NIS seluruh siswa telah disesuaikan kembali secara berurutan!');
    }
}

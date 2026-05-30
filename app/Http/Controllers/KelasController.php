<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $kelas = Kelas::with('jurusan')
            ->when($search, function ($query, $search) {
                return $query->where('nama_kelas', 'like', '%' . $search . '%')
                    ->orWhereHas('jurusan', function ($q) use ($search) {
                        $q->where('nama_jurusan', 'like', '%' . $search . '%');
                    });
            })
            ->withCount('siswas') // Menampilkan jumlah siswa di kelas ini
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('admin.kelas.index', compact('kelas', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan', 'asc')->get();
        return view('admin.kelas.create', compact('jurusans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi!',
            'jurusan_id.required' => 'Jurusan wajib dipilih!',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid!',
        ]);

        // Cek jika kombinasi kelas dan jurusan sudah ada
        $exists = Kelas::where('nama_kelas', $request->nama_kelas)
            ->where('jurusan_id', $request->jurusan_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['nama_kelas' => 'Kombinasi nama kelas dan jurusan ini sudah terdaftar!'])->withInput();
        }

        Kelas::create([
            'nama_kelas' => $request->nama_kelas,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        return redirect()->route('kelas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $jurusans = Jurusan::orderBy('nama_jurusan', 'asc')->get();
        return view('admin.kelas.edit', compact('kelas', 'jurusans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan_id' => 'required|exists:jurusans,id',
        ], [
            'nama_kelas.required' => 'Nama kelas wajib diisi!',
            'jurusan_id.required' => 'Jurusan wajib dipilih!',
            'jurusan_id.exists' => 'Jurusan yang dipilih tidak valid!',
        ]);

        // Cek jika kombinasi kelas dan jurusan sudah ada di kelas lain
        $exists = Kelas::where('nama_kelas', $request->nama_kelas)
            ->where('jurusan_id', $request->jurusan_id)
            ->where('id', '!=', $kelas->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['nama_kelas' => 'Kombinasi nama kelas dan jurusan ini sudah digunakan kelas lain!'])->withInput();
        }

        $kelas->update([
            'nama_kelas' => $request->nama_kelas,
            'jurusan_id' => $request->jurusan_id,
        ]);

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        // Cek apakah ada siswa di kelas ini
        if ($kelas->siswas()->exists()) {
            return redirect()->route('kelas.index')
                ->with('error', 'Kelas tidak bisa dihapus karena masih memiliki data siswa terkait!');
        }

        $kelas->delete();

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $jurusans = Jurusan::when($search, function ($query, $search) {
                return $query->where('nama_jurusan', 'like', '%' . $search . '%');
            })
            ->withCount('kelas') // Menampilkan jumlah kelas di jurusan ini
            ->orderBy('id', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view('admin.jurusan.index', compact('jurusans', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusans,nama_jurusan',
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi!',
            'nama_jurusan.unique' => 'Nama jurusan sudah terdaftar!',
        ]);

        Jurusan::create([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')
            ->with('success', 'Jurusan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        return redirect()->route('jurusan.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        return view('admin.jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $request->validate([
            'nama_jurusan' => 'required|string|max:255|unique:jurusans,nama_jurusan,' . $jurusan->id,
        ], [
            'nama_jurusan.required' => 'Nama jurusan wajib diisi!',
            'nama_jurusan.unique' => 'Nama jurusan sudah terdaftar!',
        ]);

        $jurusan->update([
            'nama_jurusan' => $request->nama_jurusan,
        ]);

        return redirect()->route('jurusan.index')
            ->with('success', 'Jurusan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        // Cek apakah ada kelas yang menggunakan jurusan ini
        if ($jurusan->kelas()->exists()) {
            return redirect()->route('jurusan.index')
                ->with('error', 'Jurusan tidak bisa dihapus karena masih memiliki data kelas terkait!');
        }

        $jurusan->delete();

        return redirect()->route('jurusan.index')
            ->with('success', 'Jurusan berhasil dihapus!');
    }
}

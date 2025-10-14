<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    // Tampilkan semua kriteria
    public function index()
    {
        $daftarKriteria = Kriteria::all();
        return view('pages.kriteria.index', compact('daftarKriteria'));
    }

    // Form tambah kriteria
    public function create()
    {
        return view('pages.kriteria.create');
    }

    // Simpan kriteria baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0',
            'tipe' => 'required|in:benefit,cost',
        ]);

        Kriteria::create($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil ditambahkan.');
    }

    // Form edit kriteria
    public function edit(Kriteria $kriterium)
    {
        return view('pages.kriteria.edit', compact('kriterium'));
    }

    // Update kriteria
    public function update(Request $request, Kriteria $kriterium)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0',
            'tipe' => 'required|in:benefit,cost',
        ]);

        $kriterium->update($request->all());

        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil diperbarui.');
    }

    // Hapus kriteria
    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('kriteria.index')->with('success', 'Kriteria berhasil dihapus.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('pages.karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('pages.karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:karyawan,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'pendidikan_terakhir' => 'required|string|max:50',
            'lama_bekerja' => 'required|integer|min:0',
            'jumlah_kehadiran' => 'required|integer|min:0|max:260',
            'hasil_penilaian_kinerja_sebelumnya' => 'required|numeric|min:0|max:100',
            'jabatan' => 'required|string|max:255',
        ]);

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan.');
    }

    public function edit(Karyawan $karyawan)
    {
        return view('pages.karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, Karyawan $karyawan)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:karyawan,nik,' . $karyawan->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'pendidikan_terakhir' => 'required|string|max:50',
            'lama_bekerja' => 'required|integer|min:0',
            'jumlah_kehadiran' => 'required|integer|min:0|max:260',
            'hasil_penilaian_kinerja_sebelumnya' => 'required|numeric|min:0|max:100',
            'jabatan' => 'required|string|max:255',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Imports\KaryawanImport;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
            'umur' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|in:L,P',
            'pendidikan_terakhir' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'lama_bekerja' => 'required|integer|min:0',
            'jumlah_kehadiran' => 'required|integer|min:0|max:260',
            'nilai_produktivitas' => 'required|numeric|min:0|max:100',
            'hasil_penilaian_kinerja_sebelumnya' => 'required|numeric|min:0|max:100',
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
            'umur' => 'required|integer|min:0',
            'jenis_kelamin' => 'required|in:L,P',
            'pendidikan_terakhir' => 'required|string|max:50',
            'jabatan' => 'required|string|max:255',
            'lama_bekerja' => 'required|integer|min:0',
            'jumlah_kehadiran' => 'required|integer|min:0|max:260',
            'nilai_produktivitas' => 'required|numeric|min:0|max:100',
            'hasil_penilaian_kinerja_sebelumnya' => 'required|numeric|min:0|max:100',
        ]);

        $karyawan->update($validated);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy(Karyawan $karyawan)
    {
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus.');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);

        try {
            Excel::import(new KaryawanImport, $request->file('file'));

            return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('karyawan.index')->with('error', 'Terjadi kesalahan saat mengimport: ' . $e->getMessage());
        }
    }
}

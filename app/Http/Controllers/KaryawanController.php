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
            'jenis_kelamin' => 'required|in:L,P',
            'usia' => 'required|integer|min:0',
            'pendidikan_terakhir' => 'required|string|max:50',
            'lama_bekerja_satuan' => 'required|in:TAHUN,BULAN',
            'lama_bekerja_angka' => 'required|integer|min:0',
            'kehadiran' => 'required|integer|min:0|max:260',
            'hasil_penilaian_kinerja_sebelumnya' => 'required|numeric|min:0|max:100',
            'jabatan' => 'required|string|max:255',
            'produktivitas_kerja' => 'required|in:TERCAPAI,TIDAK TERCAPAI',
        ]);

        $lamaBekerja = $validated['lama_bekerja_angka'] . ' ' . $validated['lama_bekerja_satuan'];

        Karyawan::create([
            'nik' => $validated['nik'],
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'usia' => $validated['usia'],
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'],
            'lama_bekerja' => $lamaBekerja,
            'kehadiran' => $validated['kehadiran'],
            'hasil_penilaian_kinerja_sebelumnya' => $validated['hasil_penilaian_kinerja_sebelumnya'],
            'jabatan' => $validated['jabatan'],
            'produktivitas_kerja' => $validated['produktivitas_kerja'],
        ]);

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
            'usia' => 'required|integer|min:0',
            'pendidikan_terakhir' => 'required|string|max:50',
            'lama_bekerja_satuan' => 'required|in:TAHUN,BULAN',
            'lama_bekerja_angka' => 'required|integer|min:0',
            'kehadiran' => 'required|integer|min:0|max:260',
            'hasil_penilaian_kinerja_sebelumnya' => 'required|numeric|min:0|max:100',
            'jabatan' => 'required|string|max:255',
            'produktivitas_kerja' => 'required|in:TERCAPAI,TIDAK TERCAPAI',
        ]);

        $lamaBekerja = $validated['lama_bekerja_angka'] . ' ' . $validated['lama_bekerja_satuan'];

        $karyawan->update([
            'nik' => $validated['nik'],
            'nama' => $validated['nama'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'usia' => $validated['usia'],
            'pendidikan_terakhir' => $validated['pendidikan_terakhir'],
            'lama_bekerja' => $lamaBekerja,
            'kehadiran' => $validated['kehadiran'],
            'hasil_penilaian_kinerja_sebelumnya' => $validated['hasil_penilaian_kinerja_sebelumnya'],
            'jabatan' => $validated['jabatan'],
            'produktivitas_kerja' => $validated['produktivitas_kerja'],
        ]);

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

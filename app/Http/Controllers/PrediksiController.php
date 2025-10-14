<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Prediksi;
use Illuminate\Http\Request;

class PrediksiController extends Controller
{
    public function index()
    {
        $prediksi = Prediksi::with('karyawan')->latest()->paginate(10);
        return view('pages.prediksi.index', compact('prediksi'));
    }

    public function create()
    {
        $karyawan = Karyawan::all();
        return view('pages.prediksi.create', compact('karyawan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id',
            'nilai_aktual' => 'required|numeric',
            'hasil_prediksi' => 'required|numeric',
        ]);

        Prediksi::create($validated);

        return redirect()->route('prediksi.index')->with('success', 'Prediksi berhasil ditambahkan.');
    }

    public function show(Prediksi $prediksi)
    {
        $prediksi->load('karyawan');
        return view('pages.prediksi.show', compact('prediksi'));
    }

    public function destroy(Prediksi $prediksi)
    {
        $prediksi->delete();
        return redirect()->route('prediksi.index')->with('success', 'Data prediksi berhasil dihapus.');
    }
}

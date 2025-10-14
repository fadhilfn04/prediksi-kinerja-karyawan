<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Prediksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PrediksiController extends Controller
{
    public function index()
    {
        $prediksi = Prediksi::with('karyawan')->get();
        return view('pages.prediksi.index', compact('prediksi'));
    }
}

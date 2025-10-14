<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Prediksi;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik karyawan
        $totalKaryawan = Karyawan::count();

        // Status model
        $isModelTrained = Storage::disk('local')->exists('training/model.json');
        $lastTrainingDate = null;

        if ($isModelTrained) {
            $lastTrainingDate = date('d M Y H:i', Storage::disk('local')->lastModified('training/model.json'));
        }

        // Statistik prediksi
        $totalPrediksi = Prediksi::count();

        // Data untuk chart
        $chartData = Prediksi::selectRaw('prediksi, COUNT(*) as total')
            ->groupBy('prediksi')
            ->get()
            ->map(fn ($row) => [
                'name' => $row->prediksi,
                'y' => (int) $row->total
            ]);

        // Data prediksi terbaru
        $latestPredictions = Prediksi::latest()->take(5)->get();

        return view('pages.dashboards.index', compact(
            'totalKaryawan',
            'isModelTrained',
            'lastTrainingDate',
            'totalPrediksi',
            'chartData',
            'latestPredictions'
        ));
    }
}
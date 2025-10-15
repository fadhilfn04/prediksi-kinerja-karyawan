<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Prediksi;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function index()
    {
        $totalKaryawan = Karyawan::count();

        $isModelTrained = Storage::disk('local')->exists('training/model.json');
        $lastTrainingDate = null;
        $modelAccuracy = null;

        if ($isModelTrained) {
            $lastTrainingDate = date('d M Y H:i', Storage::disk('local')->lastModified('training/model.json'));

            if (Storage::disk('local')->exists('training/accuracy.json')) {
                $accuracyData = json_decode(Storage::disk('local')->get('training/accuracy.json'), true);
                $modelAccuracy = $accuracyData['accuracy'] ?? null;
            }
        }

        $totalPrediksi = Karyawan::count();

        $chartData = Karyawan::selectRaw('prediksi, COUNT(*) as total')
            ->groupBy('prediksi')
            ->get()
            ->map(fn ($row) => [
                'name' => $row->prediksi,
                'y' => (int) $row->total
            ]);

        $latestPredictions = Karyawan::latest()->take(5)
        ->where('prediksi', '<>', NULL)
        ->get();

        return view('pages.dashboards.index', compact(
            'totalKaryawan',
            'isModelTrained',
            'lastTrainingDate',
            'totalPrediksi',
            'chartData',
            'latestPredictions',
            'modelAccuracy'
        ));
    }
}
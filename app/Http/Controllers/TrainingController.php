<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Prediksi;
use Illuminate\Http\Request;
use App\Services\DecisionTree\ID3;
use App\Services\DecisionTree\Predictor;
use Illuminate\Support\Facades\Storage;

class TrainingController extends Controller
{
    public function index()
    {
        return view('pages.training.index');
    }

    public function ambilData()
    {
        try {
            $data = Karyawan::select(
                'id',
                'nik',
                'nama',
                'jenis_kelamin',
                'pendidikan_terakhir',
                'lama_bekerja',
                'jumlah_kehadiran',
                'hasil_penilaian_kinerja_sebelumnya',
                'jabatan'
            )->get();

            if ($data->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data karyawan yang tersedia untuk training.'
                ]);
            }

            Storage::disk('local')->put('training/data.json', $data->toJson());

            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil diambil dan disimpan untuk training.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data: ' . $e->getMessage()
            ]);
        }
    }

    public function returnData()
    {
        try {
            if (!Storage::disk('local')->exists('training/data.json')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data training belum tersedia. Silakan ambil data terlebih dahulu.'
                ]);
            }

            $json = Storage::disk('local')->get('training/data.json');
            $data = json_decode($json, true);

            return response()->json([
                'success' => true,
                'message' => 'Data training berhasil dimuat.',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat data training: ' . $e->getMessage()
            ]);
        }
    }

    public function proses()
    {
        try {
            if (!Storage::disk('local')->exists('training/data.json')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data training belum tersedia.'
                ]);
            }

            $json = Storage::disk('local')->get('training/data.json');
            $data = json_decode($json, true);

            foreach ($data as &$row) {
                if ($row['hasil_penilaian_kinerja_sebelumnya'] >= 80) {
                    $row['label_kinerja'] = 'Baik';
                } elseif ($row['hasil_penilaian_kinerja_sebelumnya'] >= 60) {
                    $row['label_kinerja'] = 'Cukup';
                } else {
                    $row['label_kinerja'] = 'Kurang';
                }
            }


            $attributes = [
                'jenis_kelamin',
                'pendidikan_terakhir',
                'lama_bekerja',
                'jumlah_kehadiran',
                'jabatan'
            ];

            $tree = (new ID3($data, 'label_kinerja'))->train($attributes);
            Storage::disk('local')->put('training/model.json', json_encode($tree, JSON_PRETTY_PRINT));

            $predictor = new Predictor($tree);
            $total = count($data);
            $benar = 0;

            foreach ($data as $item) {
                $input = [
                    'jenis_kelamin' => $item['jenis_kelamin'],
                    'pendidikan_terakhir' => $item['pendidikan_terakhir'],
                    'lama_bekerja' => $item['lama_bekerja'],
                    'jumlah_kehadiran' => $item['jumlah_kehadiran'],
                    'jabatan' => $item['jabatan'],
                ];

                $prediksi = $predictor->predict($input);
                if ($prediksi === $item['label_kinerja']) {
                    $benar++;
                }

                Prediksi::updateOrCreate(['karyawan_id' => $item['id']],
                    [
                        'jenis_kelamin' => $item['jenis_kelamin'],
                        'pendidikan_terakhir' => $item['pendidikan_terakhir'],
                        'lama_bekerja' => $item['lama_bekerja'],
                        'jumlah_kehadiran' => $item['jumlah_kehadiran'],
                        'jabatan' => $item['jabatan'],
                        'prediksi' => $prediksi,
                    ]
                );
            }

            $akurasi = $total > 0 ? round(($benar / $total) * 100, 2) : 0;

            $accuracyData = [
                'accuracy' => $akurasi,
                'total_data' => $total,
                'benar' => $benar,
                'tanggal' => now()->toDateTimeString()
            ];
            Storage::disk('local')->put('training/accuracy.json', json_encode($accuracyData, JSON_PRETTY_PRINT));

            return response()->json([
                'success' => true,
                'message' => 'Proses training dengan algoritma Decision Tree berhasil!',
                'tree' => $tree,
                'accuracy' => $accuracyData
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat proses training: ' . $e->getMessage()
            ]);
        }
    }

    public function simpan()
    {
        try {
            if (!Storage::disk('local')->exists('training/model.json')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Model belum dihasilkan. Lakukan proses training terlebih dahulu.'
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Model decision tree berhasil disimpan dan siap digunakan.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan model: ' . $e->getMessage()
            ]);
        }
    }
}
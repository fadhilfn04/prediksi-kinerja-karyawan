<?php

namespace App\Imports;

use App\Models\Karyawan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KaryawanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (empty($row['nik'])) {
            return null;
        }

        $existing = Karyawan::where('nik', $row['nik'])->exists();

        if ($existing) {
            return null;
        }

        return new Karyawan([
            'nik' => $row['nik'],
            'nama' => $row['nama'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'pendidikan_terakhir' => $row['pendidikan_terakhir'],
            'lama_bekerja' => $row['lama_bekerja'],
            'kehadiran' => $row['kehadiran'],
            'hasil_penilaian_kinerja_sebelumnya' => $row['hasil_penilaian_kinerja_sebelumnya'],
            'jabatan' => $row['jabatan'],
            'produktivitas_kerja' => $row['produktivitas_kerja'],
            'usia' => $row['usia'],
        ]);
    }
}

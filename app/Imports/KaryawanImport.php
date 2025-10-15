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
            'umur' => $row['umur'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'pendidikan_terakhir' => $row['pendidikan_terakhir'],
            'jabatan' => $row['jabatan'],
            'lama_bekerja' => $row['lama_bekerja'],
            'jumlah_kehadiran' => $row['jumlah_kehadiran'],
            'nilai_produktivitas' => $row['nilai_produktivitas'],
            'hasil_penilaian_kinerja_sebelumnya' => $row['hasil_penilaian_kinerja_sebelumnya'],
        ]);
    }
}
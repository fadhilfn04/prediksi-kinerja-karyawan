<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'jabatan',
        'usia',
        'pendidikan_terakhir',
        'lama_bekerja',
        'kehadiran',
        'produktivitas_kerja',
        'hasil_penilaian_kinerja_sebelumnya',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

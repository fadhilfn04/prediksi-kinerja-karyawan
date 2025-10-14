<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prediksi extends Model
{
    use HasFactory;

    protected $table = 'prediksi';

    protected $fillable = [
        'id_karyawan',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'lama_bekerja',
        'jumlah_kehadiran',
        'jabatan',
        'prediksi',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }
}

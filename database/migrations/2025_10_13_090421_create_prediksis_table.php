<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('prediksi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_karyawan');
            $table->string('jenis_kelamin');
            $table->string('pendidikan_terakhir');
            $table->integer('lama_bekerja');
            $table->integer('jumlah_kehadiran');
            $table->string('jabatan');
            $table->string('prediksi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prediksi');
    }
};

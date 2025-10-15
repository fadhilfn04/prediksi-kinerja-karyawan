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
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->string('nik')->unique();
            $table->string('nama');
            $table->integer('umur')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('pendidikan_terakhir')->nullable();
            $table->text('jabatan')->nullable();
            $table->string('lama_bekerja')->nullable();
            $table->string('jumlah_kehadiran')->nullable();
            $table->integer('nilai_produktivitas')->nullable();
            $table->integer('hasil_penilaian_kinerja_sebelumnya')->nullable();
            $table->text('prediksi')->nullable();
            $table->timestamp('tanggal_prediksi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};

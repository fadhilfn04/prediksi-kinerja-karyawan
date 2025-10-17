<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Karyawan;
use Faker\Factory as Faker;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 0; $i < 200; $i++) {
            Karyawan::create([
                'nik' => $faker->unique()->numerify('##########'),
                'nama' => $faker->name(),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'pendidikan_terakhir' => $faker->randomElement(['SMA', 'D3', 'D4', 'S1']),
                'jabatan' => $faker->randomElement(['COS', 'ACOS', 'CREW']),
                'lama_bekerja' => $faker->randomElement(['10 TAHUN', '5 TAHUN', '3 TAHUN', '1 TAHUN', '6 BULAN', '3 BULAN']),
                'kehadiran' => $faker->numberBetween(20, 100),
                'produktivitas_kerja' => $faker->randomElement(['Tidak Tercapai', 'Tercapai']),
                'hasil_penilaian_kinerja_sebelumnya' => $faker->randomFloat(2, 50, 100),
                'usia' => $faker->numberBetween(20, 60),
            ]);
        }
    }
}

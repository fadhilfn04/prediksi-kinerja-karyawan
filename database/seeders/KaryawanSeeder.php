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
                'umur' => $faker->numberBetween(20, 60),
                'jenis_kelamin' => $faker->randomElement(['L', 'P']),
                'pendidikan_terakhir' => $faker->randomElement(['SMA', 'D3', 'S1', 'S2']),
                'jabatan' => $faker->randomElement(['Staff', 'Kepala Toko', 'Wakil Kepala Toko', 'Crew']),
                'lama_bekerja' => $faker->numberBetween(1, 20),
                'jumlah_kehadiran' => $faker->numberBetween(200, 260),
                'nilai_produktivitas' => $faker->randomFloat(2, 50, 100),
                'hasil_penilaian_kinerja_sebelumnya' => $faker->randomFloat(2, 50, 100),
            ]);
        }
    }
}
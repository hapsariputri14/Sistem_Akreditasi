<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PHKISeeder extends Seeder
{
    public function run()
    {
        $hkis = [];
        $skema = ['Paten', 'Paten Sederhana', 'Hak Cipta', 'Merek'];

        for ($i = 1; $i <= 10; $i++) {
            // Dua HKI untuk setiap dosen
            $hkis[] = [
                'id_dosen' => $i,
                'judul' => 'Inovasi ' . $i,
                'tahun' => 2020 + $i,
                'skema' => $skema[array_rand($skema)],
                'nomor' => 'HKI-' . (1000 + $i),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
                'bukti' => null,
            ];

            $hkis[] = [
                'id_dosen' => $i,
                'judul' => 'Karya ' . $i,
                'tahun' => 2019 + $i,
                'skema' => $skema[array_rand($skema)],
                'nomor' => 'HKI-' . (2000 + $i),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
                'bukti' => null,
            ];
        }

        DB::table('p_hki')->insert($hkis);
    }
}

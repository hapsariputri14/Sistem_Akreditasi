<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PPenelitianSeeder extends Seeder
{
    public function run()
    {
        $penelitians = [];
        $skema = ['Hibah Dikti', 'Hibah Internal', 'Kerjasama Industri', 'Mandiri'];

        for ($i = 1; $i <= 10; $i++) {
            // Dua penelitian untuk setiap dosen
            $penelitians[] = [
                'id_dosen' => $i,
                'judul_penelitian' => 'Penelitian Dasar ' . $i,
                'skema' => $skema[array_rand($skema)],
                'tahun' => 2020 + $i,
                'dana' => rand(5000000, 20000000),
                'peran' => (rand(0, 1) ? 'ketua' : 'anggota'),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
                'status' => 'tervalidasi',
                'sumber_data' => ($i % 2 == 0) ? 'p3m' : 'dosen',
                'bukti' => null,
            ];

            $penelitians[] = [
                'id_dosen' => $i,
                'judul_penelitian' => 'Penelitian Terapan ' . $i,
                'skema' => $skema[array_rand($skema)],
                'tahun' => 2019 + $i,
                'dana' => rand(3000000, 15000000),
                'peran' => (rand(0, 1) ? 'ketua' : 'anggota'),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
                'status' => 'tervalidasi',
                'sumber_data' => ($i % 2 == 0) ? 'p3m' : 'dosen',
                'bukti' => null,
            ];
        }

        DB::table('p_penelitian')->insert($penelitians);
    }
}

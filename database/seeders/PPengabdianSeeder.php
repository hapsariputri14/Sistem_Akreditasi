<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PPengabdianSeeder extends Seeder
{
    public function run()
    {
        $pengabdians = [];
        $skema = ['KKN', 'PPM', 'Ipteks', 'Pengabdian Mandiri'];

        for ($i = 1; $i <= 10; $i++) {
            // Dua pengabdian untuk setiap dosen
            $pengabdians[] = [
                'id_dosen' => $i,
                'judul_pengabdian' => 'Pengabdian Masyarakat ' . $i,
                'skema' => $skema[array_rand($skema)],
                'tahun' => 2020 + $i,
                'dana' => rand(3000000, 10000000),
                'peran' => (rand(0, 1) ? 'ketua' : 'anggota'),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
            ];

            $pengabdians[] = [
                'id_dosen' => $i,
                'judul_pengabdian' => 'Program Kemitraan ' . $i,
                'skema' => $skema[array_rand($skema)],
                'tahun' => 2019 + $i,
                'dana' => rand(2000000, 8000000),
                'peran' => (rand(0, 1) ? 'ketua' : 'anggota'),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
            ];
        }

        DB::table('p_pengabdian')->insert($pengabdians);
    }
}

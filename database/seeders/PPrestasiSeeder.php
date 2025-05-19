<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PPrestasiSeeder extends Seeder
{
    public function run()
    {
        $prestasis = [];
        $tingkat = ['Lokal', 'Nasional', 'Internasional'];

        for ($i = 1; $i <= 10; $i++) {
            // Dua prestasi untuk setiap dosen
            $prestasis[] = [
                'id_dosen' => $i,
                'prestasi_yang_dicapai' => 'Penghargaan Dosen Berprestasi ' . $i,
                'waktu_pencapaian' => date('Y-m-d', strtotime('-' . (12 - $i) . ' months')),
                'tingkat' => $tingkat[array_rand($tingkat)],
                'status' => 'tervalidasi',
                'sumber_data' => ($i % 2 == 0) ? 'p3m' : 'dosen',
                'bukti' => null,
            ];

            $prestasis[] = [
                'id_dosen' => $i,
                'prestasi_yang_dicapai' => 'Juara ' . $i . ' Lomba Inovasi Pembelajaran',
                'waktu_pencapaian' => date('Y-m-d', strtotime('-' . (6 - $i) . ' months')),
                'tingkat' => $tingkat[array_rand($tingkat)],
                'status' => 'tervalidasi',
                'sumber_data' => ($i % 2 == 0) ? 'p3m' : 'dosen',
                'bukti' => null,
            ];
        }

        DB::table('p_prestasi')->insert($prestasis);
    }
}

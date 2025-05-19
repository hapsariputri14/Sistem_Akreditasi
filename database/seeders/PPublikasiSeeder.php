<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PPublikasiSeeder extends Seeder
{
    public function run()
    {
        $publikasis = [];
        $jenis_publikasi = ['jurnal', 'prosiding', 'poster'];

        for ($i = 1; $i <= 10; $i++) {
            // Dua publikasi untuk setiap dosen
            $publikasis[] = [
                'id_dosen' => $i,
                'judul' => 'Penelitian tentang ' . $i,
                'tempat_publikasi' => 'Jurnal Ilmiah ' . $i,
                'tahun_publikasi' => 2020 + $i,
                'jenis_publikasi' => $jenis_publikasi[array_rand($jenis_publikasi)],
                'dana' => rand(1000000, 5000000),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
                'status' => 'tervalidasi',
                'sumber_data' => ($i % 2 == 0) ? 'p3m' : 'dosen',
                'bukti' => 'contoh.pdf',
            ];

            $publikasis[] = [
                'id_dosen' => $i,
                'judul' => 'Studi Kasus ' . $i,
                'tempat_publikasi' => 'Konferensi Nasional ' . $i,
                'tahun_publikasi' => 2019 + $i,
                'jenis_publikasi' => $jenis_publikasi[array_rand($jenis_publikasi)],
                'dana' => rand(500000, 3000000),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
                'status' => 'tervalidasi',
                'sumber_data' => ($i % 2 == 0) ? 'p3m' : 'dosen',
                'bukti' => 'contoh.pdf',
            ];
        }

        DB::table('p_publikasi')->insert($publikasis);
    }
}

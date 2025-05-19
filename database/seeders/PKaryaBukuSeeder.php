<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PKaryaBukuSeeder extends Seeder
{
    public function run()
    {
        $karyaBukus = [];

        for ($i = 1; $i <= 10; $i++) {
            // Dua karya buku untuk setiap dosen
            $karyaBukus[] = [
                'id_dosen' => $i,
                'judul_buku' => 'Buku Ajar ' . $i,
                'tahun' => 2020 + $i,
                'jumlah_halaman' => rand(100, 300),
                'penerbit' => 'Penerbit ' . $i,
                'isbn' => 'ISBN-' . (900000 + $i),
                'bukti' => null,
            ];

            $karyaBukus[] = [
                'id_dosen' => $i,
                'judul_buku' => 'Modul Pembelajaran ' . $i,
                'tahun' => 2019 + $i,
                'jumlah_halaman' => rand(50, 150),
                'penerbit' => 'Penerbit ' . ($i + 1),
                'isbn' => 'ISBN-' . (800000 + $i),
                'bukti' => null,
            ];
        }

        DB::table('p_karya_buku')->insert($karyaBukus);
    }
}

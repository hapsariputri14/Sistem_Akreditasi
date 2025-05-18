<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PKegiatanSeeder extends Seeder
{
    public function run()
    {
        $kegiatans = [];
        $jenis_kegiatan = ['Lokakarya', 'Workshop', 'Pagelaran', 'Peragaan', 'Pelatihan', 'Lain_lain'];
        $peran = ['penyaji', 'peserta', 'penyaji_dan_peserta'];

        for ($i = 1; $i <= 10; $i++) {
            // Dua kegiatan untuk setiap dosen
            $kegiatans[] = [
                'id_dosen' => $i,
                'jenis_kegiatan' => $jenis_kegiatan[array_rand($jenis_kegiatan)],
                'tempat' => 'Universitas ' . $i,
                'waktu' => date('Y-m-d', strtotime('-' . (10 - $i) . ' months')),
                'peran' => $peran[array_rand($peran)],
            ];

            $kegiatans[] = [
                'id_dosen' => $i,
                'jenis_kegiatan' => $jenis_kegiatan[array_rand($jenis_kegiatan)],
                'tempat' => 'Kampus ' . ($i + 1),
                'waktu' => date('Y-m-d', strtotime('-' . (5 - $i) . ' months')),
                'peran' => $peran[array_rand($peran)],
            ];
        }

        DB::table('p_kegiatan')->insert($kegiatans);
    }
}

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

        $dosenUsers = DB::table('user')
            ->join('level', 'user.id_level', '=', 'level.id_level')
            ->where('level.kode_level', 'DOS')
            ->get();

        foreach ($dosenUsers as $user) {
            $publikasis[] = [
                'id_user' => $user->id_user,

                // Key - Judul tidak boleh sama
                'judul' => 'Penelitian tentang ' . $user->id_user,

                'tempat_publikasi' => 'Jurnal Ilmiah ' . $user->id_user,
                'tahun_publikasi' => rand(2018, 2023),
                'jenis_publikasi' => $jenis_publikasi[array_rand($jenis_publikasi)],
                'dana' => rand(1000000, 5000000),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
                'status' => 'tervalidasi',
                'sumber_data' => ['p3m', 'dosen'][rand(0, 1)],
                'bukti' => 'contoh.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $publikasis[] = [
                'id_user' => $user->id_user,

                // Key - Judul tidak boleh sama
                'judul' => 'Studi Kasus ' . $user->id_user,
                
                'tempat_publikasi' => 'Konferensi Nasional ' . $user->id_user,
                'tahun_publikasi' => rand(2015, 2020),
                'jenis_publikasi' => $jenis_publikasi[array_rand($jenis_publikasi)],
                'dana' => rand(500000, 3000000),
                'melibatkan_mahasiswa_s2' => rand(0, 1),
                'status' => 'tervalidasi',
                'sumber_data' => ['p3m', 'dosen'][rand(0, 1)],
                'bukti' => 'contoh.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('p_publikasi')->insert($publikasis);
    }
}

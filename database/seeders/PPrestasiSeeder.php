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

        $dosenUsers = DB::table('user')
            ->join('level', 'user.id_level', '=', 'level.id_level')
            ->where('level.kode_level', 'DOS')
            ->get();

        foreach ($dosenUsers as $user) {
            $prestasis[] = [
                'id_user' => $user->id_user,

                // Key - Prestasi tidak boleh sama
                'prestasi_yang_dicapai' => 'Penghargaan Dosen Berprestasi ' . $user->id_user,

                'waktu_pencapaian' => date('Y-m-d', strtotime('-' . rand(1, 12) . ' months')),
                'tingkat' => $tingkat[array_rand($tingkat)],
                'status' => 'tervalidasi',
                'sumber_data' => ['p3m', 'dosen'][rand(0, 1)],
                'bukti' => 'contoh.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $prestasis[] = [
                'id_user' => $user->id_user,

                // Key - Prestasi tidak boleh sama
                'prestasi_yang_dicapai' => 'Juara ' . $user->id_user . ' Lomba Inovasi Pembelajaran',
                
                'waktu_pencapaian' => date('Y-m-d', strtotime('-' . rand(1, 12) . ' months')),
                'tingkat' => $tingkat[array_rand($tingkat)],
                'status' => 'tervalidasi',
                'sumber_data' => ['p3m', 'dosen'][rand(0, 1)],
                'bukti' => 'contoh.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('p_prestasi')->insert($prestasis);
    }
}

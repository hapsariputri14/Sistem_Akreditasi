<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            ['nama_level' => 'Administrator', 'kode_level' => 'ADM'],
            ['nama_level' => 'Pengisi Kriteria 1', 'kode_level' => 'ANG1'],
            ['nama_level' => 'Pengisi Kriteria 2', 'kode_level' => 'ANG2'],
            ['nama_level' => 'Pengisi Kriteria 3', 'kode_level' => 'ANG3'],
            ['nama_level' => 'Pengisi Kriteria 4', 'kode_level' => 'ANG4'],
            ['nama_level' => 'Pengisi Kriteria 5', 'kode_level' => 'ANG5'],
            ['nama_level' => 'Pengisi Kriteria 6', 'kode_level' => 'ANG6'],
            ['nama_level' => 'Pengisi Kriteria 7', 'kode_level' => 'ANG7'],
            ['nama_level' => 'Pengisi Kriteria 8', 'kode_level' => 'ANG8'],
            ['nama_level' => 'Pengisi Kriteria 9', 'kode_level' => 'ANG9'],
            ['nama_level' => 'Dosen', 'kode_level' => 'DOS'],
            ['nama_level' => 'Tim Validasi', 'kode_level' => 'VAL'],
            ['nama_level' => 'Direktur', 'kode_level' => 'DIR'],
        ];

        DB::table('level')->insert($levels);
    }
}

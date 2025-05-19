<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class POrganisasiSeeder extends Seeder
{
    public function run()
    {
        $organisasis = [];
        $tingkat = ['Nasional', 'Internasional'];

        for ($i = 1; $i <= 10; $i++) {
            // Dua organisasi untuk setiap dosen
            $organisasis[] = [
                'id_dosen' => $i,
                'nama_organisasi' => 'Asosiasi Profesi ' . $i,
                'kurun_waktu' => (2015 + $i) . '-Sekarang',
                'tingkat' => $tingkat[array_rand($tingkat)],
                'bukti' => null,
            ];

            $organisasis[] = [
                'id_dosen' => $i,
                'nama_organisasi' => 'Ikatan Dosen ' . $i,
                'kurun_waktu' => (2018 + $i) . '-Sekarang',
                'tingkat' => $tingkat[array_rand($tingkat)],
                'bukti' => null,
            ];
        }

        DB::table('p_organisasi')->insert($organisasis);
    }
}

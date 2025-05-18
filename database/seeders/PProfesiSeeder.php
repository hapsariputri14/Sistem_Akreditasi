<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PProfesiSeeder extends Seeder
{
    public function run()
    {
        $profesis = [];

        for ($i = 1; $i <= 10; $i++) {
            // Dua profesi untuk setiap dosen
            $profesis[] = [
                'id_dosen' => $i,
                'perguruan_tinggi' => 'Universitas ' . $i,
                'kurun_waktu' => (2000 + $i) . '-' . (2005 + $i),
                'gelar' => 'Sarjana',
            ];

            $profesis[] = [
                'id_dosen' => $i,
                'perguruan_tinggi' => 'Institut ' . $i,
                'kurun_waktu' => (2005 + $i) . '-' . (2010 + $i),
                'gelar' => 'Magister',
            ];
        }

        DB::table('p_profesi')->insert($profesis);
    }
}

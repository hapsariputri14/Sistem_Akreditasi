<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PProfesiSeeder extends Seeder
{
    public function run()
    {
        $profesis = [];

        $dosenUsers = DB::table('user')
            ->join('level', 'user.id_level', '=', 'level.id_level')
            ->where('level.kode_level', 'DOS')
            ->get();

        foreach ($dosenUsers as $user) {
            $profesis[] = [
                'id_user' => $user->id_user,
                'perguruan_tinggi' => 'Universitas ' . $user->id_user,
                'kurun_waktu' => (rand(2000, 2005)) . '-' . (rand(2006, 2010)),
                'gelar' => 'Sarjana',
                'status' => 'tervalidasi',
                'sumber_data' => ['p3m', 'dosen'][rand(0, 1)],
                'bukti' => 'contoh.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $profesis[] = [
                'id_user' => $user->id_user,
                'perguruan_tinggi' => 'Institut ' . $user->id_user,
                'kurun_waktu' => (rand(2005, 2010)) . '-' . (rand(2011, 2015)),
                'gelar' => 'Magister',
                'status' => 'tervalidasi',
                'sumber_data' => ['p3m', 'dosen'][rand(0, 1)],
                'bukti' => 'contoh.pdf',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('p_profesi')->insert($profesis);
    }
}

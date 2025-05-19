<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PSertifikasiSeeder extends Seeder
{
    public function run()
    {
        $sertifikasis = [];

        for ($i = 1; $i <= 10; $i++) {
            // Dua sertifikasi untuk setiap dosen
            $sertifikasis[] = [
                'id_dosen' => $i,
                'tahun_diperoleh' => 2020 + $i,
                'penerbit' => 'Lembaga Sertifikasi Profesi ' . $i,
                'nama_sertifikasi' => 'Sertifikasi Kompetensi Bidang ' . $i,
                'nomor_sertifikat' => 'SKB-' . (1000 + $i),
                'masa_berlaku' => '5 Tahun',
                'status' => 'tervalidasi',
                'sumber_data' => ($i % 2 == 0) ? 'p3m' : 'dosen',
                'bukti' => 'contoh.pdf',
            ];

            $sertifikasis[] = [
                'id_dosen' => $i,
                'tahun_diperoleh' => 2019 + $i,
                'penerbit' => 'Asosiasi Profesi ' . $i,
                'nama_sertifikasi' => 'Sertifikasi Keahlian Khusus ' . $i,
                'nomor_sertifikat' => 'SKK-' . (2000 + $i),
                'masa_berlaku' => '3 Tahun',
                'status' => 'tervalidasi',
                'sumber_data' => ($i % 2 == 0) ? 'p3m' : 'dosen',
                'bukti' => 'contoh.pdf',
            ];
        }

        DB::table('p_sertifikasi')->insert($sertifikasis);
    }
}

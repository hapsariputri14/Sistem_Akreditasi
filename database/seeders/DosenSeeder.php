<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DosenSeeder extends Seeder
{
    public function run()
    {
        $dosens = [
            [
                'nama_lengkap' => 'Prof. Dr. Ahmad S.T., M.T.',
                'tempat_tanggal_lahir' => 'Jakarta, 15 Januari 1970',
                'nidn' => '1234567801',
                'nip' => '198001011234567890',
                'gelar_depan' => 'Prof. Dr.',
                'gelar_belakang' => 'S.T., M.T.',
                'pendidikan_terakhir' => 'S3',
                'pangkat' => 'Pembina Utama',
                'jabatan_fungsional' => 'Guru Besar',
            ],
            [
                'nama_lengkap' => 'Dr. Budi Santoso S.T., M.Eng.',
                'tempat_tanggal_lahir' => 'Bandung, 20 Februari 1975',
                'nidn' => '1234567802',
                'nip' => '198002021234567891',
                'gelar_depan' => 'Dr.',
                'gelar_belakang' => 'S.T., M.Eng.',
                'pendidikan_terakhir' => 'S3',
                'pangkat' => 'Pembina Utama Muda',
                'jabatan_fungsional' => 'Lektor Kepala',
            ],
            [
                'nama_lengkap' => 'Dr. Citra Dewi S.Kom., M.Kom.',
                'tempat_tanggal_lahir' => 'Surabaya, 10 Maret 1980',
                'nidn' => '1234567803',
                'nip' => '198003031234567892',
                'gelar_depan' => 'Dr.',
                'gelar_belakang' => 'S.Kom., M.Kom.',
                'pendidikan_terakhir' => 'S3',
                'pangkat' => 'Pembina Tk.I',
                'jabatan_fungsional' => 'Lektor',
            ],
            [
                'nama_lengkap' => 'Dedi Setiawan S.Si., M.T.',
                'tempat_tanggal_lahir' => 'Yogyakarta, 5 April 1982',
                'nidn' => '1234567804',
                'nip' => '198004041234567893',
                'gelar_depan' => null,
                'gelar_belakang' => 'S.Si., M.T.',
                'pendidikan_terakhir' => 'S2',
                'pangkat' => 'Pembina',
                'jabatan_fungsional' => 'Asisten Ahli',
            ],
            [
                'nama_lengkap' => 'Eka Putri S.T., M.Sc.',
                'tempat_tanggal_lahir' => 'Semarang, 12 Mei 1985',
                'nidn' => '1234567805',
                'nip' => '198005051234567894',
                'gelar_depan' => null,
                'gelar_belakang' => 'S.T., M.Sc.',
                'pendidikan_terakhir' => 'S2',
                'pangkat' => 'Penata Tk.I',
                'jabatan_fungsional' => 'Asisten Ahli',
            ],
            [
                'nama_lengkap' => 'Fajar Nugraha S.Kom., M.Kom.',
                'tempat_tanggal_lahir' => 'Malang, 25 Juni 1988',
                'nidn' => '1234567806',
                'nip' => '198006061234567895',
                'gelar_depan' => null,
                'gelar_belakang' => 'S.Kom., M.Kom.',
                'pendidikan_terakhir' => 'S2',
                'pangkat' => 'Penata',
                'jabatan_fungsional' => 'Asisten Ahli',
            ],
            [
                'nama_lengkap' => 'Gita Wulandari S.T., M.Eng.',
                'tempat_tanggal_lahir' => 'Denpasar, 30 Juli 1983',
                'nidn' => '1234567807',
                'nip' => '198007071234567896',
                'gelar_depan' => null,
                'gelar_belakang' => 'S.T., M.Eng.',
                'pendidikan_terakhir' => 'S2',
                'pangkat' => 'Penata',
                'jabatan_fungsional' => 'Asisten Ahli',
            ],
            [
                'nama_lengkap' => 'Hendra Pratama S.Si., M.Sc.',
                'tempat_tanggal_lahir' => 'Medan, 8 Agustus 1978',
                'nidn' => '1234567808',
                'nip' => '198008081234567897',
                'gelar_depan' => null,
                'gelar_belakang' => 'S.Si., M.Sc.',
                'pendidikan_terakhir' => 'S2',
                'pangkat' => 'Pembina',
                'jabatan_fungsional' => 'Lektor',
            ],
            [
                'nama_lengkap' => 'Ir. Indah Permata Sari M.T.',
                'tempat_tanggal_lahir' => 'Palembang, 17 September 1976',
                'nidn' => '1234567809',
                'nip' => '198009091234567898',
                'gelar_depan' => 'Ir.',
                'gelar_belakang' => 'M.T.',
                'pendidikan_terakhir' => 'S2',
                'pangkat' => 'Pembina Tk.I',
                'jabatan_fungsional' => 'Lektor',
            ],
            [
                'nama_lengkap' => 'Dr. Joko Susilo S.T., M.Eng.',
                'tempat_tanggal_lahir' => 'Solo, 22 Oktober 1973',
                'nidn' => '1234567810',
                'nip' => '198010101234567899',
                'gelar_depan' => 'Dr.',
                'gelar_belakang' => 'S.T., M.Eng.',
                'pendidikan_terakhir' => 'S3',
                'pangkat' => 'Pembina Utama Muda',
                'jabatan_fungsional' => 'Lektor Kepala',
            ],
        ];

        DB::table('dosen')->insert($dosens);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            // Administrator
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Admin Sistem',
                'jabatan' => 'Administrator',
                'no_telp' => '081234567890',
                'alamat' => 'Jl. Admin No. 1',
                'id_level' => 1,
            ],
            // Pengisi Kriteria 1-9
            [
                'username' => 'kriteria1',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 1',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567891',
                'alamat' => 'Jl. Kampus No. 1',
                'id_level' => 2,
            ],
            [
                'username' => 'kriteria2',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 2',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567892',
                'alamat' => 'Jl. Kampus No. 2',
                'id_level' => 3,
            ],
            [
                'username' => 'kriteria3',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 3',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567893',
                'alamat' => 'Jl. Kampus No. 3',
                'id_level' => 4,
            ],
            [
                'username' => 'kriteria4',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 4',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567894',
                'alamat' => 'Jl. Kampus No. 4',
                'id_level' => 5,
            ],
            [
                'username' => 'kriteria5',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 5',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567895',
                'alamat' => 'Jl. Kampus No. 5',
                'id_level' => 6,
            ],
            [
                'username' => 'kriteria6',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 6',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567896',
                'alamat' => 'Jl. Kampus No. 6',
                'id_level' => 7,
            ],
            [
                'username' => 'kriteria7',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 7',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567897',
                'alamat' => 'Jl. Kampus No. 7',
                'id_level' => 8,
            ],
            [
                'username' => 'kriteria8',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 8',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567898',
                'alamat' => 'Jl. Kampus No. 8',
                'id_level' => 9,
            ],
            [
                'username' => 'kriteria9',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 9',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567899',
                'alamat' => 'Jl. Kampus No. 9',
                'id_level' => 10,
            ],
            // Dosen
            [
                'username' => 'dosen1',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Prof. Dr. Ahmad S.T., M.T.',
                'jabatan' => 'Dosen Tetap',
                'no_telp' => '081234567811',
                'alamat' => 'Jl. Dosen No. 1',
                'id_level' => 11,
            ],
            // Tim Validasi
            [
                'username' => 'validasi',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Tim Validasi',
                'jabatan' => 'Validator',
                'no_telp' => '081234567812',
                'alamat' => 'Jl. Kampus No. 10',
                'id_level' => 12,
            ],
            // Direktur
            [
                'username' => 'direktur',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Dr. Bambang S.T., M.T.',
                'jabatan' => 'Direktur',
                'no_telp' => '081234567813',
                'alamat' => 'Jl. Direktur No. 1',
                'id_level' => 13,
            ],
        ];

        DB::table('user')->insert($users);
    }
}

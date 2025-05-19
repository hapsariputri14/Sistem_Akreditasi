<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Data user utama
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
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kriteria 1-9
            [
                'username' => 'kriteria1',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 1',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567891',
                'alamat' => 'Jl. Kampus No. 1',
                'id_level' => 2,
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kriteria2',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 2',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567892',
                'alamat' => 'Jl. Kampus No. 2',
                'id_level' => 3,
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kriteria3',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 3',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567893',
                'alamat' => 'Jl. Kampus No. 3',
                'id_level' => 4,
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kriteria4',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 4',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567894',
                'alamat' => 'Jl. Kampus No. 4',
                'id_level' => 5,
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kriteria5',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 5',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567895',
                'alamat' => 'Jl. Kampus No. 5',
                'id_level' => 6,
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kriteria6',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 6',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567896',
                'alamat' => 'Jl. Kampus No. 6',
                'id_level' => 7,
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kriteria7',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 7',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567897',
                'alamat' => 'Jl. Kampus No. 7',
                'id_level' => 8,
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kriteria8',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 8',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567898',
                'alamat' => 'Jl. Kampus No. 8',
                'id_level' => 9,
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'kriteria9',
                'password' => Hash::make('password'),
                'nama_lengkap' => 'Petugas Kriteria 9',
                'jabatan' => 'Staf Akademik',
                'no_telp' => '081234567899',
                'alamat' => 'Jl. Kampus No. 9',
                'id_level' => 10,
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
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
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
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
                'id_dosen' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Insert user utama
        DB::table('user')->insert($users);

        // Get all dosen from database
        $allDosen = DB::table('dosen')->get();

        // Create user accounts for each dosen
        foreach ($allDosen as $dosen) {
            // Generate username from nama_lengkap
            $username = strtolower(preg_replace('/[^a-zA-Z]/', '', $dosen->nama_lengkap));

            // Check if username already exists
            $existingUser = DB::table('user')->where('username', $username)->first();
            $counter = 1;

            while ($existingUser) {
                $username = $username . $counter;
                $existingUser = DB::table('user')->where('username', $username)->first();
                $counter++;
            }

            // Create user for dosen
            DB::table('user')->insert([
                'username' => $username,
                'password' => Hash::make('password'),
                'nama_lengkap' => $dosen->nama_lengkap,
                'jabatan' => $dosen->jabatan_fungsional,
                'no_telp' => '08' . rand(100000000, 999999999), // Random phone number
                'alamat' => 'Jl. Dosen ' . rand(1, 100),
                'id_level' => 11, // Level DOS (Dosen)
                'id_dosen' => $dosen->id_dosen,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

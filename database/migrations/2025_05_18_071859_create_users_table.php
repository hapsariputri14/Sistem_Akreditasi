<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 50)->unique();
            $table->string('password', 255);
            $table->string('nama_lengkap', 100);
            $table->string('jabatan', 100);
            $table->string('no_telp', 20);
            $table->text('alamat');

            // Tambahkan foreign key ke tabel dosen
            $table->foreignId('id_dosen')->nullable()->constrained('dosen', 'id_dosen')->nullOnDelete();

            // Tambahkan foreign key ke tabel level
            $table->foreignId('id_level')->constrained('level', 'id_level');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
};

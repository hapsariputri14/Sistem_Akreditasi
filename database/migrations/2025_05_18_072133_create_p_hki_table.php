<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('p_hki', function (Blueprint $table) {
            $table->id('id_hki');
            $table->foreignId('id_dosen')->constrained('dosen', 'id_dosen');
            $table->string('judul', 255);
            $table->year('tahun');
            $table->string('skema', 100);
            $table->string('nomor', 100);
            $table->boolean('melibatkan_mahasiswa_s2');
            $table->enum('status', ['tervalidasi', 'perlu validasi'])->default('tervalidasi');
            $table->enum('sumber_data', ['p3m', 'dosen'])->default('dosen');
            $table->string('bukti')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('p_hki');
    }
};

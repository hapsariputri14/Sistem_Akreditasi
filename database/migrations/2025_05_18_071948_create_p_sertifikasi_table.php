<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('p_sertifikasi', function (Blueprint $table) {
            $table->id('id_sertifikasi');
            $table->foreignId('id_dosen')->constrained('dosen', 'id_dosen');
            $table->year('tahun_diperoleh');
            $table->string('penerbit', 100);
            $table->string('nama_sertifikasi', 255);
            $table->string('nomor_sertifikat', 100);
            $table->string('masa_berlaku', 50);
            $table->string('bukti')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('p_sertifikasi');
    }
};

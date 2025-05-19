<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('p_penelitian', function (Blueprint $table) {
            $table->id('id_penelitian');
            $table->foreignId('id_dosen')->constrained('dosen', 'id_dosen');
            $table->string('judul_penelitian', 255);
            $table->string('skema', 100);
            $table->year('tahun');
            $table->decimal('dana', 15, 2);
            $table->enum('peran', ['ketua', 'anggota']);
            $table->boolean('melibatkan_mahasiswa_s2');
            $table->string('bukti')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('p_penelitian');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('p_prestasi', function (Blueprint $table) {
            $table->id('id_prestasi');
            $table->foreignId('id_dosen')->constrained('dosen', 'id_dosen');
            $table->string('prestasi_yang_dicapai', 255);
            $table->date('waktu_pencapaian');
            $table->enum('tingkat', ['Lokal', 'Nasional', 'Internasional']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('p_prestasi');
    }
};

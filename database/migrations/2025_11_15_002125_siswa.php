<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
         Schema::create('siswa', function (Blueprint $table) {
            $table->string('nisn', 10)->primary();
            $table->string('nis', 8);
            $table->string('username');
            $table->string('password'); 
            $table->string('nama', 35);
            $table->integer('id_kelas')->unsigned();
            $table->text('alamat')->nullable();
            $table->string('no_telp', 13);
            $table->integer('id_spp')->unsigned();

            // Foreign Key
            $table->foreign('id_kelas')->references('id_kelas')->on('kelas')
                  ->onDelete('cascade');
            $table->foreign('id_spp')->references('id_spp')->on('spp')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};

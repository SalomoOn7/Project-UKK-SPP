<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('petugas', function (Blueprint $table) {
            $table->increments('id_petugas');
            $table->string('username', 225);
            $table->string('password', 225);
            $table->string('nama_petugas', 225);
            $table->enum('level', ['admin', 'petugas']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('petugas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('spp', function (Blueprint $table) {
            $table->increments('id_spp');
            $table->integer('tahun');
            $table->integer('nominal');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('spp');
    }
};

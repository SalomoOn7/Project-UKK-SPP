<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id');
        $table->enum('user_type', ['admin', 'petugas', 'siswa']);
        $table->string('aktivitas'); // login / logout
        $table->timestamp('waktu')->useCurrent();
        $table->string('ip_address')->nullable();
        $table->text('user_agent')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

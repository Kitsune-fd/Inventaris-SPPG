<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id();
            $table->string('npsn', 50)->unique();
            $table->string('nama_sekolah');
            $table->string('jenjang', 20)->default('SD');
            $table->string('kecamatan')->nullable();
            $table->text('alamat')->nullable();
            $table->integer('jumlah_siswa')->default(0);
            $table->integer('porsi')->default(0);
            $table->enum('status_distribusi', ['terkirim', 'proses', 'menunggu'])->default('proses');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};

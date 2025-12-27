<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('warga_id')->constrained('wargas')->onDelete('cascade'); // Relasi ke Kepala Keluarga
            $table->string('nama_lengkap');
            $table->string('nik', 16)->unique();
            $table->string('hubungan_keluarga'); // Istri, Anak, Orang Tua, dll
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_keluarga');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Akun login
            $table->string('nama_lengkap');
            $table->string('nik', 16)->unique();
            $table->string('no_kk', 16);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->text('alamat_rumah');
            $table->string('foto_ktp')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->enum('status_verifikasi', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_iuran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_iuran'); // Contoh: Kebersihan, Keamanan, Kas RT, Perbaikan Jalan, Santunan
            $table->decimal('nominal', 12, 2);
            $table->boolean('is_active')->default(true); // Bisa dimatikan/hidupkan oleh pengurus
            $table->boolean('is_mandatory')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_iuran');
    }
};

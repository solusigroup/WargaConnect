<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_iuran_id')->constrained('kategori_iuran')->onDelete('cascade');
            $table->integer('month');
            $table->integer('year');
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['unpaid', 'paid', 'arrears'])->default('unpaid'); // arrears = menunggak
            $table->date('due_date')->nullable();
            $table->timestamps();
            
            // Unique constraint to prevent duplicate bills for same category/month/year/user
            $table->unique(['user_id', 'kategori_iuran_id', 'month', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};

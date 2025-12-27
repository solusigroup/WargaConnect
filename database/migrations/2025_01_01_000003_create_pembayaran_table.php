<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('tagihan')->onDelete('cascade');
            $table->string('transaction_id')->nullable(); // For Midtrans or manual ref
            $table->decimal('amount', 10, 2);
            $table->enum('method', ['cash', 'transfer', 'qris']);
            $table->string('proof_path')->nullable(); // For manual transfer
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};

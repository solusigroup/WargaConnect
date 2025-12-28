<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_settings', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->default('Bank BCA');
            $table->string('account_number')->default('8720991234');
            $table->string('account_holder')->default('Bendahara RT 35');
            $table->string('dana_number')->default('081234567890'); // No HP Dana RT
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank_settings');
    }
};

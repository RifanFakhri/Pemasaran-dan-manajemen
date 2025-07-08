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
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id'); // Diganti dari $table->id()
            $table->string('nama', 100);
            $table->string('no_hp', 20);
            $table->string('email', 100);
            $table->date('tanggal_datang');
            $table->enum('status', ['baru', 'follow_up', 'booking', 'pembeli', 'cancelled'])->default('baru');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

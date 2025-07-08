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
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->enum('status_transaksi', ['lunas', 'belum'])->default('belum');
            $table->enum('lama_angsuran', ['10', '15', '20', '25'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
            $table->dropColumn('status_transaksi');
            $table->dropColumn('lama_angsuran');
        });
    }
};

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
            $table->decimal('uang_booking', 15, 2)->nullable()->after('lama_angsuran');
            $table->decimal('uang_muka', 15, 2)->nullable()->after('uang_booking');
            $table->text('catatan')->nullable()->after('uang_muka');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
           $table->dropColumn(['uang_booking', 'uang_muka', 'catatan']);
        });
    }
};

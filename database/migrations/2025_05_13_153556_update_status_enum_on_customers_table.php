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
        DB::statement("ALTER TABLE customers MODIFY status ENUM('baru', 'follow_up', 'booking', 'pembeli', 'cancelled', 'tidak_tertarik') DEFAULT 'baru'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         DB::statement("ALTER TABLE customers MODIFY status ENUM('baru', 'follow_up', 'booking', 'pembeli', 'cancelled') DEFAULT 'baru'");
    }
};

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
    $table->unsignedInteger('created_by')->nullable()->after('customer_id');
    $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanan', function (Blueprint $table) {
              $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');
       
        });
    }
};

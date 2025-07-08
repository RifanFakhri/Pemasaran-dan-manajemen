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
         Schema::table('berkas_kpr', function (Blueprint $table) {
            // 1. Hapus kolom nama yang sudah ada
            
            // 2. Tambahkan kolom customer_id sebagai foreign key
            $table->unsignedBigInteger('customer_id')->after('id');
            
            // 3. Tambahkan constraint foreign key
           $table->unsignedInteger('customer_id')->after('id');
$table->foreign('customer_id')
      ->references('id')
      ->on('customers')
      ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('berkas_kpr', function (Blueprint $table) {
            // 1. Hapus foreign key constraint
            $table->dropForeign(['customer_id']);
            
            // 2. Hapus kolom customer_id
            $table->dropColumn('customer_id');
            
          

        });
    }
};

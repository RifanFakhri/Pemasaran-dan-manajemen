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
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->increments('id'); // Ganti dari $table->id()
            $table->string('invoice')->unique();
            $table->unsignedInteger('rumah_id');    // Ganti dari unsignedBigInteger
            $table->unsignedInteger('customer_id'); // Ganti dari unsignedBigInteger
            $table->enum('jenis_pembayaran', ['KPR', 'Cash', 'Inhouse']);
            $table->date('tanggal_pesan');
            $table->timestamps();

            $table->foreign('rumah_id')->references('id')->on('rumah')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};

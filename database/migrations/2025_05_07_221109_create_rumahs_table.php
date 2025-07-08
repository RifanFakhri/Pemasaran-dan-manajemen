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
        Schema::create('rumah', function (Blueprint $table) {
            $table->increments('id'); // Ganti dari $table->id()
            $table->unsignedInteger('blok_id'); // Ganti dari unsignedBigInteger
            $table->string('nomor_rumah', 10);
            $table->integer('luas_bangunan');
            $table->integer('luas_tanah');
            $table->bigInteger('harga');
            $table->enum('status', ['tersedia', 'booking', 'terjual'])->default('tersedia');
            $table->foreign('blok_id')->references('id')->on('bloks')->onDelete('cascade');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah');
    }
};

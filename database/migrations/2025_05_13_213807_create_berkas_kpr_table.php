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
        Schema::create('berkas_kpr', function (Blueprint $table) {
            $table->increments('id'); // Ubah dari $table->id()
            $table->string('ktp')->nullable();
            $table->string('kk')->nullable();
            $table->string('surat_nikah')->nullable();
            $table->string('npwp')->nullable();
            $table->string('siup')->nullable();
            $table->string('jamsostek')->nullable();
            $table->string('kartu_pegawai')->nullable();
            $table->string('foto')->nullable();
            $table->string('surat_bekerja')->nullable();
            $table->string('sk_karyawan')->nullable();
            $table->string('slip_gaji')->nullable();
            $table->string('rekening')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_kpr');
    }
};

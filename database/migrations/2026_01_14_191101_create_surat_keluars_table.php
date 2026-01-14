<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->id();
            $table->string('no_surat'); // Hasil generate, misal: 470/01/2025
            $table->date('tanggal_surat');

            // Relasi ke User (Petugas yang melayani)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Relasi ke Jenis Surat
            $table->foreignId('jenis_surat_id')->constrained('jenis_surats')->onDelete('cascade');

            // Relasi ke Penduduk (Custom karena PK-nya String NIK)
            $table->char('penduduk_nik', 16);
            $table->foreign('penduduk_nik')
                ->references('nik')
                ->on('penduduks')
                ->onDelete('cascade'); // Hati-hati, jika warga dihapus, riwayat surat hilang

            $table->text('keterangan')->nullable(); // Keperluan surat
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keluars');
    }
};

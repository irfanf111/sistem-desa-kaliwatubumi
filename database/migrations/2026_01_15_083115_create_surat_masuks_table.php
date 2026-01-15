<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->id();
            $table->string('asal_surat'); // Misal: dari Camat Butuh
            $table->string('no_surat');
            $table->date('tanggal_surat'); // Tanggal yang tertera di surat
            $table->date('tanggal_terima'); // Tanggal surat sampai di desa
            $table->string('perihal');
            $table->string('file_lampiran')->nullable(); // Untuk upload foto/PDF surat
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_masuks');
    }
};

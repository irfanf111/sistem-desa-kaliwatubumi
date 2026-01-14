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
        Schema::create('jenis_surats', function (Blueprint $table) {
            $table->id();
            $table->string('kode_surat', 10); // Contoh: 470, 474
            $table->string('nama_surat');     // Contoh: Surat Keterangan Usaha
            $table->string('kop_surat')->default('default'); // Opsional: jika ada beda kop
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_surats');
    }
};

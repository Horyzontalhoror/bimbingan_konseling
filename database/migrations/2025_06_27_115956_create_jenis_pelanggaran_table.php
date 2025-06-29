<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');        // Contoh: Bolos, Berkelahi
            $table->integer('poin');       // Contoh: 100, 95
            $table->text('keterangan');    // Deskripsi lengkap
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_pelanggaran');
    }
};

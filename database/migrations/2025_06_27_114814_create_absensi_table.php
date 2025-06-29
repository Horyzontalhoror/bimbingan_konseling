<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->string('nisn');
            $table->date('tanggal');
            $table->boolean('hadir')->default(false);
            $table->boolean('sakit')->default(false);
            $table->boolean('izin')->default(false);
            $table->boolean('alpa')->default(false);
            $table->boolean('bolos')->default(false);
            $table->timestamps();

            // Disesuaikan dengan nama tabel students
            $table->foreign('nisn')->references('nisn')->on('students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};

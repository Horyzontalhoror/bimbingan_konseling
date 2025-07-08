<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('call_letters', function (Blueprint $table) {
            $table->string('waktu_pertemuan')->nullable();
            $table->string('tempat_pertemuan')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('call_letters', function (Blueprint $table) {
            $table->dropColumn(['waktu_pertemuan', 'tempat_pertemuan']);
        });
    }
};

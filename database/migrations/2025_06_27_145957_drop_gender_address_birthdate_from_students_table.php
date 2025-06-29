<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['gender', 'address', 'birth_date']);
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('address')->nullable();
            $table->date('birth_date')->nullable();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('users', function ($table) {
            $table->string('profile_photo_path')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('users', function ($table) {
            $table->dropColumn('profile_photo_path');
        });
    }

};

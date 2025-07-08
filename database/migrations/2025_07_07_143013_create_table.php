<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Tabel students
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->unique();
            $table->string('name');
            $table->string('class');
            $table->timestamps();
        });

        // 2. Tabel nilai
        Schema::create('nilai', function (Blueprint $table) {
            $table->id();
            $table->string('nisn');
            $table->float('bindo')->nullable();
            $table->float('bing')->nullable();
            $table->float('mat')->nullable();
            $table->float('ipa')->nullable();
            $table->float('ips')->nullable();
            $table->float('agama')->nullable();
            $table->float('ppkn')->nullable();
            $table->float('sosbud')->nullable();
            $table->float('tik')->nullable();
            $table->float('penjas')->nullable();
            $table->float('rata_rata')->nullable();
            $table->float('jumlah_nilai')->nullable();
            $table->timestamps();

            $table->foreign('nisn')->references('nisn')->on('students')->onDelete('cascade');
        });

        // 3. Tabel absensi
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->string('nisn');
            $table->date('tanggal');
            $table->tinyInteger('hadir')->default(0);
            $table->tinyInteger('sakit')->default(0);
            $table->tinyInteger('izin')->default(0);
            $table->tinyInteger('alpa')->default(0);
            $table->tinyInteger('bolos')->default(0);
            $table->timestamps();

            $table->foreign('nisn')->references('nisn')->on('students')->onDelete('cascade');
        });

        // 4. Tabel jenis_pelanggaran
        Schema::create('jenis_pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->integer('poin');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });

        // 5. tabel pelanggran
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->string('nisn')->index(); // tambahkan index agar pencarian lebih cepat
            $table->foreign('nisn')->references('nisn')->on('students')->onDelete('cascade');

            $table->foreignId('jenis_pelanggaran_id')->nullable()
                ->constrained('jenis_pelanggaran')->nullOnDelete();

            $table->date('date');
            $table->string('type')->nullable(); // Tambahan: jika kamu tetap pakai kolom 'type' di seeder
            $table->text('description')->nullable();
            $table->text('action')->nullable();
            $table->timestamps();
        });


        // 6. Tabel rekomendasi_siswa
        Schema::create('rekomendasi_siswa', function (Blueprint $table) {
            $table->id();
            $table->string('nisn');
            $table->string('kategori');
            $table->string('metode');
            $table->string('sumber');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('nisn')->references('nisn')->on('students')->onDelete('cascade');
        });

        // 7. Tabel counseling_schedules
        Schema::create('counseling_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('nisn');
            $table->date('date');
            $table->time('time');
            $table->string('note')->nullable();
            $table->string('status')->default('Terjadwal');
            $table->timestamps();

            $table->foreign('nisn')->references('nisn')->on('students')->onDelete('cascade');
        });

        // 8. Tabel konfigurasi_kmeans
        Schema::create('konfigurasi_kmeans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_centroid');
            $table->string('tipe'); // nilai / absen / pelanggaran
            $table->json('centroid');
            $table->string('kategori');
            $table->timestamps();
        });

        // 9. konfigurasi absensi
        Schema::create('konfigurasi_absensi', function (Blueprint $table) {
            $table->id();
            $table->string('jenis'); // misal: H, S, I, A, B
            $table->decimal('bobot', 4, 2); // nilai bobot
            $table->integer('max_jumlah')->nullable(); // batas maksimal jika diperlukan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konfigurasi_kmeans');
        Schema::dropIfExists('counseling_schedules');
        Schema::dropIfExists('rekomendasi_siswa');
        Schema::dropIfExists('violations');
        Schema::dropIfExists('jenis_pelanggaran');
        Schema::dropIfExists('absensi');
        Schema::dropIfExists('nilai');
        Schema::dropIfExists('students');
    }
};
